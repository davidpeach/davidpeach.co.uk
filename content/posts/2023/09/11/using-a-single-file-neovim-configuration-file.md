---
title: Using a single file neovim configuration file
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-09-11T12:17:00.000Z
metadata:
  categories:
    - Programming
  tags:
    - Dotfiles
    - Neovim
    - Vim
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=50728
  type: wordpress
  url: >-
    https://davidpeach.me/2023/09/11/using-a-single-file-neovim-configuration-file/
tags:
  - programming
---
When I first moved my Neovim configuration over to using lua, as opposed to the more traditional vimscript, I thought I was clever separating it up into many files and includes.

Turns out that it became annoying to edit my configuration. Not difficult; just faffy.

So I decided to just stick it all into a single `init.lua` file. And now its much nicer to work with in my opinion.

View [my Neovim init.lua file on Github](https://github.com/davidpeach/dotfiles/tree/main/nvim/.config/nvim/init.lua).