---
title: Starting a new Laravel 9 project
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-01-13T12:49:23.000Z
metadata:
  featuredImage: https://davidpeach.me/wp-content/uploads/2019/07/Laravel-logo.jpg
  media:
    featuredImage: /assets/Laravel-logo-E3pEQsXjBH6G.jpg
  categories:
    - Programming
  tags:
    - CICD
    - Docker
    - Laravel
    - Linux
    - PHP
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=47286
  type: wordpress
  url: https://davidpeach.me/2023/01/13/starting-a-new-laravel-9-project/
tags:
  - programming
---
Whenever I start a new Laravel project, whether that’s a little side-project idea or just having a play, I try to follow the same process.

I recently read [Steve’s post here on starting your first Laravel 9 Application](https://laravel-news.com/your-first-laravel-9-application), so thought I would write down my own setup.

Whereas Steve’s guide walks you through the beginnings of building a new app, I’m only going to show what I do to get a new project in a ready state I’m happy with before beginning a build.

This includes initial setup, static analysis, xdebug setup and CI pipeline setup (with Github Actions).

* * *

## Pre-requisites

Before starting, I already have docker and docker-compose installed for my system (Arch Linux BTW).

Oh and `curl` is installed, which is used for pulling the project down in the initial setup.

Other than that, everything that is needed is contained within the Docker containers.

I then use [Laravel’s quick setup from their documentation](https://laravel.com/docs/9.x#getting-started-on-linux).

* * *

## Initial setup

Using Laravel’s magic endpoint here, we can get a new Laravel project setup with docker-compose support right out of the box. This could take a little time — especially the first time your run it, as it downloads all of the docker images needed for the local setup.

```
curl -s https://laravel.build/my-new-site | bash
```

At the end of the installation, it will ask you your password in order to finalise the last steps.

Once finished, you should be able to start up your new local project with the following command:

```
cd my-new-site

./vendor/bin/sail up -d
```

If you now direct your browser to `http://localhost` , you should see the default Laravel landing page.

* * *

## Code style fixing with Laravel Pint

Keeping a consistant coding style across a project is one of the most important aspects of development — especially within teams.

Pint is Laravel’s in-house development library to enable the fixing of any deviations from a given style guide, and is actually included as a dev dependancy in new Laravel projects.

Whether you accept it’s opinionated defaults or define your own rules in a “pint.json” file in the root of your project, is up to you.

In order to run it, you simply run the following command:

```
./vendor/bin/sail bin pint
```

A fresh installation of Laravel should give you no issues whatsoever.

I advise you to make running this command often — especially before making new commits to your version control.

* * *

## Static Analysis with Larastan

Static analysis is a great method for testing your code for things that would perhaps end up as run time errors in your code later down the line.

It analyses your code without executing it, and warns of any bugs and breakages it finds. It’s clever stuff.

Install Larastan with the following command:

```
./vendor/bin/sail composer require nunomaduro/larastan:^2.0 --dev
```

Create a file called “phpstan.neon” in the root of your project with the following contents:

```
includes:
    - ./vendor/nunomaduro/larastan/extension.neon

parameters:

    paths:
        - app/

    # Level 9 is the highest level
    level: 5
```

Then run the analyser with the following command:

```
./vendor/bin/sail bin phpstan analyse
```

You can actually set the level in your phpstan.neon file to 9 and it will pass in a fresh Laravel application.

The challenge is to keep it passing at level 9.

* * *

## Line by Line debugging with Xdebug

At the time of writing, xdebug does come installed with the Laravel sail dockerfiles. However, the setup does need an extra step to make it work fully (at least in my experience)

### Aside:

There are two parts to xdebug to think about and set up.

Firstly is the server configuration — this is the installation of xdebug on the php server and setting the correct configuration in the `xdebug.ini` file.

The second part is setting up your IDE / PDE to accept the messages that xdebug is sending from the server in order to display the debugging information in a meaningful way.

I will show here what is needed to get the server correctly set up. However, you will need to look into how your chosen editor works to receive xdebug messages. VS Code has a plugin that is apparently easy to setup for this.

I use Neovim, and will be sharing a guide soon for how to get debugging with xdebug working in Neovim soon.

### Enable Xdebug in Laravel Sail

In order to “turn on” xdebug in Laravel Sail, we just need to enable it by way of an environment variable in the `.env` file.

Inside your project’s `.env` file, put the following:

```
SAIL_XDEBUG_MODE=develop,debug
```

Unfortunately, in my own experience this hasn’t been enough to have xdebug working in my editor (Neovim). And looking around Stack Overflow et. al, I’m not the only one.

However, what follows is how I get the xdebug server correctly configured for me to debug in Neovim. You will need to take an extra step or two for your editor of choice in order to receive those xdebug messages and have them displayed for you.

### Publish the Sail runtime files

One thing Laravel does really well, is creating sensible defaults with the ease of overriding those defaults — and Sail is no different.

Firstly, publish the Laravel sail files to your project root with the following command:

```
./vendor/bin/sail artisan sail:publish
```

### Create an xdebug ini file

After publishing the sail stuff above, you will have a folder in the root of your project called “docker”. Within that folder you will have different folders for each of the supported PHP versions.

I like to use the latest version, so I would create my xdebug ini file in the `./docker/8.2/` directory, at the time of writing.

I name my file `ext-xdebug.ini`, and add the following contents to it. You may need extra lines added depending on your IDE’s setup requirements too.

```
[xdebug]
xdebug.start_with_request=yes
xdebug.discover_client_host=true
xdebug.max_nesting_level=256
xdebug.client_port=9003
xdebug.mode=debug
xdebug.client_host=host.docker.internal
```

### Add a Dockerfile step to use the new xdebug ini file

Within the Dockerfile located at ./docker/8.2/Dockerfile, find the lines near the bottom of the file that are copying files from the project into the container, and add another copy line below them as follows:

```
COPY start-container /usr/local/bin/start-container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY php.ini /etc/php/8.2/cli/conf.d/99-sail.ini
COPY ext-xdebug.ini /etc/php/8.2/cli/conf.d/ext-xdebug.ini
```

### Optionally rename the docker image

It is recommended that you rename the image name within your project’s `./docker-compose.yml` file, towards the top:

```
laravel.test:
    build:
        context: ./docker/8.2
        dockerfile: Dockerfile
        args:
            WWWGROUP: '${WWWGROUP}'
    image: sail-8.2/app
    image: renamed-sail-8.2/app
```

This is only if you have multiple Laravel projects using sail, as the default name will clash between projects.

### Rebuild the Image.

Now we need to rebuild the image in order to get our new xdebug configuration file into our container.

From the root of your project, run the following command to rebuild the container without using the existing cache.

```
./vendor/bin/sail build --no-cache
```

Then bring the containers up again:

```
./vendor/bin/sail up -d
```

* * *

## Continuous Integration with Github Actions

I use Github for storing a backup of my projects.

I have recently started using Github’s actions to run a workflow for testing my code when I push it to the repository.

In that workflow it first installs the code and it’s dependancies. It then creates an artifact tar file of that working codebase and uses it for the three subsequent workflows I run after, in parallel: **Pint code fixing**; **Larastan Static Analysis** and **Feature & Unit Tests**.

The full ci workflow file I use is stored as [a Github Gist](https://gist.github.com/davidpeach/20f60fb7425b729ac5f18c45c568798f). Copy the contents of that file into a file located in a `./.github/workflows/` directory. You can name the file itself whatever you’d like. A convention is to name it “ci.yml”.

### The Github Action yaml explained

#### When to run the action

Firstly I only want the workflow to run when pushing to any branch and when creating pull requests into the “main” branch.

```
on:
  push:
    branches: [ "*" ]
  pull_request:
    branches: [ "main" ]
```

#### Setting up the code to be used in multiple CI checks.

I like to get the codebase into a testable state and reuse that state for all of my tests / checks.

This enables me to not only keep each CI step separated from the others, but also means I can run them in parallel.

```
setup:
    name: Setting up CI environment
    runs-on: ubuntu-latest
    steps:
    - uses: shivammathur/setup-php@15c43e89cdef867065b0213be354c2841860869e
      with:
        php-version: '8.1'
    - uses: actions/checkout@v3
    - name: Copy .env
      run: php -r "file_exists('.env') || copy('.env.example', '.env');"
    - name: Install Dependencies
      run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
    - name: Generate key
      run: php artisan key:generate
    - name: Directory Permissions
      run: chmod -R 777 storage bootstrap/cache
    - name: Tar it up 
      run: tar -cvf setup.tar ./
    - name: Upload setup artifact
      uses: actions/upload-artifact@v3
      with:
        name: setup-artifact
        path: setup.tar
```

This step creates an artifact tar file from the project that has been setup and had its dependancies installed.

That tar file will then be called upon in the three following CI steps, extracted and used for each test / check.

#### Running the CI steps in parallel

Each of the CI steps I have defined — “pint”, “larastan” and “test-suite” — all require the “setup” step to have completed before running.

```
pint:
    name: Pint Check
    runs-on: ubuntu-latest
    needs: setup
    steps:
    - name: Download Setup Artifact
      uses: actions/download-artifact@v3
      with:
        name: setup-artifact
    - name: Extraction
      run: tar -xvf setup.tar
    - name: Running Pint
      run: ./vendor/bin/pint
```

This is because they all use the artifact that is created in that setup step. The artifact being the codebase with all dependancies in a testable state, ready to be extracted in each of the CI steps.

```
pint:
    name: Pint Check
    runs-on: ubuntu-latest
    needs: setup
    steps:
    - name: Download Setup Artifact
      uses: actions/download-artifact@v3
      with:
        name: setup-artifact
    - name: Extraction
      run: tar -xvf setup.tar
    - name: Running Pint
      run: ./vendor/bin/pint
```

Those three steps will be run in parallel as a default; there’s nothing we need to do there.

Using the example gist file as is, should result in a full passing suite.

* * *

## Further Steps

That is the end of my starting a new Laravel project from fresh, but there are other steps that will inevitably come later on — not least the Continuous Delivery (deployment) of the application when the time arrises.

You could leverage the excellent [Laravel Forge](https://forge.laravel.com) for your deployments — and I would actually recommend this approach.

However, I do have a weird interest in Kubernetes at the moment and so will be putting together a tutorial for deploying your Laravel Application to Kubernetes in Digital Ocean. Keep an eye out for that guide — I will advertise that post on [my Twitter page](https://twitter.com/iamdavidpeach) when it goes live.