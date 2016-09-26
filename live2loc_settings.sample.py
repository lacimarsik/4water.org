# Copy this file to live2loc_settings.py, set your settings and put the file to .gitignore

# URLs
URL_SUBSTITUTIONS = [
	('http://www.4water.org', 'http://localhost/html/4water'),
	('4water.org', 'localhost/html/4water')
]

# DB names
LOCAL_DB_NAME = 'weare4water'
REMOTE_DB_NAME = 'salsa4water'

# connection details
LOCAL_USER_NAME = 'root'
LOCAL_PW = None  #keep none = pw will be asked for
REMOTE_HOST = 'salsa.forma.sk'
REMOTE_USER_NAME = 'salsa09'

# FTP
FTP_ADDRESS = 'ftp://salsa.forma.sk'
FTP_USER = 'salsa09'
