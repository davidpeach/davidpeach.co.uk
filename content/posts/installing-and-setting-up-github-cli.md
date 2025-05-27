---
title: Installing and setting up github cli
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-01-25T17:29:18.000Z
metadata:
  categories:
    - Programming
  tags:
    - Linux
    - Programming
    - Web Development
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=47363
  type: wordpress
  url: https://davidpeach.me/2023/01/25/installing-and-setting-up-github-cli/
tags:
  - programming
---
## What is the github cli

The [Github CLI tool](https://cli.github.com/) is the official Github terminal tool for interacting with your github account, as well as any open source projects hosted on Github.

I’ve only just begun looking into it but am already trying to make it part of my personal development flow.

## Installation

You can see the installation instructions [here](https://github.com/cli/cli#installation), or if you’re running on Arch Linux, just run this:

```
sudo pacman -S github-cli
```

Once installed, you should be able to run the following command and see the version you have installed:

```
gh --version
```

## Authenticating

Before interacting with your github account, you will need to login via the cli tool.

### Generate a Github Personal Access Token

Firstly, I generate a personal access token on the Github website. In my settings page I head to “Developer Settings” > “Personal Access Tokens” > “Tokens (classic)”.

I then create a new “classic” token (just my preference) and I select all permissions and give it an appropriate name.

Then I create it and keep the page open where it displays the access token. This is for pasting it into the terminal during the authentication flow next.

### Go through the Github CLI authentication flow

Start the authentication flow by running the command:

```
gh auth login
```

The following highlights are the options I select when going through the login flow. Your needs may vary.

```
What account do you want to log into?
> Github.com
> Github Enterprise Server

What is your preferred protocol for Git operations?
> HTTPS
> SSH

Upload your SSH public key to your Github account?
> /path/to/.ssh/id_rsa.pub
> Skip

How would you like to authenticate Github CLI?
> Login with a web browser
> Paste an authentication token
```

I then paste in the access token from the still-open tokens page, and hit enter.

You should see it correctly authenticates you and displays who you are logged in as.

Check out the [official documentation](https://cli.github.com/manual/gh) to see all of the available actions you can perform on your account.