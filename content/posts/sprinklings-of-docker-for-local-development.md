---
title: Sprinklings of Docker for local development
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2022-06-01T20:16:03.000Z
metadata:
  featuredImage: https://davidpeach.me/wp-content/uploads/2020/04/Docker-Swarm.jpg
  media:
    featuredImage: /assets/Docker-Swarm-dlRqURfTqiOa.jpg
  categories:
    - Programming
  tags:
    - Docker
  uuid: 11ty/import::wordpress::https://davidpeach.me/?p=43963
  type: wordpress
  url: >-
    https://davidpeach.me/2022/06/01/sprinklings-of-docker-for-local-development/
tags:
  - programming
---
When I search for docker-related topics online, it almost seems to me that there are two trains of thought for the most part:

-   Those who use a full docker / docker-compose setup for local development.
-   Those who hate and/or fear docker and would rather just install and do everything locally.

I believe either of these is a valid approach — whatever feels right to you. Of course it does also depend on how your company / team works.

But I’d like to introduce you to a third way of working on a project — sprinklings of docker, I call it 😀.

The idea is essentially to just use docker for certain things in a project as you develop it locally.

This is how I tend to work, but is by no means what I would call “the right way”; it’s just what works best for me.

## How I work with Docker.

I am primarily a [Laravel](https://laravel.com/) developer, and work as such at the excellent company — and [Laravel Partner](https://partners.laravel.com/partners/jump24) — [Jump 24](https://jump24.co.uk/).

As I am a php developer, it stands to reason that I have `php` installed on my system. I also have `nginx` installed, so I can run a php application locally and serve it at a local domain without needing docker.

Historically, when I would need a MySQL database (which is often the case) I would have gotten MySQL installed on my system.

Which is fine.

But I’m becoming a bit of a neat freak in my older age and so want to keep my computer as clean as possible within reason.

So what I do now is start a new docker container for MySQL and connect to that instead:

```
# Bash command to start up a docker container with MySQL in it
# And use port 33061 on my local machine to connect to it.
docker run \
--name=mysql \
--publish 33061:3306 \
--env MYSQL_DATABASE=my_disposable_db \
--env MYSQL_ROOT_PASSWORD=password \
--detach mysql
```

Then in my Laravel `.env` configuration I would add this:

```
DB_HOST=0.0.0.0:33061
DB_DATABASE=my_disposable_db
DB_USERNAME=root
DB_PASSWORD=password
```

The benefit of working this way is that if anything happens to my MySQL container — any corruptions or just ending up with a whole mess of databases old and new in there, I can just destroy the container and start a new one afresh.

Not to mention when I want to upgrade the MySQL version im working with… or even test with a _lower_ version.

```
docker container stop mysql
docker container rm mysql
# And then re-run the "docker run" command above.
# Or even run it with different variables / ports.
```

The same goes for any other database engines too: Postgres; Redis; MariaDB. Any can just be started up on your system as a standalone Docker container and connected to easily from your website / app in development.

```
# Start a Postgres container
docker run \
--name postgres \
--publish 5480:5432 \
--env POSTGRES_PASSWORD=password \
--detach postgres:11-alpine

# Start a redis container
docker run \
--name redis \
--publish 6379:6379 \
--detach redis

# Start a Mariadb container
docker run \
--name some-mariadb \
--publish 33062:3306 \
--env MARIADB_USER=example-user \
--env MARIADB_PASSWORD=my_cool_secret \
--env MARIADB_ROOT_PASSWORD=my-secret-pw  \
--detach mariadb
```

And with them all being self-contained and able to be exposed to any port on the host machine, you could have as many as you wanted running at the same time… if you were so inclined.

I love how this approach keeps my computer clean of extra programs. And how it makes it super easy to have multiple versions of the same thing installed at the same time.

Docker doesn’t have to be scary when taken in small doses. 😊