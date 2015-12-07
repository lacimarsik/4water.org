#!/usr/bin/python3

# This is a script that can be used to import a remote wordpress database to localhost. 
# The first step - exporting the tables of remote WP database must be done manually (e.g. in 
# phpmyadmin). Then this script can be used, provided you set the correct constants further
# below in this source code (above main method)
#
# This script only works with the SQL database - it does not move any media files. Thus if the 
# customized content (from customizer) contains links to images, these will not be changed and 
# will be served from live server. (Todo - this can be improved in the future)

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

# ---------------------------------------------------------------
# Methods
# ---------------------------------------------------------------

def print_help():
    print(
"""Usage:
impwpdb <sql file>
- imports the given SQL file - the export of a remote wordpress DB

For correct functioning, set the constants in the script's source (above the main method).

Options:
-h, --help:                shows this help
""")

def confirm(prompt=None, resp=False):
    """prompts for yes or no response from the user. Returns True for yes and
    False for no.

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

# ---------------------------------------------------------------
# Main
# ---------------------------------------------------------------

# URLs
LOCAL_URL = 'http://localhost/4water'
REMOTE_URL = 'http://salsa.forma.sk'

# DB names
LOCAL_DB_NAME = 'weare4water'
REMOTE_DB_NAME = 'salsa4water'

# SQL file names
SQL_FILES_PREFIX = 'db-'
LOCAL_DB_BCK_SQL = SQL_FILES_PREFIX + 'local-bck.sql'
REMOTE_DB_SQL = SQL_FILES_PREFIX + 'remote-export.sql'

# connection details
LOCAL_USER_NAME = 'root'
LOCAL_PW = None  #keep none = pw will be asked for
REMOTE_HOST = 'salsa.forma.sk'
REMOTE_USER_NAME = 'salsa09'

# others
CUSTOMIZER_KEY = 'theme_mods_Parallax-One'

def main():
    # parse command line args
    argv = sys.argv[1:]

    try:
        opts, args = getopt.getopt(argv, "h",["help"])
    except getopt.GetoptError:
        print_help()
        sys.exit()
       
    filelist = []
    for opt, arg in opts:
        if opt in ('-h', "--help"):
            print_help()
            sys.exit()
        else:
            print("Unknown option")
            print_help()
            sys.exit()

    if len(args) <= 0:
        print("Need one argument - the SQL file to import")
        print_help()
        sys.exit()
    rem_sql_fname = args[0]

    #get password for the local DB
    local_pw = LOCAL_PW
    if local_pw is None:
        local_pw = getpass.getpass("Input password for the user " + LOCAL_USER_NAME + " in local DB:\n")

    #remove old backup of a local database
    print("Removing old backup of local database... ")
    subprocess.call("rm " + LOCAL_DB_BCK_SQL, shell=True)
    print("OK")

    #backup local database
    print("Making backup of local database...")
    cmd = "mysqldump -v -u {} -p{} {} > {}".format(
        LOCAL_USER_NAME, 
        local_pw,
        LOCAL_DB_NAME,
        LOCAL_DB_BCK_SQL)
    output, _ = subprocess.Popen(cmd, shell=True, stdout=subprocess.PIPE).communicate()
    print("OK")

    #modify couple of things from remote DB sql file
    print("Modifying a few things in SQL file")
    with open(rem_sql_fname, 'r') as rem_sql_file:
        lines = rem_sql_file.readlines()
    with open(REMOTE_DB_SQL, 'w') as rem_sql_file:
        for line in lines:
            if CUSTOMIZER_KEY in line:  #don't touch the customizer row in database
                rem_sql_file.write(line)
            else:
                rem_sql_file.write(line.replace(REMOTE_URL, LOCAL_URL))
            
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
            LOCAL_USER_NAME, 
            local_pw,
            LOCAL_DB_NAME,
            sql_cmd)
        output, _ = subprocess.Popen(cmd, shell=True, stdout=subprocess.PIPE).communicate()
        print("OK")

        #import the remote DB sql export to the local db
        print("Importing the remote export to local DB...")
        cmd = "mysql -v -u {} -p{} {} < {}".format(
            LOCAL_USER_NAME, 
            local_pw,
            LOCAL_DB_NAME,
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


if __name__ == '__main__':
    main()