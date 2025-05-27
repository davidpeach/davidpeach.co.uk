---
title: Homelab initial setup
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-10-09T21:02:32.000Z
metadata:
  categories:
    - Programming
  tags:
    - homelab
    - Linux
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=50803
  type: wordpress
  url: https://davidpeach.me/2023/10/09/homelab-initial-setup/
tags:
  - programming
---
I have gone with [Ubuntu Server 22.04 LTS](https://ubuntu.com/download/server) for my Homelab’s operating system.

Most of the videos I’ve seen for Homelab-related guides and reviews tend to revolve around Proxmox and/or TrueNAS. I have no experience with either of those, but I do have experience with Docker, so I am opting to go with straight up docker — at least for now.

## Setting up the Operating system

I’m using a Linux-based system and so instructions are based on this.

### Step 1: Download the Ubuntu Server iso image

[Head here](https://ubuntu.com/download/server) to download your preferred version of Ubuntu Server. I chose the latest LTS version at the time of writing (22.04)

### Step 2: Create a bootable USB stick with the iso image you downloaded.

Once downloaded, insert and a usb stick to install the Ubuntu Server iso on to.

Firstly, check where your USB stick is on your filesystem. For that, I use fdisk:

Bash```
sudo fdisk -l
```

Assuming the USB stick is located at “`/dev/sdb`“, I use the `dd` command to create my bootable USB (please check and double check where your USB is mounted on your system):

Bash```
sudo dd bs=4M if=/path/to/Ubuntu-Server-22-04.iso of=/dev/sdb status=progress oflag=sync
```

### Step 3: Insert and boot to the bootable USB stick into the Homelab computer

Boot the computer that you’re using for your server, using the USB stick as a temporary boot device.

### Step 4: Install the operating system

Follow the steps that the set up guide gives you.

As an aside, I set my server ssd drive up with the “LVM” option. This has helped immensely this week, as I have added a second drive and doubled my capacity to 440GB.

### Step 5: install and enable ssh remote access

I can’t remember if ssh came installed or enabled, but you can install `openssh` and then enable the `sshd` service.

You can then connect to the server from a device on your network with:

Bash```
ssh username@192.168.0.77
```

This assumes your server’s IP address is `192.168.0.77`. Chances are very high it’ll be a different number (although the `192.168.0` section may be correct.

## Everything else done remotely

I have an external keyboard in case I ever need to plug in to my server. However, now I have ssh enabled, I tend to just connect from my laptop using the ssh command show just above.