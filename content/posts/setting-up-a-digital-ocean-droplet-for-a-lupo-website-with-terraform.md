---
title: Setting up a Digital Ocean droplet for a Lupo website with Terraform
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-08-29T11:24:00.000Z
metadata:
  featuredImage: https://davidpeach.me/wp-content/uploads/2023/11/terraform-logo.png
  media:
    featuredImage: /assets/terraform-logo-K8FQQ9HXOPgE.png
  categories:
    - Programming
  tags:
    - Digital Ocean
    - Lupo
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=50720
  type: wordpress
  url: >-
    https://davidpeach.me/2023/08/29/setting-up-a-digital-ocean-droplet-for-a-lupo-website-with-terraform/
tags:
  - programming
---
## Overview of this guide

[My Terraform Repository used in this guide](https://github.com/davidpeach/davidpeach.me.terraform)

Terraform is a program that enables you to set up all of your cloud-based infrastructure with configuration files. This is opposed to the traditional way of logging into a cloud provider’s dashboard and manually clicking buttons and setting up things yourself.

This is known as “Infrastructure as Code”.

It can be intimidating to get started, but my aim with this guide is to get you to the point of being able to deploy a single server on Digital Ocean, along with some surrounding items like a DNS A record and an ssh key for remote access.

This guide assumes that you have a Digital Ocean account and that you also have your domain and nameservers setup to point to Digital Ocean.

You can then build upon those foundations and work on building out your own desired infrastructures.

## The Terraform Flow

As a brief outline, here is what will happen when working with terraform, and will hopefully give you a broad picture from which I can fill in the blanks below.

-   Firstly we write a configuration file that defines the infrastructure that we want.
-   Then we need to set up any access tokens, ssh keys and terraform variables. Basically anything that our Terraform configuration needs to be able to complete its task.
-   Finally we run the `terraform plan` command to test our infrastructure configuration, and then `terraform apply` to make it all live.

## Installing the Terraform program

Terraform has [installation instructions](https://developer.hashicorp.com/terraform/downloads?product_intent=terraform), but you may be able to find it with your package manager.

Here I am installing it on Arch Linux, by the way, with `pacman`

Bash```
sudo pacman -S terraform
```

## Setting the required variables

The configuration file for the infrastructure I am using requires only a single variable from outside. That is the `do_token`.

This is created manually in the [API section of the Digital Ocean dashboard](https://cloud.digitalocean.com/account/api/tokens). Create yours and keep its value to hand for usage later.

Terraform accepts variables in a number of ways. I opt to save my tokens in my local password manager, and then use them when prompted by the terraform command. This is slightly more long-winding than just setting a terraform-specific `env` in your bashrc. However, I recently learned off [rwxrob](http://rwxrob.tv) how much of a bad idea that is.

## Creating an ssh key

In the main.tf file, I could have set the ssh public key path to my existing one. However, I thought I’d create a key pair specific for my website deployment.

Bash```
ssh-keygen -t rsa
```

I give it a different name so as to not override my standard `id_rsa` one. I call it `id_rsa.davidpeachme` just so I know which is my website server one at a glance.

## Describing your desired infrastructure with code

Terraform uses a declaritive language, as opposed to imperetive.

What this means for you, is that you write configuration files that describe the state that you want your infrastructure to be in. For example if you want a single server, you just add the server spec in your configuration and Terraform will work out how best to create it for you.

You dont need to be concerned with the nitty gritty of how it is achieved.

I have a real-life example that will show you exactly what a minimal configuration can look like.

Clone / fork [the repository for my website server](https://github.com/davidpeach/davidpeach.me.terraform).

## Explaination of my terraform repository

YAML```
terraform {
  required_providers {
    digitalocean = {
      source = "digitalocean/digitalocean"
      version = "~> 2.0"
    }
  }
}

variable "do_token" {}

# Variables whose values are defined in ./terraform.tfvars
variable "domain_name" {}
variable "droplet_image" {}
variable "droplet_name" {}
variable "droplet_region" {}
variable "droplet_size" {}
variable "ssh_key_name" {}
variable "ssh_local_path" {}

provider "digitalocean" {
  token = var.do_token
}
```

The first block tells terraform which providers I want to use. Providers are essentially the third-party APIs that I am going to interact with.

Since I’m only creating a Digital Ocean droplet, and a couple of surrounding resources, I only need the digitalocean/digitalocean provider.

The second block above tells terraform that it should expect – and require – a single variable to be able to run. This is the Digital Ocean Access Token that was obtained above in the previous section, from the Digital Ocean dashboard.

Following that are the variables that I have defined myself in the `./terraform.tfvars` file. That tfvars file would normally be kept out of a public repository. However, I kept it in so that you could hopefully just fork my repo and change those values for your own usage.

The bottom block is the setting up of the provider. Basically just passing the access token into the provider so that it can perform the necessary API calls it needs to.

YAML```
resource "digitalocean_ssh_key" "ssh_key" {
  name       = var.ssh_key_name
  public_key = file(var.ssh_local_path)
}
```

Here is the first resource that I am telling terraform to create. Its taking a public key on my local filesystem and sending it to Digital Ocean.

This is needed for ssh access to the server once it is ready. However, it is added to the root account on the server.

I use Ansible for setting up the server with the required programs once Terraform has built it. So this ssh key is actually used by Ansible to gain access to do its thing.

I will have a separate guide soon on how I use ansible to set my server up ready to host my static website.

YAML```
resource "digitalocean_droplet" "droplet" {
  image    = var.droplet_image
  name     = var.droplet_name
  region   = var.droplet_region
  size     = var.droplet_size
  ssh_keys = [digitalocean_ssh_key.ssh_key.fingerprint]
}
```

Here is the meat of the infrastructure – the droplet itself. I am telling it what operating system image I want to use; what size and region I want; and am telling it to make use of the ssh key I added in the previous block.

YAML```
data "digitalocean_domain" "domain" {
  name = var.domain_name
}
```

This block is a little different. Here I am using the `data` property to grab information about something that **already exists** in my Digital Ocean account.

I have already set up my domain in Digital Ocean’s networking area.

This is the overarching domain itself – not the specific A record that will point to the server.

The reason i’m doing it this way, is because I have got mailbox settings and TXT records that are working, so i dont want them to be potentially torn down and re-created with the rest of my infrastructure if I ever run `terraform destroy`.

YAML```
resource "digitalocean_record" "record" {
  domain = data.digitalocean_domain.domain.id
  type   = "A"
  name   = "@"
  ttl    = 60
  value  = "${digitalocean_droplet.droplet.ipv4_address}"
}
```

The final block creates the actual A record with my existing domain settings.

It uses the domain id given back by the data block i defined above, and the ip address of the created droplet for the A record value.

## Testing and Running the config to create the infrastructure

If you now go into the root of your terraform project and run the following command, you should see it displays a write up of what it intends to create:

Bash```
terraform plan
```

If the output looks okay to you, then type the following command and enter “yes” when it asks you:

Bash```
terraform apply
```

This should create the three items of infrastructure we have defined.

## Next Step

Next we need to set that server up with the required software needed to run a static html website.

I will be doing this with a program called Ansible.

I’ll be writing up those steps in a zet very soon.