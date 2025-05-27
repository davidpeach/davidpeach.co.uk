---
title: Giving a flatpak program access to home directory on Linux
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2021-08-23T12:20:41.000Z
metadata:
  categories:
    - Programming
  tags:
    - Linux
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=41251
  type: wordpress
  url: >-
    https://davidpeach.me/2021/08/23/giving-a-flatpak-program-access-to-home-directory-on-linux/
tags:
  - programming
---
List out all of your installed Flatpaks and copy the “Application ID” for the Flatpak you want to give home directory access to.

```
$ flatpak list
```

Let’s assume we want to give the program “Insomnia” access to our home directory when it is used.

The second column is the Application ID.

The application ID for Insomnia is `rest.insomnia.Insomnia`.

To give Insomnia access to your home directory, run the following:

```
flatpak override --user --filesystem=home rest.insomnia.Insomnia
```

## Notes

My knowledge of Flatpaks is limited so apologies if I end up being incorrect here.

Flatpak’ed programs are self-contained installations that are sheltered from the system they are installed on. (Linux / security geeks may need to correct me here).

By default, they don’t have access to the filesystem of your computer.

I needed to give my own installation of Insomnia access to my system (just the home directory in my case) so that I could upload a file to it. The command above gives me that result.

## Other online tutorials

There are some tutorials I’ve seen online that mention similar solutions, except using `sudo` and _not_ including the `--user` flag. This didn’t give me the result I was needing.

You see, without the `--user` flag, the command will try to update the Flatpak’s global configuration — which is why it needs `sudo` privileges.

But by using the `--user` flag, we are only affecting the configuration for the current user, and so the `sudo` is not needed.