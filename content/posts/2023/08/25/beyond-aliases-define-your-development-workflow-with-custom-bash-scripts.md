---
title: >-
  Beyond Aliases &#8212; define your development workflow with custom bash
  scripts
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-08-25T13:06:15.000Z
metadata:
  featuredImage: >-
    https://davidpeach.me/wp-content/uploads/2023/08/2023-08-25-142551_2927x416_scrot.png
  media:
    featuredImage: /assets/2023-08-25-142551_2927x416_scr-KniFTT71uaC4.png
  categories:
    - Programming
  tags:
    - bash scripting
    - Linux
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=50657
  type: wordpress
  url: >-
    https://davidpeach.me/2023/08/25/beyond-aliases-define-your-development-workflow-with-custom-bash-scripts/
tags:
  - programming
---
Being a Linux user for [just over 10 years now](https://davidpeach.me/2013/04/16/48321/), I can’t imagine my life with my aliases.

Aliases help with removing the repetition of commonly-used commands on a system.

For example, here’s some of my own that I use with the Laravel framework:

Bash```
alias a="php artisan"
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
alias stan="./vendor/bin/phpstan analyse"
```

You can set these in your `~/.bashrc` file. See [mine in my dotfiles](https://github.com/davidpeach/dotfiles/blob/main/home/.bashrc) as a fuller example.

However, I recently came to want greater control over my development workflow. And so, with the help of videos by [rwxrob](https://www.twitch.tv/rwxrob), I came to embrace the idea of learning `bash`, and writing my own little scripts to help in various places in my workflow.

## A custom bash script

For the example here, I’ll use the action of wanting to “exec” on to a local docker container.

Sometimes you’ll want to get into a shell within a local docker container to test / debug things.

I found I was repeating the same steps to do this and so I made a little script.

Here is the script in full:

Bash```
#!/bin/bash

docker container ls | fzf | awk '{print $1}' | \
xargs -o -I % docker exec -it % bash
```

### Breaking it down

In order to better understand this script I’ll assume no prior knowledge and explain some bash concepts along the way.

#### Sh-bang line.

the first line is the “sh-bang”. It basically tells your shell which binary should execute this script when ran.

For example you could write a valid `php` script and add `#!/usr/bin/php` at the top, which would tell the shell to use your `php` binary to interpret the script.

So `#!/usr/bash` means we are writing a bash script.

### Pipes

The pipe symbol: `|`.

In brief, a “pipe” in bash is a way to pass the output of the left hand command to the input of the right hand command.

So the order of the commands to be ran in the script is in this order:

1.  docker container ls
2.  fzf
3.  awk ‘{print $1}’
4.  xargs -o -I % docker exec -it % bash

### docker container ls

This gives us the list of currently-running containers on our system. The output is the list like so (I’ve used an image as the formatting gets messed up when pasting into a post as text) :

[![](/assets/2023-08-25-141854_2923x365_scr-GljfER6haBeh.png)](/assets/2023-08-25-141854_2923x365_scr-GljfER6haBeh.png)

### fzf

So the output of the `docker container ls` command above is the table in the image above, which is several rows of text.

`fzf` is a “fuzzy finder” tool, which can be passed a list of pretty much anything, which can then be searched over by “fuzzy searching” the list.

In this case the list is each row of that output (header row included)

When you select (press enter) on your chosen row, that row of text is returned as the output of the command.

[![](/assets/2023-08-25-142551_2927x416_scr-O9VVhR3oczrD.png)](/assets/2023-08-25-142551_2927x416_scr-O9VVhR3oczrD.png)

In this image example you can see I’ve typed in “app” to search for, and it has highlighted the closest matching row.

### awk ‘{print $1}’

`awk` is an extremely powerful tool, built into linux distributions, that allows you to parse structured text and return specific parts of that text.

`'{print $1}'` is saying “take whatever input I’m given, split it up based on a delimeter, and return the item that is 1st (`$1)`.

The default delimeter is a space. So looking at that previous image example, the first piece of text in the docker image rows is the image ID: \`”`df96280be3ad`” in the app image chosen just above.

So pressing enter for that row from fzf, wil pass it to `awk`, which will then split that row up by spaces and return you the first element from that internal array of text items.

### xargs -o -I % docker exec -it % bash

`xargs` is another powerful tool, which enables you to pass what ever is given as input, into another command. I’ll break it down further to explain the flow:

The beginning of the `xargs` command is as so:

Bash```
xargs -o -I %
```

`-o` is needed when running an “interactive application”. Since our goal is to “exec” on to the docker container we choose, interactive is what we need. `-o` means to “open stdin (standard in) as `/dev/tty` in the child process before executing the command we specify.

Next, `-I %` is us telling `xargs`, “when you next see the ‘%’ character, replace it with what we give you as input. Which in this case will be that docker container ID returned from the `awk` command previously.

So when you replace the `%` character in the command that we are giving `xargs`, it will read as such:

Bash```
docker exec -it df96280be3ad bash
```

This is will “exec” on to that docker container and immediately run “bash” in that container.

Goal complete.

## Put it in a script file

So all that’s needed now, is to have that full set of piped commands in an executable script:

Bash```
#!/bin/bash

docker container ls | fzf | awk '{print $1}' | xargs -o -I % docker exec -it % bash
```

My own version of this script is in a file called `[d8exec](https://github.com/davidpeach/dotfiles/blob/main/bin/.local/bin/d8exec)`, which after saving it I ran:

Bash```
chmod +x ./d8exec
```

## Call the script

In order to be able to call your script from anywhere in your terminal, you just need to add the script to a directory that is in your `$PATH`. I keep mine at `~/.local/bin/`, which is pretty standard for a user’s own scripts in Linux.

You can see how I set my own in [my `.bashrc` file here](https://github.com/davidpeach/dotfiles/blob/13af16df8ebd4a68b2774a46d566ba2edd31f6de/home/.bashrc#L157). The section that reads `$HOME/.local/bin` is the relevant piece. Each folder that is added to the `$PATH` is separated by the `:` character.

## Feel free to explore further

You can look over all of [my own little scripts](https://github.com/davidpeach/dotfiles/tree/main/bin/.local/bin) in my bin folder for more inspiration for your own bash adventures.

Have fun. And don’t put anything into your scripts that you wouldn’t want others seeing (api keys / secrets etc)