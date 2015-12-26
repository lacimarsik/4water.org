#!/usr/bin/python3

# This is a script that can be used to get live content to localhost. 
# The first step - exporting the tables of remote WP database must be done manually (e.g. in 
# phpmyadmin). Then this script can be used, provided you set the correct constants in accompanying
# file live2loc_settings.py.
#
# The script works in 2 phases
# - downloading the content of wp-content/uploads through FTP
# - replacing locally the wordpress SQL tables with those from the provided SQL file (remote export)
#
# Note: I usually export all wp tables except for user-related.

# ---------------------------------------------------------------
# Imports
# ---------------------------------------------------------------

import sys
import getopt
import re
import subprocess
import getpass
import ftplib
import os
import re
import live2loc_settings as st

# ---------------------------------------------------------------
# Settings
# ---------------------------------------------------------------

# file names for temporary or backup SQL files
SQL_FILES_PREFIX = 'db-'
LOCAL_DB_BCK_SQL = SQL_FILES_PREFIX + 'local-bck.sql'
REMOTE_DB_SQL = SQL_FILES_PREFIX + 'remote-export.sql'

# ---------------------------------------------------------------
# Methods
# ---------------------------------------------------------------

def print_help():
    print(
        """Usage:
        live2loc [options] [sql file]
        - gets the live content to localhost, including importing the SQL DB given by filename (if
            provided)

        For correct functioning, set the constants in file live2loc_settings.py.

        Options:
        -h, --help:                shows this help
        -n, --nodl:                does not download the uploaded media
        """)

def confirm(prompt=None, resp=False):
    """Prompts for yes or no response from the user. Returns True for yes and False for no.

    'resp' should be set to the default value assumed by the caller when
    user simply types ENTER.
    """
    if prompt is None:
        prompt = 'Confirm'

    if resp:
        prompt = '%s [%s]|%s: ' % (prompt, 'y', 'n')
    else:
        prompt = '%s [%s]|%s: ' % (prompt, 'n', 'y')
        
    while True:
        ans = input(prompt)
        if not ans:
            return resp
        if ans not in ['y', 'Y', 'n', 'N']:
            print('please enter y or n.')
            continue
        if ans == 'y' or ans == 'Y':
            return True
        if ans == 'n' or ans == 'N':
            return False

def download_uploads():
    """Downloads the media uploaded on live server to localhost"""

    print("\n\n" + '*'*100 + "\n")
    print("Going to download the live media content from \"uploads\" folder")
    ftp = ftplib.FTP('salsa.forma.sk')
    pw = getpass.getpass("Please enter password for the user '{}' on {}: \n".format(
        st.FTP_USER, st.FTP_ADDRESS))
    ftp.login(st.FTP_USER, pw)

    root = ftp.pwd()

    def download_dir_tree(path):
        try:
            # list what's in there (on live server)
            ftp.cwd(os.path.join(root, path))
            file_list = [f for f in ftp.nlst() if f not in ['.', '..']]
        except ftplib.error_perm:
            # it's probably not a dir - try to download and return
            print("\tDownloading {}".format(os.path.join(root, path)))
            loc_file = open(path,"wb")
            ftp.retrbinary("RETR "+ os.path.join(root, path), loc_file.write)
            return

        # make a new dir locally if it does not exist
        if not os.path.exists(path):
            os.mkdir(path)

        # proceed recursively
        for item in file_list:
            download_dir_tree(os.path.join(path, item))

    download_dir_tree('wp-content/uploads')

