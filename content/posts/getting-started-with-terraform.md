---
title: Getting started with Terraform
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-11-29T18:02:00.000Z
metadata:
  featuredImage: https://davidpeach.me/wp-content/uploads/2023/11/terraform-logo.png
  media:
    featuredImage: /assets/terraform-logo-K8FQQ9HXOPgE.png
  categories:
    - Programming
  tags:
    - devops
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=51261
  type: wordpress
  url: https://davidpeach.me/2023/11/29/getting-started-with-terraform/
tags:
  - programming
---
Terraform is a program that can be used to build your cloud-based infrastructure based off of configuration files that you write. It’s a part of what is referred to as “Infrastructure as code (Iac)”.

Instead of going into various cloud provider UI dashboards and clicking around to build your resources, Terraform can do all that provisioning for you. It uses the cloud provider APIs behind the scenes — you just write exactly the infrastructure that you want to end up with at the end.

In this guide, we will provision a simple Digital Ocean Server (a Droplet in Digital Ocean parlance) using Terraform from our local terminal.

If you don’t yet have a Digital Ocean account, feel free to use [my referral link](https://m.do.co/c/47def9df1555) to set one up. With that link you’ll get $200 in credit to use over 60 days.

## Setting up Terraform in 4 steps

### 1 :: Install `terraform`

Terraform is available to install from pretty much all package repositories out there.

Installing it should be as simple as running a one-line command in your terminal.

### 2 :: Configure any required cloud provider API tokens

In order to let the Terraform program make changes to your cloud provider account, you will need to set up API tokens and tell Terraform where to find them.

In this post I’ll only be setting up a single one for Digital Ocean.

### 3 :: Write your `main.tf` configuration file

A single `main.tf` file will be enough to get you something working.

Add all of your needed resources / infrastructure in it.

### 4 :: Run the `apply` command

By running the `terraform apply` command against your `main.tf` file, you can turn your empty cloud infrastructure into a working setup.

## Step 1 :: Install Terraform

[Terraform’s documentation](https://developer.hashicorp.com/terraform/install) details the numerous ways of getting it installed across operating systems.

I use Arch Linux and so install it like so:

Bash```
sudo pacman -Sy terraform
```

You can check it is installed and discoverable on your system by checking the version you have installed:

Bash```
terraform -v

# My Output
Terraform v1.6.4
on linux_amd64
```

Now create an empty directory, which will be your “terraform project”. It doesn’t matter what you call the folder.

Then inside that file create a file called `main.tf`. We’ll come back to this file a little later.

## Step 2 :: Configure any required cloud provider API tokens

Head to [your Digital Ocean API Tokens dashboard](https://cloud.digitalocean.com/account/api/tokens) and click “Generate New Token”. Give it a name, choose an expiry and make sure you click the “write” permission option. Click “generate token”.

There are a number of ways we can tell Terraform what our Digital Ocean API Token is:

-   Obviously we could hard code it for the purposes of just getting it running while learning, though I wouldn’t recommend this approach even in testing.
-   Another is to use Terraform-specific environment variables set on your system. This has been my approach in the past. However, I came to realize how unsafe this was as every program you install has the potential to read from your environment variable.
-   A third way is to pass it as a parameter when calling the `apply` command.

I will be opting for that third option, but I don’t want to have that token saved in my history or have to pass it in everytime I want to run a Terraform command.

So my solution is to write a small wrapper bash script that will read the contents of a file in my home directory (with my token in) and pass it as an argument to the Terraform apply command.

### Creating a wrapper bash script to safely pass secret token to command

Create a file in your home directory called “terraform-test”. You can call it anything, just remember to reference it correctly when using it later in the guide.

Inside that file, paste only the API token that you got from your Digital Ocean API dashboard. Then save the file and close it.

Open a new file in the root of your Terraform project and add the following contents:

Bash```
#!/usr/bin/bash

terraform "$@" -var "do_token=$(cat ~/terraform-test)"
```

Save that file as “myterraformwrapper”. (You can call it whatever you want, I use “myterraformwrapper” as an example).

Also make sure to give it executable permissions by running the following command against it:

Bash```
chmod o+x myterraformwrapper
```

The `myterraformwrapper` script does the following:

1.  Calls the `terraform` command.
2.  Any arguments you pass to `myterraformwrapper` get put in the place of `"$@"`
3.  Appends on to the command, the `-var` flag and sets the `do_token` parameter to the contents of the `terraform-test` file you created previously.

This means:

Bash```
./myterraformwrapper apply
```

… behind the scenes, becomes…

Bash```
terraform apply -var "do_token=CONTENTS_OF_YOUR_DO_TOKEN"
```

This means that you are not having to keep passing your Digital Ocean token in for every command, and you wont end up accidentally leaking the token inside your shell’s `env` variables.

We will use that file later in this guide.

## Step 3 :: Write your main.tf configuration file

For this example, everything will be kept in a single file called `main.tf`. When you start working on bigger infrastructure plans, there is nothing stopping you from splitting out your configuration into multiple, single-purpose files.

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

provider "digitalocean" {
  token = var.do_token
}

resource "digitalocean_droplet" "droplet" {
  image    = "ubuntu-22-04-x64"
  name     = "terraform-test"
  region   = "lon1"
  size     = "s-1vcpu-1gb"
}
```

### `terraform` block

At the top of the file is the terraform block. This sets up the various providers that we want to work with for building out our infrastructure. In this example we only need the digital ocean one.

### `variable` declarations

Variable declarations can be used to keep sensitive information out of out configuration — and thus source control later, as well as making our configuration more reusable.

Each of the variables that our configuration needs to run must be defined as a `variable` like above. You can define variables in a few different ways, but here I have opted for the simplest.

We can see that all our configuration needs is a `do_token` value passed to it.

### `provider` setups

Each of the providers that we declare in our `terraform` block will probably need some kind of setup — such as an api token like our Digital Ocean example.

For us we can see that the setting up of Digital Ocean’s provider needs only a token, which we are passing it from the variable that we will pass in via the cli command.

### `resource` declarations

We then declare the “resources” that we want Terraform to create for us in our Digital Ocean account. In this case we just want it to create a single small droplet as a proof of concept.

The values I have passed to the `digitalocean_droplet` resource, would be great examples of where to use variables, potentially even with default placeholder values.

I have hard coded the values here for brevity.

## Step 4 :: Run the `apply` command

Before running `apply` for the first time, we first need to initialize the project:

Bash```
terraform init
# You should see some feedback starting with this:
Terraform has been successfully initialized!
```

You can also run `terraform plan` before the apply command to see what Terraform will be provisioning for you. However, when running `terraform apply`, it shows you the plan and asks for explicit confirmation before building anything. So I rarely use `plan`.

If you run `terraform apply`, it will prompt you for any variables that your `main.tf` requires — in our case the `do_token` variable. We could type it / paste it in every time we want to run a command. But a more elegant solution would be to use that custom bash script we created earlier.

Assuming that bash script is in our current directory — the Terraform project folder — run the following:

Bash```
./myterraformwrapper apply
```

This should display to you what it is planning to provision in your Digital Ocean account — a single Droplet.

Type the word “yes” and hit enter.

You should now see it giving you a status update every 10 seconds, ending in confirmation of the droplet being created.

If you hard back over to your Digital Ocean account dashboard, you should see that new droplet sitting there.

### Step 5 :: Bonus: destroying resources.

Just as Terraform can be used to create those resources, it can also be used to destroy them too. It goes without saying that you should always be mindful of just what you are destroying, but in this example we are just playing with a test droplet.

Run the following to destroy your newly-created droplet:

Bash```
./myterraformwrapper destroy
```

Again, it will first show you what it is planning to change in your account — the destruction of that single droplet.

Type “yes” and hit enter to accept.

## Next Steps

I love playing with Terraform, and will be sharing anything that I learn along my journey on my website.

You could start working through Terraform’s documentation to get a taste of what it can do for you.

You can even take a look at its excellent registry to see all of the providers that are available. Maybe even dig deep into the [Digital Ocean provider documentation](https://registry.terraform.io/providers/digitalocean/digitalocean/latest/docs) and see all of the available resources you could play with.

Just be careful how much you are creating and when testing don’t forget to run the `destroy` command when you’re done. The whole point of storing your infrastructure as code is that it is dead simple to provision and destroy it all.

Just don’t get leaving test resources up and potentially running yourself a huge bill.