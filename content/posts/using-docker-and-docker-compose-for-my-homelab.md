---
title: Using docker and docker compose for my Homelab
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-10-14T12:43:23.000Z
metadata:
  categories:
    - Programming
  tags:
    - Docker
    - homelab
    - Own Your Data
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=50815
  type: wordpress
  url: >-
    https://davidpeach.me/2023/10/14/using-docker-and-docker-compose-for-my-homelab/
tags:
  - programming
---
I’ve seen some very elaborate homelab set-ups online but wanted to get the easiest possible implementation I could, within my current skill set.

As I have quite a lot of experience with using docker for development in my day to day work, I thought I’d just try using docker compose to setup my homelab service

## What is docker?

Docker is a piece of software that allows you to package up your services / apps in to “containers”, along with any dependencies that they need to run.

What this means for you, is that you can define all of the things you need to make your specific app work in a configuration file, called a `Dockerfile`. When the container is then built, it builds it with all of the dependencies that you specify.

This is opposed to the older way of setting up a service / app /website, by installing the required dependencies manually on the host server itself.

By setting up services using docker (and its companion tool docker compose) You remove the need to install manual dependencies yourself.

Not only that, but if different services that you install require different versions of the same dependencies, containers keep those different versions separate.

## Installing the docker tools

I use the [guide for ubuntu](https://docs.docker.com/engine/install/ubuntu/) on the official docker website.

Once docker and docker compose are installed on the server, I can then use a single configuration file for each of the services I want to put into my Home Lab. This means I don’t need to worry about the dependencies that those services need to work — because they are in their own containers, they are self-contained and need nothing to be added to the host system.

There are services that can help you manage docker too. But that was one step too far outside of my comfort zone for what I want to get working right now.

I will, however, be installing a service called “Portainer”, detailed in my next Home Lab post, which gives you a UI in which to look at the docker services you have running.