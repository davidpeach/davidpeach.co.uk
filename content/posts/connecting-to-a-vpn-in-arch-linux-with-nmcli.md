---
title: Connecting to a VPN in Arch Linux with nmcli
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-02-08T10:36:46.000Z
metadata:
  categories:
    - Programming
  tags:
    - Arch Linux
    - Linux
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=47372
  type: wordpress
  url: >-
    https://davidpeach.me/2023/02/08/connecting-to-a-vpn-in-arch-linux-with-nmcli/
tags:
  - programming
---
`nmcli` is the command line tool for interacting with NetworkManager.

For work I sometimes need to connect to a vpn using an `.ovpn` (openvpn) file.

This method should work for other vpn types (I’ve only used `openvpn`)

## Installing the tools

All three of the required programs are available via the official Arch repositories.

-   `[networkmanager](https://archlinux.org/packages/?name=networkmanager)` (with contains the nmcli tool). You’ve probably already got this installed if you’re reading this.
-   [openvpn](https://archlinux.org/packages/extra/x86_64/openvpn/)
-   [networkmanager-openvpn](https://archlinux.org/packages/extra/x86_64/networkmanager-openvpn/) (to allow networkmanager to manage OpenVPN connections)

## Importing the `ovpn` file into your Network Manager

Once you’ve got the openvpn file on your computer, you can import it into your Network Manager configuration with the following command:

```
# Replace the file path with your own correct one.
nmcli connection import type openvpn file /path/to/your-file.ovpn
```

You should see a message saying that the connection was succesfully added.

## Activate the connection

Activating the connection will connect you to the VPN specified with that `.ovpn` file.

```
nmcli connection up your-file
```

If you need to provide a password to your vpn connection, you can add the `--ask` flag, which will make the `connection up` command ask you for a password:

```
nmcli connection up your-file --ask
```

## Disconnect

To disconnect from the VPN, just run the `down` command as follows:

```
nmcli connection down you-file
```

## Other Links:

[Network Manager on the Arch Wiki](https://wiki.archlinux.org/title/NetworkManager).