---
title: Updating PHP versions in Ubuntu 20.04
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2020-07-23T14:23:16.000Z
metadata:
  categories:
    - Programming
  tags:
    - Linux
    - PHP
    - Programming
    - Web Development
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=36176
  type: wordpress
  url: https://davidpeach.me/2020/07/23/updating-php-versions-in-ubuntu-20-04/
tags:
  - programming
---
For an older PHP project, I needed to install an older version of PHP. This is what I did to set that up.

### Installing a different PHP version

sudo add-apt-repository ppa:ondrej/php  
sudo apt-get update  
sudo apt-get install -y php7.1

### Rebinding php to required version

Some of these binds are probably not need. I think the main ones, at least for my use case, were `php` and `phar`.

sudo update-alternatives --set php /usr/bin/php7.1  
sudo update-alternatives --set phar /usr/bin/phar7.1  
sudo update-alternatives --set phar.phar /usr/bin/phar.phar7.1  
sudo update-alternatives --set phpize /usr/bin/phpize7.1  
sudo update-alternatives --set php-config /usr/bin/php-config7.1

For some reason the `--set` flag stopped working, so I had to use:

`sudo update-alternatives --config php`
`sudo update-alternatives --config p`har

etc. And update each one with the terminal prompt options for each.

p.s. If using PHP-FPM, you could also set up different server conf files and point the FPM path to the version you need. My need was just because I was using the command line in the older project.