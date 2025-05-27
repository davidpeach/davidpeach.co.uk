---
title: Install MongoDB with Docker for local development
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2020-12-02T22:40:12.000Z
metadata:
  categories:
    - Programming
  tags:
    - Docker
    - Programming
    - Web Development
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=37826
  type: wordpress
  url: >-
    https://davidpeach.me/2020/12/02/install-mongodb-with-docker-for-local-development/
tags:
  - programming
---
Pull the docker image for mongo down to your computer.

`docker pull mongo`

Run the mongo container in the background, isolated from the rest of your computer.

\# Command explained below  
`docker run -d -p 27017:27017 --name mongodb mongo -v /data/db:/data/db`

What I love about this approach is that I don’t start muddying up my computer installing new programs — especially if it’s just for the purposes of experimenting with new technologies.

The main run command explained:

-   “docker run -d” tells docker to run in detached mode, which means it will run in the background. Otherwise if we close that terminal it will stop execution of the program docker is running (mongo in this case).
-   “-p 27017:27017” maps your computer’s port number 27017 so it forwards its requests into the container using the same port. (I always forget which port represents the computer and which is the container)
-   “–name mongodb” just gives the container that will be created a nice name. Otherwise Docker will generate and random name.
-   “mongo” is just telling Docker which image to create.
-   “-v /data/db:/data/db” tells Docker to map the `/data/db` directory on your computer to the `/data/db` directory in the container. This will ensure that if you restart the container, you will retain the mongo db data.