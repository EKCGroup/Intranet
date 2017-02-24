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
1. Download and install the latest version of Concrete5 from `https://www.concrete5.org/` in your servers webroot.
2. Download and configure the latest version of Codeigniter from `https://www.codeigniter.com/' in `WEBROOT/dashboard`
3. Clone or unzip this repository into the webroot. **This may override some files**.


## Apache VHost
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

## LetsEncrypt Certificate
We recommend securing your site with a LetsEncrypt certificate.

```bash
apt install -y certbot
letsencrypt certonly --webroot -w /var/www/html/certificate.cant-col.ac.uk -d .cant-col.ac.uk
```
