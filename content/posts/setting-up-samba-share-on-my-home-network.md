---
title: Setting up samba share on my home network
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2015-10-26T20:04:00.000Z
metadata:
  categories:
    - Notes
  tags:
    - braindumps
    - Programming
    - Web Development
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=38755
  type: wordpress
  url: https://davidpeach.me/2015/10/26/setting-up-samba-share-on-my-home-network/
tags:
  - notes
---
Secure shell into file server.

Install samba if not already present:

```
sudo apt-get install samba
```

Create samba password with :

sudo smbpasswd -a YOUR\_USERNAME

Configuring the share:

```
sudo nano /etc/samba/smb.conf
```

```
# /etc/samba/smb.conf

[media] 
path = /home/YOUR_USERNAME/Share 
available = yes 
valid users = YOUR_USERNAME 
read only = no 
browsable = yes 
public = yes 
writable = yes
```

Restart samba:

```
sudo restart smbd
```