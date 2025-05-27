---
title: How I deploy a Laravel project to a Kubernetes Cluster
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-12-05T21:21:14.000Z
metadata:
  featuredImage: https://davidpeach.me/wp-content/uploads/2019/07/Laravel-logo.jpg
  media:
    featuredImage: /assets/Laravel-logo-E3pEQsXjBH6G.jpg
  categories:
    - Programming
  tags:
    - CICD
    - devops
    - Draft Posts
    - Laravel
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=51437
  type: wordpress
  url: >-
    https://davidpeach.me/2023/12/05/how-i-deploy-a-laravel-project-to-a-kubernetes-cluster/
tags:
  - programming
---
WIP: post not yet finalized.

This is an overview of how I would setup a Kubernetes cluster, along with how I would set up my projects to deploy to that cluster.

This is a descriptive post and contains nothing technical in the setting up of this infrastructure.

That will come in future posts.

## Services / Websites I use

### Digital Ocean

Within Digital Ocean, I use their managed Kubernetes, Managed database, DNS, S3-compatible spaces with CDN and Container registry.

### Github

Github is what I use for my origin repository for all IaC code, and project code. I also use the actions CI features for automated tests and deployments.

### Terraform

I use Terraform for creating my infrastructure, along with Terraform cloud for hosting my Terraform state files.

## Setting up the infrastructure

I firstly set up my infrastructure in Digital Ocean and Github using Terraform.

This infrastructure includes these resources in Digital Ocean: **Kubernetes Cluster**, **Spaces bucket** and **Managed MySQL database**. As well as two Action secrets in Github for: **Digital Ocean Access Token** and the **Digital Ocean Registry Endpoint**.

After the initial infrastructure is setup — the Kubernetes cluster specifically, I then use Helm to install the **nginx-ingress-controller** into the cluster.

## Setting up a Laravel project

I use Laravel Sail for local development.

For deployments I write a separate Dockerfile which builds off of a php-fpm container.

Any environment variables I need, I add them as a Kubernetes secret via the kubectl command from my local machine.

### Kubernetes deployment file

All the things that my kubernetes cluster needs to know how to deploy my Laravel project are in a `deployment.yml` file in the project itself.

This file is used by the Github action responsible for deploying the project.

### Github action workflows

I add two workflow files for the project inside the `./.github/workflows/` directory. These are:

#### ci.yml

This file runs the full test suite, along with pint and larastan.

#### deploy.yml

This file is triggered only on the `main` branch, after the **Tests** (ci) action has completed successfully.

It will build the container image and tag it with the current git sha.

Following that, it will install doctl and authenticate with my Digital Ocean account using the action secret for the secret token I added during the initial Terraform stage.

Then it pushes that image to my Digital Ocean container registry.

The next step does a find and replace to the project’s `deployment.yml` file. I’ve included a snippet of that file below:

```
containers:
      - name: davidpeachcouk
        image: 
        ports:
        - containerPort: 9000
```

It replaces that `<IMAGE>` placeholder with the full path to the newly-created image. It uses the other Github secret that was added in the Terraform stage: the **Digital Ocean Registry Endpoint**.

Finally it sets up access to the Kubernetes cluster using the authenticated doctl command, before running the `deployment.yml` file with the kubectl command. After which, it just does a check to see that the deployment was a success.