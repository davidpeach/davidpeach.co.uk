---
title: Setting up my own Nextcloud (Version 16)
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2018-12-20T18:42:34.000Z
metadata:
  categories:
    - Programming
  tags:
    - Own Your Data
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=33501
  type: wordpress
  url: https://davidpeach.me/2018/12/20/setting-up-my-own-nextcloud/
tags:
  - programming
---
Setting up your very own Nextcloud server from scratch. This has been tested with version 15 and 16 of the software. Any questions, please do [contact me](mailto:mail@davidpeach.me).

_Updated on: 24th June 2019_

## Set up a new server (with Digital Ocean)

If you don’t have an account already, head to [Digital Ocean](https://m.do.co/c/47def9df1555) and create a new account. Of course, you can use any provider that you want to – I just happen to use them and so can only give experience from that.

Login to your account.

### Setup your SSH key

In the next step we will be creating your new droplet (server), and you will need an `SSH Key` to add to it. This allows for easy and secure access to your new droplet from your local computer, via your terminal[1](#fn:1).

If you are going to use the Digital Ocean console terminal, skip down to ‘Create the new “Droplet”‘, as you wont need an ssh key.

#### Creating the key (if you haven’t already)

If you haven’t generated an SSH key pair before, open a fresh terminal window and enter the following:

```
ssh-keygen -t rsa
```

Press enter through all of the defaults to complete the creation.

#### Getting the contents of the public key

Type this to display your new **public** key:

```
cat ~/.ssh/id_rsa.pub
```

This will give you a long string of text starting with `ssh-rsa` and ending with something like `yourname@your-computer`.

Highlight the whole selection, including the start and end points mentioned, and right click and copy.

**When you are creating your droplet below**, you can select the `New SSH Key` button and paste your public key into the box it gives you. You will also need to give the key a name when you add it in Digital Ocean, but you can name it anything.

Then click the `Add SSH Key` and you’re done.

### Create the new “Droplet”

Digital Ocean refers to each server as a droplet, going with the whole digital “ocean” theme.

Head to `Create > Droplets` and click the “One-click apps” tab. Then choose the following options in the selection (Or your own custom selection – just take into account the monthly cost of each option):

-   LAMP on 18.04
-   $15/Month (2GB / 60GB / 3TB Transfer)
-   Enable backups (not necessary but recommended)
-   London (Choose your closest / preferred location)
-   Add your SSH key (see above)
-   Optionally rename the hostname to something more readable

Once you have selected the above (or your own custom options) click create. After a few moments, your droplet will be ready to use.

## Set your DNS

Got to your domain name provider, [Hover](https://hover.com/MnbDsioK) in my case, and set up the subdomain for your nextcloud installation, using the I.P. address for your new droplet.

I’m assuming that you already have your own domain name, perhaps for your personal website / blog. In which case we are adding a subdomain to that (so `https://nextcloud.yourdomain.co.uk`, for example).

But there is nothing stopping you from buying a fresh domain and using it exclusively for your new Nextcloud (`https://my-awesome-nextcloud.co.uk`).

I will be continuing this guide, assuming that you are using a subdomain.

You will add it in the form of an `A record`. This is how I would add it in Hover:

1.  Select your own domain
2.  Choose `edit > edit DNS`
3.  Click `Add A record` on the DNS edit page
4.  Fill in the hostname as your desired subdomain for your Nextcloud. For example if you were having `nextcloud.mydomain.co.uk`, you would just enter `nextcloud`.
5.  Fill in the I.P. address as the I.P. address of your new Droplet in Digital Ocean.
6.  Click `Add Record`

## Configuring the server

### Install all the required programs for Nextcloud

First `ssh` into your new server:

```
ssh root@YOUR.IP.ADDRESS.HERE
```

When we chose to install the `LAMP` option when setting up the droplet, it installed Linux, Apache2, MySQL and PHP. However, there are still some extra dependencies that Nextcloud needs to run.  
Let’s install those next:

```
apt-get update

apt-get install libapache2-mod-php7.2 php7.2-gd php7.2-json &&
apt-get install php7.2-mysql php7.2-curl php7.2-mbstring &&
apt-get install php7.2-common php7.2-intl php-imagick php7.2-xml &&
apt-get install php7.2-zip php7.2-ldap php7.2-imap  php7.2-gmp &&
apt-get install php7.2-apcu php7.2-redis php7.2-imagick ffmpeg unzip
```

### Download and install the Nextcloud codebase

Please note that I am using version `15.0.0` in this example. However, when you read this you may have a new version available to you. I will try and keep this guide as up to date as possible.

```
# Download the codebase and the "checksum" file.
wget https://download.nextcloud.com/server/releases/nextcloud-15.0.0.zip
wget https://download.nextcloud.com/server/releases/nextcloud-15.0.0.zip.sha256

# Make sure that the codebase is genuine and hasn't been altered.
sha256sum  -c nextcloud-15.0.0.zip.sha256 < nextcloud-15.0.0.zip

# Move the unzipped codebase into the webserver directory.
unzip nextcloud-15.0.0.zip
cp -r nextcloud /var/www
chown -R www-data:www-data /var/www/nextcloud
```

### Apache config example

```
nano /etc/apache2/sites-available/000-default.conf
```

An example apache config:

```
<VirtualHost *:80>
        ServerAdmin mail@yourdomain.co.uk
        DocumentRoot /var/www/nextcloud

        <Directory /var/www/nextcloud/>
            Options Indexes FollowSymLinks
            AllowOverride All
            Require all granted
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

        <IfModule mod_dir.c>
            DirectoryIndex index.php index.pl index.cgi index.html index.xhtml index.htm
        </IfModule>

RewriteEngine on
RewriteCond %{SERVER_NAME} =nextcloud.yourdomain.co.uk
RewriteRule ^ https://%{SERVER_NAME}%{REQUEST_URI} [END,NE,R=permanent]
</VirtualHost>
```

```
a2enmod rewrite && a2enmod headers && a2enmod env && 
a2enmod dir && a2enmod mime && systemctl restart apache2
```

### A quick mysql fix

In recent versions of MySQL, the way that the mysql root user connects to the database means that password authentication wont work. So firstly we need to alter that user to use password authentication.

```
apt install mysql-server
```

```
mysql

# In the mysql mode
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'your_secret_password';
FLUSH PRIVILEGES;
quit
```

### SSL with Let’s Encrypt

```
apt install certbot
```

```
certbot --apache -d nextcloud.yourdomain.co.uk
```

You will then be asked some questions about your installation:

-   Email address (your… umm… email address :D)
-   Whether you agree to Lets Encrypt Terms of Service (Agree)
-   Whether to redirect HTTP traffic to HTTPS (choose Yes)

Let’s Encrypt will handle the registering of the apache settings for you new ssl to work. It uses the server name you entered in the `000-default.conf` file earlier.

It will also create a new file that is used by Apache for the SSL. For me, this file was at `/etc/apache2/sites-available/000-default-le-ssl.conf`.

## First Login!

Now go to `https://nextcloud.yourdomain.co.uk` and you should see your nice new shiny Nextcloud installation.

### Creating the admin account

Fill in the fields for your desired name and password for the admin account. You can just use the admin account as your main account if you will be the only one using this Nextcloud. But you can give others access to this site with their own login details, if you wanted. But without the admin-level priviledges.

For the database fields, enter `root` as the username. Then for the password, use the one that you set in the previous mysql command above. For the database name choose whatever name you wish, as the installation will create it for you.

Click finish.

After a few moments time, your nextcloud instance should present you with the landing screen along with the welcome popup. Go ahead and read it and you could even install the app for your devices as it will suggest.

## Finishing touches

If you click the cog icon in the top right of your screen, followed by settings in its dropdown, you will come to the main settings area. In the left-hand column, beneath the heading “Administration”, you should see the link for “Overview”. Click it.

Now you should see a bunch of security and setup warnings at the top of the page. This is nothing to worry about, it is simply telling you about some actions that are highly recommended to setup.

We will do that now. 🙂

### The “Strict-Transport-Security” HTTP header is not set to at least “15552000” seconds. For enhanced security, it is recommended to enable HSTS as described in the security tips.

All that is needed to fix this first one, is a quick edit to the apache config file that Let’s Encrypt created for the installation.

```
nano /etc/apache2/sites-available/000-default-le-ssl.conf
```

And then add this following three lines within the `<VirtualHost *:443>` tag.

```
<IfModule mod_headers.c>
    Header always add Strict-Transport-Security "max-age=15768000; includeSubDomains; preload"
</IfModule>
```

And then reload apache:

```
systemctl reload apache2
```

Refreshing the settings page should see that warning disappear.

### No memory cache has been configured. To enhance performance, please configure a memcache, if available.

Open up you Nextcloud config file:

```
nano /var/www/nextcloud/config/config.php
```

At the bottom of the config array, add the following line:

```
'memcache.local' => '\OC\Memcache\APCu',
```

Refresh your browser and that next warning should now vanish.

For future reference, you can always take a look in the sample Nextcloud config file at `/var/www/nextcloud/config/config.sample.php`. It will show you all available config options.

### The PHP OPcache is not properly configured.

With this warning, Nextcloud should display some sample `opcache` code to paste over. This one caught me out as I couldn’t work out which `ini` file this example code should go.

After some trial and error, I discovered that for me, it was located in an `opcache.ini` file:

```
nano /etc/php/7.2/mods-available/opcache.ini
```

Then at the bottom of the file, I pasted the following:

```
opcache.enable=1
opcache.enable_cli=1
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=10000
opcache.memory_consumption=128
opcache.save_comments=1
opcache.revalidate_freq=1
```

Reload apache:

```
systemctl reload apache2
```

### Some columns in the database are missing a conversion to big int.

I only actually came across this warning when I was creating a dummy Nextcloud installation for helping with writing this guide. You may not actually get it. But if you do, here’s the fix[2](#fn:2):

```
sudo -u www-data php /var/www/nextcloud/occ db:convert-filecache-bigint
```

This will warn you that it could take hours to do its thing, depending on the number of files. However, due to us running it right after the installation, will not even take a second.

### The PHP memory limit is below the recommended value of 512MB

To fix this, I just had to edit the following file:

```
nano /etc/php/7.2/apache2/php.ini
```

Then alter the next line to look like this:

```
memory_limit = 512M
```

Then restart apache:

```
service apache2 restart
```

## All Done

Once you refresh the settings page once more, you should see a beautiful green tick with the message “All checks passed”.

Good feeling, isn’t it?

If for any reason you are still getting warnings, please dont hesitate to contact me. I’ll do my best to help. Email: [mail@davidpeach.me](mailto:mail@davidpeach.me). Alternatively you can head to the [Nextcloud Documentation](https://docs.nextcloud.com/server/stable/admin_manual/).