---
title: Passive plugins I use in Neovim
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-03-21T18:34:45.000Z
metadata:
  categories:
    - Programming
  tags:
    - editors
    - Neovim
    - Vim
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=47673
  type: wordpress
  url: https://davidpeach.me/2023/03/21/passive-plugins-i-use-in-neovim/
tags:
  - programming
---
These plugins I use in Neovim are ones I consider “passive”. That is, they just sit there doing their thing in the background to enhance my development experience.

Generally they wont offer extra keybindings or commands I will use day to day.

You can view all the plugins I use in [my plugins.lua file in my dotfiles](https://github.com/davidpeach/.dotfiles/blob/main/nvim/.config/nvim/lua/user/plugins.lua).

* * *

**[Vim-lastplace](https://github.com/farmergreg/vim-lastplace)** will remember the last edit position of each file you’re working with and place your cursor there when re-entering.

```
use "farmergreg/vim-lastplace"
```

* * *

[**Nvim-autopairs**](https://github.com/windwp/nvim-autopairs) will automatically add closing characters when opening a “pair”, such as `{`, `[` and `(`. It will then place your cursor between the two.

```
use "windwp/nvim-autopairs"
```

* * *

[**Neoscroll**](https://github.com/karb94/neoscroll.nvim) makes scrolling smooth in neovim.

```
use "karb94/neoscroll.nvim"
```

* * *

[**Vim-pasta**](https://github.com/sickill/vim-pasta) will super-charge your pasting in neovim to preserve indents when pasting contents in with “`p`” and “`P`“.

```
use({
  "sickill/vim-pasta",
  config = function()
    vim.g.pasta_disabled_filetypes = { 'fugitive' }
  end,
})
```

Here I am passing a config function to disable vim-pasta for “fugitive” filetypes. “Fugitive” is in reference to the vim-fugitive plugin that I will explain in another post.

* * *

[**Nvim-colorizer**](https://github.com/norcalli/nvim-colorizer.lua) will highlight any colour codes your write out.

```
use "norcalli/nvim-colorizer.lua"
```