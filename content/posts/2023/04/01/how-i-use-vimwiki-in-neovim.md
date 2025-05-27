---
title: How I use vimwiki in neovim
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-04-01T09:30:06.000Z
metadata:
  categories:
    - Programming
  tags:
    - Commonplace
    - My Website
    - Neovim
    - Vim
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=47898
  type: wordpress
  url: https://davidpeach.me/2023/04/01/how-i-use-vimwiki-in-neovim/
tags:
  - programming
---
_**This post is currently in-progress, and is more of a brain-dump right now. But I like to share as often as I can otherwise I’d never share anything 🙂**_

Please view the official [Vimwiki Github repository](https://github.com/vimwiki/vimwiki) for up-to-date details of Vimwiki usage and installation. This page just documents my own processes at the time.

## Installation

Add the following to `plugins.lua`

```
use "vimwiki/vimwiki"
```

Run the following two commands separately in the neovim command line:

```
:PackerSync
:PackerInstall
```

Close and re-open Neovim.

## How I configure Vimwiki

I have 2 separate wikis set up in my Neovim.

One for my **personal homepage** and one for my **commonplace site**.

I set these up by adding the following in my dotfiles, at the following position: `$NEOVIM_CONFIG_ROOT/after/plugin/vimwiki.lua`. So for me that would be `~/.config/nvim/after/plugin/vimwiki.lua`.

You could also put this command inside the config function in your plugins.lua file, where you require the vimwiki plugin. I just tend to put all my plugin-specific settings in their own “after/plugin” files for organisation.

```
vim.cmd([[
  let wiki_1 = {}
  let wiki_1.path = '~/vimwiki/website/'
  let wiki_1.html_template = '~/vimwiki/website_html/'
  let wiki_2 = {}
  let wiki_2.path = '~/vimwiki/commonplace/'
  let wiki_2.html_template = '~/vimwiki/commonplace_html/'
  let g:vimwiki_list = [wiki_1, wiki_2]
  call vimwiki#vars#init()
]])
```

The `path` keys tell vimwiki where to plave the root `index.wiki` file for each wiki you configure.

The `html_template` keys tell vimwiki where to place the compiled html files (when running the `:VimwikiAll2HTML` command).

I keep them separate as I am deploying them to separate domains on my server.

When I want to open and edit my website wiki, I enter `1<leader>ww`.

When I want to open and edit my commonplace wiki, I enter `2<leader>ww`.

Pressing those key bindings for the first time will ask you if you want the directories creating.

## How I use vimwiki

At the moment, my usage is standard to what is described in the Github repository linked at the top of this page.

When I develop any custom workflows I’ll add them here.

## Deployment

**_Setting up a server to deploy to is outside the scope of this post, but hope to write up a quick guide soon._**

I run the following command from within vim on one of my wiki index pages, to export that entire wiki to html files:

```
:VimwikiAll2HTML
```

I then `SCP` the compiled HTML files to my server. Here is an example scp command that you can modify with your own paths:

```
scp -r ~/vimwiki/website_html/* your_user@your-domain.test:/var/www/website/public_html
```

For the best deployment experience, I recommend setting up ssh key authentication to your server.

For bonus points I also add a bash / zsh alias to wrap that scp command.