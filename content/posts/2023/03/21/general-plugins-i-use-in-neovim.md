---
title: General plugins I use in Neovim
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-03-21T22:31:22.000Z
metadata:
  categories:
    - Programming
  tags:
    - editors
    - Neovim
    - Vim
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=47688
  type: wordpress
  url: https://davidpeach.me/2023/03/21/general-plugins-i-use-in-neovim/
tags:
  - programming
---
I define a “general plugin” as a plugin that I use regardless of the filetype I’m editing.

These will add extra functionality for enhancing my Neovim experience.

* * *

I use **[Which-key](https://github.com/folke/which-key.nvim)** for displaying keybindings as I type them. For example if I press my `<leader>` key and wait a few milliseconds, it will display all keybindings I have set that begin with my `<leader>` key.

It will also display any marks and registers I have set, when only pressing `'` or `@` respectively.

```
use "folke/which-key.nvim"
```

* * *

[**Vim-commentary**](https://github.com/tpope/vim-commentary) makes it super easy to comment out lines in files using vim motions. So in normal mode you can enter `gcc` to comment out the current line; or `5gcc` to comment out the next 5 lines.

You can also make a visual selection and enter `gc` to comment out that selected block.

```
use "tpope/vim-commentary"
```

* * *

**[Vim-surround](https://github.com/tpope/vim-surround)** provides me with an extra set of abilities on text objects. It lets me add, remove and change surrounding elements.

For example I can place my cursor over a word and enter `ysiw"` to surround that word with double quotes.

Or I can make a visual selection and press `S"` to surround that selection with double quotes.

```
use "tpope/vim-surround"
```

* * *

**[Vim-unimpaired](https://github.com/tpope/vim-unimpaired)** adds a bunch of extra mappings that `[tpope](https://github.com/tpope/)` had in his own vimrc, which he extracted to a plugin.

They include mappings for the `[` and `]` keys for previous and next items. For example using `[b` and `]b` moves backwards and forwards through your open buffers. Whilst `[q` and `]q` will move you backwards and forwards respectively through your quickfist list items.

```
use "tpope/vim-unimpaired"
```