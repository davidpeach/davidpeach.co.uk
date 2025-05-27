---
title: Fixing my local development file / folder permissions
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2020-11-17T12:59:17.000Z
metadata:
  categories:
    - Programming
  tags:
    - Linux
    - Programming
    - Web Development
    - wordpress
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=36266
  type: wordpress
  url: >-
    https://davidpeach.me/2020/11/17/fixing-my-local-development-file-folder-permissions/
tags:
  - programming
---
```
sudo find . -type d -exec chmod g+rwx {} +
sudo find . -type f -exec chmod g+rw {} +
```