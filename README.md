If you want to contribute to the development, this is our setup and workflow.

# SETUP

### 0) Programming requirements
* LAMP or WAMP server running locally (Apache, MySQL, PHP)
* get [composer](https://getcomposer.org)

### 1) Passwords and invites

Contact tech team to:
* get an invite to Slack
* get an invite to this repository
* get a password to the wordpress on "production" http://www.4water.org/wp-admin
* get FTP password for ftp://www.4water.org

### 2) Clone this repo and set-up wordpress locally

* `git clone <repository url>`
* create a local MySQL database
* change the wp-config file, providing the access data to your database (you can do it by running a 3-step wordpress
installation which fires up when you open the site locally)
* modify .gitignore to suit your needs. E.g. I have there all of the below plus some of my own things

```
*.log
.htaccess
sitemap.xml
sitemap.xml.gz
wp-config.php
wp-content/advanced-cache.php
wp-content/backup-db/
wp-content/backups/
wp-content/blogs.dir/
wp-content/cache/
wp-content/upgrade/
wp-content/uploads/
wp-content/wp-cache-config.php
wp-content/plugins/hello.php
nbproject
/readme.html
/license.txt
...
```
* you can also export the "production database" and import it locally, to get the live content. Do it by copy `live2loc_settings.sample.py`,
entering the correct data in it and creating
```
$ cp live2loc_settings.sample.py live2loc_settings.py
(modify live2loc_settings.py so that it has correct login data)
$ ./live2loc.py <sql dump>
```
Run `./live2loc.py -h` if in doubt

The idea is to separate development of the website and filling it with content. What is in this repo should be only the former, while the actual content (images, texts) will be filled in on the production server, in wp-admin. In other words, here we develop the site so that it's customizable and the content can be changed later by anyone in wp-admin.

# WORKFLOW

We have a:

* local repo (git)
* online repo (this repository)
* production server (www.4water.org)

Say you want to make/modify another section in on the front page. 

### Make a new branch

```
git checkout -b xy/section-calendar
```

where xy are you intials (fh, lm...)

### Do changes

Also do local commits. See how the page looks like, test it (we have no formal testing at the moment)

### Push

When happy, commit again and push

```
git push origin xy/section-calendar
```

### Make pull request

Go to repository and create pull request (it's like asking for a review). Then just wait for the slow reviewers :-) They will review, download and test your code, comment, you will rework some things, reupload and finally one of them will merge the PR to the main branch. Done? Not yet...

### Deploy

Now the code is in the repo, but not on the production server.

You can use an FTP client (like filezilla), connect to ftp://www.4water.org and upload the changed files.

You can also use the `deploy.py` script:
`git log` to find the hash of the PR merge commit, then
`python3 deploy.py -c 3e4bda9f21347f878365e584bfc452827f782544` to deploy - it will show you the list of files corresponding to that commit, ask for confirmation, ftp password and then ciao!