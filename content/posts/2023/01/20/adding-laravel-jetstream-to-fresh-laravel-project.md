---
title: Adding Laravel Jetstream to a fresh Laravel project
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-01-20T18:29:47.000Z
metadata:
  featuredImage: https://davidpeach.me/wp-content/uploads/2023/01/jetstream-logo.jpg
  media:
    featuredImage: /assets/jetstream-logo-69xQgoy8KGeM.jpg
  categories:
    - Programming
  tags:
    - Laravel
    - PHP
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=47342
  type: wordpress
  url: >-
    https://davidpeach.me/2023/01/20/adding-laravel-jetstream-to-fresh-laravel-project/
tags:
  - programming
---
I only have this post here as there was a couple of extra steps I made after regular installation, which I wanted to keep a note of.

Here are the [changes made to my Inventory Manager](https://github.com/davidpeach/inventory/pull/2/files).

## Follow the Jetstream Installation guide

Firstly I just follow the [official installation guide](https://jetstream.laravel.com/2.x/installation.html).

When it came to running the Jetstream install command in the docs, this was the specific flavour I ran:

```
php artisan jetstream:install livewire --pest
```

This sets it up to use [Livewire](https://laravel-livewire.com/), as I wanted to learn that along the way, as well as setting up the Jetstream tests as [Pest](https://pestphp.com/) ones.

Again, I’m not too familiar with Pest (still loving phpunit) but thought it was worth learning.

## Enable API functionality

I want to build my Inventory Manager as a separate API and front end, so I enabled the API functionality after install.

Enabling the built-in API functionality, which is [Laravel Sanctum](https://laravel.com/docs/9.x/sanctum) by the way, is as easy as uncommenting a line in your `./config/jetstream.php` file:

```
'features' => [
    // Features::termsAndPrivacyPolicy(),
    // Features::profilePhotos(),
    Features::api(),
    // Features::teams(['invitations' => true]),
    Features::accountDeletion(),
],
```

The `Features::api(),` line should be commented out by default; just uncomment it and you’re good to go.

## Setup Pest testing

The only thing that tripped me up was that I hadn’t previously setup pest, which was causing the Jetstream tests to fail.

So I ran the following command, which is modified for my using [Laravel Sail](https://laravel.com/docs/9.x/sail), from the [Pest Documentation](https://pestphp.com/docs/plugins/laravel):

```
./vendor/bin/sail artisan pest:install
```

I then also added the `RefreshDatabase` trait to my `./tests/TestCase.php` file.

Then all of my tests pass.

That is Jetstream setup and ready to continue for me.