[![Build Status](https://scrutinizer-ci.com/g/East-Kent-Partnership/Intranet/badges/build.png?b=master)](https://scrutinizer-ci.com/g/East-Kent-Partnership/Intranet/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/East-Kent-Partnership/Intranet/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/East-Kent-Partnership/Intranet/?branch=master)

# CC &amp; EKC Staff Intranet
CC &amp; EKC Staff Intranet's is built using Concrete5 and Codeigniter, with a single bootstrap theme across both platforms; combined makes a elegant Intranet solution, rich with functionality and the ability for users to maintain their own content.

##### This is the theme only!
## Screenshots
### Desktop
![](https://github.com/East-Kent-Partnership/Intranet/blob/master/screenshots/HomePage.png)
### Mobile
![](https://github.com/East-Kent-Partnership/Intranet/blob/master/screenshots/HomeMobile.png)

## Installation
1.. Download and install the latest version of Concrete5 from `https://www.concrete5.org/` in your servers webroot.
2.. Download and configure the latest version of Codeigniter from `https://www.codeigniter.com/' in `WEBROOT/dashboard`
3.. In `dashboard/application/config/config.php` set '$config['index_page'] = '';' and `$config['base_url'] = 'https://DOMAIN.COM/dashboard';`
4.. Clone this repository into the webroot. **This may override some files**. `git clone URL`
5.. Download all submodules `git submodule update --init --recursive`
6.. Add the following to `dashboard/application/config/config.php`
```php
$config['ldapserver'] = 'ldap://'.$config['ldapip'];
$config['ldapip'] = '';
$config['ldapshortdomain'] = 'CANT-COL'.'\\';
$config['ldapdomain'] = 'cant-col.ac.uk';
$config['ldapuserou'] = 'OU=Accounts,DC=cant-col,DC=ac,DC=uk';
$config['ldapbindun'] = 'ldapquery';
$config['ldapbindpass'] = '';
$config['ldapdashboardgroupsou'] = 'OU=Dashboard_Group';
$config['ldapuserjobou1'] = 'OU=Staff,OU=Accounts,DC=cant-col,DC=ac,DC=uk';
$config['ldapuserjobou2'] = '';
$config['ldapuserjobou3'] = '';
$config['ldapuserjobou4'] = '';

$config['ldapadminun'] = 'administrator';
$config['ldapadminpass'] = '';

$config['privateip'] = '10.0.0.0|10.255.255.255';
$config['timezone'] = 'Europe/London';
```
7.. Import the dashboard config `dashboard/import.sql`
8.. Copy the database config and change the variable to `intranet` and add the concrete5 database settings `dashboard/application/config/database.php`
```php
$db['intranet'] = array(
```

### Updates
Note* git commands will override files which have been edited since your last pull request.

1. `git pull origin master`

2. `git submodule foreach git pull origin master`

3. https://documentation.concrete5.org/developers/installation/upgrading-concrete5
4. https://www.codeigniter.com/userguide3/installation/upgrade_301.html


### Apache VHost
```apache
<VirtualHost *:80>
   ServerAdmin webmaster.cant-col.ac.uk
   ServerName intranet.cant-col.ac.uk
   ServerAlias intranet.cant-col.ac.uk
   RewriteRule /(.*) https://intranet.cant-col.ac.uk/$1 [L]
</VirtualHost>


<VirtualHost *:443>
   ServerAdmin webmaster.cant-col.ac.uk
   ServerName intranet.cant-col.ac.uk
   ServerAlias intranet.cant-col.ac.uk
   ErrorLog /var/log/httpd/intranet-error.log
   CustomLog /var/log/httpd/intranet-access.log combined
   DocumentRoot /var/www/html/intranet
   Include /var/www/certs/ssl-apache.conf

   <Directory /var/www/html/intranet >
     #AllowOverride All
      <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteBase /
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME}/index.php !-f
        RewriteRule . index.php [L]
     </IfModule>

      SetEnvIf Request_URI ^/dashboard/computing-support/new-staff-export require_auth=true
      SetEnvIf Request_URI ^/dashboard/computing-support/new-staff-export/complete require_auth=true

      # Auth
      AuthUserFile /var/www/htpasswd
      AuthName "Password Protected"
      AuthType Basic
      Order Deny,Allow
      Deny from all
      Satisfy any
      Require valid-user
      Allow from env=!require_auth

   </Directory>
   <Directory /var/www/html/intranet/dashboard >
      AllowOverride All
   </Directory>
</VirtualHost>

```

### LetsEncrypt Certificate
We recommend securing your site with a LetsEncrypt certificate.

```bash
apt install -y certbot
letsencrypt certonly --webroot -w /var/www/html/certificate.cant-col.ac.uk -d .cant-col.ac.uk
```