def import_wp_db(rem_sql_fname):
    """Imports the remote wordpress SQL database from the provided filename to localhost"""

    print("\n\n" + '*'*100 + "\n")
    print("Going to imports the remote wordpress SQL database")

    #get password for the local DB
    local_pw = st.LOCAL_PW
    if local_pw is None:
        local_pw = getpass.getpass("Input password for the user " + st.LOCAL_USER_NAME + " in local DB:\n")

    #remove old backup of a local database
    print("Removing old backup of local database... ")
    subprocess.call("rm " + LOCAL_DB_BCK_SQL, shell=True)
    print("OK")

    #backup local database
    print("Making backup of local database...")
    cmd = "mysqldump -v -u {} -p{} {} > {}".format(
        st.LOCAL_USER_NAME, 
        local_pw,
        st.LOCAL_DB_NAME,
        LOCAL_DB_BCK_SQL)
    output, _ = subprocess.Popen(cmd, shell=True, stdout=subprocess.PIPE).communicate()
    print("OK")

    #modify couple of things from remote DB sql file
    print("Modifying a few things in SQL file")
    with open(rem_sql_fname, 'r') as rem_sql_file:
        lines = rem_sql_file.readlines()
    with open(REMOTE_DB_SQL, 'w') as rem_sql_file:
        for line in lines:
            if st.CUSTOMIZER_KEY in line: 
                rem_sql_file.write(process_customizer_line(line))
            else:
                rem_sql_file.write(line.replace(st.REMOTE_URL, st.LOCAL_URL))
            
    print("OK")

    try:
        #find out which tables are gonna be imported from SQL file
        print("Finding out which tables are being imported from the SQL file...")
        with open(REMOTE_DB_SQL, 'r') as rem_sql_file:
            content = rem_sql_file.read()
            tables = re.findall(r'CREATE TABLE IF NOT EXISTS `(wp_.+)` \(', content)

        #drop tables from local wordpress DB
        print("Dropping tables " + ", ".join(tables) + " from local wordpress DB...")
        sql_cmd = 'DROP TABLE ' + ", ".join(tables)
        cmd = "mysql -v -u {} -p{} {} -e \"{}\"".format(
            st.LOCAL_USER_NAME, 
            local_pw,
            st.LOCAL_DB_NAME,
            sql_cmd)
        output, _ = subprocess.Popen(cmd, shell=True, stdout=subprocess.PIPE).communicate()
        print("OK")

        #import the remote DB sql export to the local db
        print("Importing the remote export to local DB...")
        cmd = "mysql -v -u {} -p{} {} < {}".format(
            st.LOCAL_USER_NAME, 
            local_pw,
            st.LOCAL_DB_NAME,
            REMOTE_DB_SQL)
        output, _ = subprocess.Popen(cmd, shell=True, stdout=subprocess.PIPE).communicate()
        print("OK")
    finally:
        #remove the modified export of remote DB
        print("Removing the modified export of remote DB... ")
        subprocess.call("rm " + REMOTE_DB_SQL, shell=True)
        print("OK")

    print("Finito! If something does not work, you still have a backup of the previous local DB at " + 
        os.path.abspath(LOCAL_DB_BCK_SQL))

def process_customizer_line(line):
    """Replaces links in the customizer database row, preserving the its format.

    Returns a new customizer row
    """

    diff = len(st.LOCAL_URL) - len(st.REMOTE_URL)

    items = re.split(r'(s:\d+:)', line[:-1])
    new_line = items[0]
    for i in range(len(items) // 2):
        length = int(re.search(r'(\d+)', items[2*i + 1]).group(0))
        text = items[2*i + 2]
        occ = text.count(st.REMOTE_URL)
        text = text.replace(st.REMOTE_URL, st.LOCAL_URL)
        entry = 's:{}:{}'.format(length + occ*diff, text)
        new_line += entry

    return new_line

# ---------------------------------------------------------------
# Main
# ---------------------------------------------------------------

def main():
    # parse command line args
    argv = sys.argv[1:]

    try:
        opts, args = getopt.getopt(argv, "hn",["help", "nodl"])
    except getopt.GetoptError:
        print_help()
        sys.exit()
       
    dl = True
    for opt, arg in opts:
        if opt in ('-h', "--help"):
            print_help()
            sys.exit()
        elif opt in ('-n', "--nodl"):
            dl = False
        else:
            print("Unknown option")
            print_help()
            sys.exit()

    # download media
    if dl:
        download_uploads()

    # import WP from given sql file
    if len(args) <= 0:
        return
    import_wp_db(args[0])


if __name__ == '__main__':
    main()

