---
title: Preview Laravel&#8217;s migrations with the pretend flag
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2021-10-20T12:40:32.000Z
metadata:
  featuredImage: https://davidpeach.me/wp-content/uploads/2017/10/DOHaH57XcAArzKt.jpg
  media:
    featuredImage: /assets/DOHaH57XcAArzKt-FCkUKFGewMY3.jpg
  categories:
    - Programming
  tags:
    - Laravel
    - PHP
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=43258
  type: wordpress
  url: >-
    https://davidpeach.me/2021/10/20/preview-laravels-migrations-with-the-pretend-flag/
tags:
  - programming
---
Here is the command to preview your Laravel migrations without running them:

```
cd /your/project/root
php artisan migrate --pretend
```

Laravel’s migrations give us the power to easily version control our database schema creations and updates.

In a recent task at work, I needed to find out why a particular migration was failing.

This is when I discovered the simple but super-useful flag `--pretend`, which will show you the queries that Laravel will run against your database **without actually running those migrations**.