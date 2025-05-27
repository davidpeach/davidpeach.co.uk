---
title: Using ansible to prepare a digital ocean droplet to host a static website
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-08-29T12:58:00.000Z
metadata:
  featuredImage: https://davidpeach.me/wp-content/uploads/2023/08/ansible-logo.png
  media:
    featuredImage: /assets/ansible-logo-LTD7pe2ZWTJv.png
  categories:
    - Programming
  tags:
    - Ansible
    - devops
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=50722
  type: wordpress
  url: >-
    https://davidpeach.me/2023/08/29/using-ansible-to-prepare-a-digital-ocean-droplet-to-host-a-static-website/
tags:
  - programming
---
## Preface

This guide comes logically after the previous one I wrote about [setting up a digital ocean server with Terraform](https://davidpeach.me/2023/08/29/setting-up-a-digital-ocean-droplet-for-a-lupo-website-with-terraform/).

You can clone [my website’s ansible repository](https://github.com/davidpeach/davidpeach.me.ansible) for reference.

The main logic for this Ansible configuration happens in the `setup.yml` file. This file can be called whatever you like as we’ll call it by name later on.

## Installing Ansible

You can install Ansible with your package manager of choice.

I install it using pacman on Arch Linux:

Bash```
sudo pacman -S ansible
```

## The inventory.yml file

The inventory file is where I have set the relative configuration needed for the playbook.

The `all` key contains all of the host configurations (although I’m only using a single one).

Within that `all` key is `vars.ansible_ssh_private_key_file` which is just the local path to the ssh private key used to access the server.

This is the key I set up with Terraform in the previous guide.

Then the `hosts` key just contains the hosts I want to be able to target (im using the domain name that I set up in the previous Terraform guide)

## The setup.yml file explained

The setup.yml file is what is known as an “Ansible Playbook”.

From my limited working knowledge of Ansible, a playbook is basically a set of tasks that are run against a server or a collection of servers.

In my own one I am currently only running it against a single server, which I am targeting via its domain name of “zet.davidpeach.me”

YAML```
- hosts: all
  become: true
  user: root
  vars_files:
    - vars/default.yml
```

This first section is the setup of the playbook.

`hosts:all` tells it to run against all hosts that are defined in the `./inventory.yml` file.

`become:true` is saying that ansible will switch to the root user on the server (defined on the next line with `user: root`) before running the playbook tasks.

The `vars_files:` part lets you set relative paths to files containing variables that are used in the playbook and inside the file `./files/nginx.conf.j2`.

I wont go through each of the variables but hopefully you can see what they are doing.

### The Playbook Tasks

Each of the tasks in the Playbook has a descriptive title that hopefully does well in explaining what the steps are doing.

The key value pairs of configuration after each of the task `title`s are pre-defined settings available to use in ansible.

The tasks read from top to bottom and essentially automate the steps that normally need to be manually done when preparing a server.

## Running the playbook

Bash```
cd ansible-project

ansible-playbook setup.yml -i inventory.yml
```

This command should start Ansible off. You should get the usual message about trusting the target host when first connecting to the server. Just answer “yes” and press enter.

You should now see the output for each step defined in the playbook.

The server should now be ready to deploy to.

## Testing your webserver

In the `./files/nginx.conf.j2` there is a `root` directive on live 3. For me this is set to `/var/www/{{ http_host }}`. (`http_host` is a variable set in the `vars/default.yml` file).

SSH on to the server, using the private ssh key from the keypair I am using (see the Terraform guide for reference).

Bash```
ssh -i ~/.ssh/id_rsa.davidpeachme zet.davidpeach.me
```

Then on the server, create a basic `index.html` file in the website root defined in the default nginx file:

Bash```
cd /var/www/zet.davidpeach.me
touch index.html
echo "hello world" > index.html
```

Now, going to your website url in a browser, you should be able to see the text “hello world” in the top left.

The server is ready to host a static html website.

## Next Step

You can use whatever method you prefer to get your html files on to your server.

You could use `rsync`, `scp`, an overly-complicated CI pipeline, or – if your’e using lupo – your could have lupo deploy it straight to your server for you.