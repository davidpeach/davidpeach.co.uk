---
title: Backing up Docker volume data to Digital Ocean spaces with encryption
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-12-05T18:47:42.000Z
metadata:
  featuredImage: https://davidpeach.me/wp-content/uploads/2023/12/backup.jpg
  media:
    featuredImage: /assets/backup-OU1aCEFpOV7K.jpg
  categories:
    - Programming
  tags:
    - Backups
    - Digital Ocean
    - Docker
    - homelab
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=51427
  type: wordpress
  url: >-
    https://davidpeach.me/2023/12/05/backing-up-docker-volume-data-to-digital-ocean-spaces-with-encryption/
tags:
  - programming
---
Backups are a must for pretty much anything digital. And automating those backups make life so much easier for you, should you lose your data.

## My use case

My own use case is to backup the data on my home server, since these are storing my music collection and my family’s photos and documents.

All of the services on my home server are installed with Docker, with all of the data in separate Docker Volumes. This means I should only need to back those folders that get mounted into the containers, since the services themselves could be easily re-deployed.

I also want this data to be encrypted, since I will be keeping both an offline local copy, as well as storing a copy in a third party cloud provider (Digital Ocean spaces).

## Setting up s3cmd

S3cmd is a command line utility for interacting with an S3-compliant storage system.

It will enable me to send a copy of my data to my Digital Ocean Spaces account, encrypting it before hand.

### Install s3cmd

The [official installation instructions for s3cmd](https://github.com/s3tools/s3cmd/blob/master/INSTALL.md) can be found on the Github repository.

For Arch Linux I used:

```
sudo pacman -S s3cmd
```

And for my home server, which is running Ubuntu Server, I installed it via Python’s package manager, “pip”:

```
sudo pip install s3cmd
```

### Configuring s3cmd

Once installed, the first step is to run through the configuration steps with this command:

```
s3cmd --configure
```

Then answer the questions that is asks you.

You’ll need these items to complete the steps:

-   Access Key (for digital ocean api)
-   Secret Key (for digital ocean api)
-   S3 endpoint (e.g. lon1.digitaloceanspaces.com)
-   DNS-style (I use **%(bucket)s.ams3.digitaloceanspaces.com**)
-   Encryption password (remember this as you’ll need it for whenever you need to decrypt your data)

The other options should be fine as their default values.

Your configuration will be stored as a plain text file at `~/.s3cmd`. This includes that encryption password.

## Automation script for backing up docker volume data

Since all of the data I actually care about on my server will be in directories that get mounted into docker containers, I only need to compress and encrypt those directories for backing up.

If ever I need to re-install my server I can just start all of the fresh docker containers, then move my latest backups to the correct path on the new server.

Here is my bash script that will archive, compress and push my data to backup over to Digital Ocean spaces (encrypting it via GPG before sending it).

I have added comments above each section to try and make it more clear as to what each step is doing:

```
#!/usr/bin/bash

## Root directory where all my backups are kept.
basepath="/home/david/backups"

## Variables for use below.
appname="nextcloud"
volume_from="nextcloud-aio-nextcloud"
container_path="/mnt/ncdata"

## Ensure the backup folder for the service exists.
mkdir -p "$basepath"/"$appname"

## Get current timestamp for backup naming.
datetime=$(date +"%Y-%m-%d-%H-%M-%S")

## Start a new ubuntu container, mounting all the volumes from my nextcloud container 
## (I use Nextcloud All in One, so my Nextcloud service is called "nextcloud-aio-nextcloud")
## Also mount the local "$basepath"/"$appname" to the ubuntu container's "/backups" path.
## Once the ubuntu container starts it will run the tar command, creating the tar archive from 
## the contents of the "$container_path", which is from the Nextcloud volume I mounted with 
## the --volumes-from flag.
docker run \
--rm \ 
--volumes-from "$volume_from" \
-v "$basepath"/"$appname":/backups \
ubuntu \
tar cvzf /backups/"$appname"-data-"$datetime".tar.gz "$container_path"

## Now I use the s3cmd command to move that newly-created 
## backup tar archive to my Digital Ocean spaces.
s3cmd -e put \
  "$basepath"/"$appname"/"$appname"-data-"$datetime".tar.gz \
  s3://scottie/"$appname"/
```

## Automating the backup with a cronjob

Cron jobs are a way to automate any tasks you want to on a Linux system.

You can have fine-grained control over how often you want to run a task.

Although work with Linux’s cron scheduler is out of the context of this guide, I will share the setting I have for my Nextcloud backup, and a brief explanation of its configuration.

The command to edit what cron jobs are running on a Linux system, Ubuntu in my case, is:

```
crontab -e
```

This will open up a temporary file to edit, which will get written to the actual cron file when saved — provided it is syntactically correct.

This is the setting I have in mine for my Nextcloud backup (it should all be on a single line):

```
10 3 * * 1,4 /home/david/backup-nextcloud >> /home/david/backups/backup-nextcloud.log
```

The numbers and asterisks are telling cron when the given command should run:

```
10th minute
3rd Hour
* Day of month (not relevant here)
* Month (not relevant here)
1st,4th Day of the Week (Monday and Thursday)
```

So my configuration there says it will run the `/home/david/backup-nextcloud` command every **Monday** and **Thursday** at **3**:**10**am. It will then pipe the command’s output into my log file for my Nextcloud backups.

## Decrypting your backups

Download the file from your Digital Ocean spaces account.

Go into the directory it is downloaded to and run the `file` command on the archive:

```
# For example
file nextcloud-data-2023-11-17-03-10-01.tar.gz

# You should get something like the following feedback:
nextcloud-data-2023-11-17-03-10-01.tar.gz: GPG symmetrically encrypted data (AES256 cipher)
```

You can decrypt the archive with the following command:

```
gpg --decrypt nextcloud-data-2023-11-17-03-10-01.tar.gz > nextcloud-backup.tar.gz
```

When you are prompted for a passphrase, enter the one you set up when configuring the s3cmd command previously.

You can now extract the archive and see your data:

```
tar -xzvf nextcloud-backup.tar.gz
```

The archive will be extracted into the current directory.