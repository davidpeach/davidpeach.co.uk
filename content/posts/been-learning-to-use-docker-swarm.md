---
title: Been learning to use Docker Swarm
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2020-04-24T15:19:07.000Z
metadata:
  categories:
    - Notes
  tags:
    - Docker
    - Docker Swarm
    - Programming
    - Web Development
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=35937
  type: wordpress
  url: https://davidpeach.me/2020/04/24/been-learning-to-use-docker-swarm/
tags:
  - notes
---
After getting half-way through a Docker Mastery series on Udemy, I decided I would like to move my WordPress website, this one, to using a 3-node swarm.

After a few days of editing and re-arranging my docker-compose.yml file (the local dev configuration file that can also be used for starting up a swarm since compose version 3.3) I have decided to just keep my website hosted on its single regular server. (Although I had already moved the database to its own dedicated server).

Despite the fact that I haven’t actually managed to move over to using a swarm (and to be honest it isn’t even needed for me) I have managed to dive into a bunch of concepts around Docker and its Swarm component and feel that I have added a few new things to me dev toolkit.

I think I will definitely be putting together a little demo in a swarm across three separate servers. But for now I will keep my website settled as it is. 😀

What I _have_ learned – or rather reminded myself of, whilst sat in at home during this damn isolation, is that it is important to keep looking into complimentary technologies around my everyday development skill set.