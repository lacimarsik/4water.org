#!/usr/bin/python3

# This is a script that can be used to upload specified files, or files specified by commit hash
# to the live server. 

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

# ---------------------------------------------------------------
# Methods
# ---------------------------------------------------------------

def print_help():
    print(
"""Usage:
deploy [options]
- deploys the specified files via FTP to the 4water server. Files from the list that do not exist 
locally will be deleted from live server too.

Options:
-h, --help:                shows this help
-c, --commit <hash>:       deploys the files corresponding to given merge commit hash
-f, --filelist <filepath>: deploys the files found in the provided file
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

def create_dirs_if_needed(ftp, fname):
    """creates all the parent dirs if they don't exist on server"""
    folders = fname.split('/')[:-1]
    orig_wd =  ftp.pwd()
    
    for f in folders:
        if not dir_exists_in_current(ftp, f):
            print("Creating dir \"{}\" inside \"{}\"...".format(f, ftp.pwd()), end="")
            ftp.mkd(f)
            print("OK!")
        ftp.cwd(f)

    ftp.cwd(orig_wd)
    

def dir_exists_in_current(ftp, dir):
    """checks if the directory exists in current directory on server"""
    filelist = []
    ftp.retrlines('LIST', filelist.append)
    for f in filelist:
        if f.split()[-1] == dir and f.upper().startswith('D'):
            return True
    return False

# ---------------------------------------------------------------
# Main
# ---------------------------------------------------------------

def main():
    # parse command line args
    argv = sys.argv[1:]
    if len(argv) == 0:
        print_help()
        sys.exit()

    try:
        opts, args = getopt.getopt(argv, "hc:f:",["help", "commit=", "filelist="])
    except getopt.GetoptError:
        print_help()
        sys.exit()
       
    filelist = []
    for opt, arg in opts:
        if opt in ('-h', "--help"):
            print_help()
            sys.exit()
        elif opt in ("-c", "--commit"):
            if re.match("^[A-Za-z0-9]*$", arg) is None:  #prevent shell injection
                print("The provided argument must be a merge commit hash")
                print_help()
                sys.exit()
            command = 'git log -m -1 --name-only --pretty="format:" ' + arg
            output, _ = subprocess.Popen(command, shell=True, stdout=subprocess.PIPE).communicate()
            filelist = output.decode('utf-8').split("\n")
        elif opt in ("-f", "--filelist"):
            f = open(arg, 'r')
            filelist = f.readlines()

    # show what's gonna be deployed
    print("Going to deploy following files:")
    filelist = [i for i in filelist if i]  #filter empty strings
    for counter, f in enumerate(filelist):
        print("\t" + str(counter + 1) + ".) " + f)

    # one more confirmation
    if not (confirm("Do you want to continue?", True)):
        sys.exit()

    # deploy
    ftp = ftplib.FTP('salsa.forma.sk')
    pw = getpass.getpass("Please enter password for the user 'salsa09' on ftp://salsa.forma.sk: \n")
    ftp.login('salsa09', pw)
    for fname in filelist:
        fname = fname.strip()
        try:
            if os.path.exists(fname):
                create_dirs_if_needed(ftp, fname)
                print("Uploading " + fname + " to server... ", end="")
                fl = open(fname, 'rb')
                ftp.storbinary('STOR ' + fname, fl)
            else:
                print("Deleting " + fname + " from server... ", end="")
                ftp.delete(fname)
            print("OK!")
        except Exception as e:
            print("Error: " + str(e))

    # finito
    print("Finito :-)")

if __name__ == '__main__':
    main()