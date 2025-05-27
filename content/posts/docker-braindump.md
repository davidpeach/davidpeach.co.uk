---
title: Docker braindump
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2020-04-24T15:30:55.000Z
metadata:
  categories:
    - Notes
  tags:
    - braindumps
    - Docker
    - Docker Swarm
    - Programming
    - Web Development
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=35941
  type: wordpress
  url: https://davidpeach.me/2020/04/24/docker-braindump/
tags:
  - notes
---
These are currently random notes and are not much help to anybody yet. They will get tidied as I add to the page.

## Docker Swarm

### Docker swarm secrets

From inside a docker swarm manager node, there are two ways of creating a secret.

Using a **string value**:

`printf <your_secret_value> | docker secret create your_secret_key -`

Using a **file path**:

`docker secret create your_secret_key ./your_secret_value.json`

Docker swarm secrets are saved, **encrypted**, and are **accessible to containers via a filepath**:

`/run/secrets/your_secret_key`.

### Posts to digest

[https://www.bretfisher.com/docker-swarm-firewall-ports/](https://www.bretfisher.com/docker-swarm-firewall-ports/)

[https://www.bretfisher.com/docker/](https://www.bretfisher.com/docker/)

[https://www.digitalocean.com/community/tutorials/how-to-set-up-laravel-nginx-and-mysql-with-docker-compose](https://www.digitalocean.com/community/tutorials/how-to-set-up-laravel-nginx-and-mysql-with-docker-compose)