---
title: Setting up mine, and my family&#8217;s, Homelab
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-10-09T19:10:16.000Z
metadata:
  categories:
    - Programming
  tags:
    - Docker
    - homelab
    - Linux
    - Own Your Data
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=50798
  type: wordpress
  url: https://davidpeach.me/2023/10/09/setting-up-mine-and-my-familys-homelab/
tags:
  - programming
---
I’ve opted for what I believe is the easiest, and cheapest, method of setting up my Homelab.

I’m using my old work PC which has the following spec:

-   Quad core processor — i7, I think.
-   16gb of RAM
-   440GB ssd storage (2x 220gb in an LVM setup)
-   A USB plug-in network adapter (really want to upgrade to an internal one though)

## My Homelab Goals

My homelab goals are centered around two fundamental tenets: lower cost for online services and privacy.

I want to be:

-   **Hosting my own personal media backups**: All my personal photos and videos I want stored in my own installation of Nextcloud. Along with those I want to also utilize its organizational apps too: calendar; todos; project planning; contacts.
-   **Hosting my own music collection**: despite hating everything Google stands for, I do enjoy using its Youtube Music service. However, I have many CDs (yes, CDs) in the loft and don’t like the idea of essentially renting access to music. Plus it would be nice to streaming music to offline smart speakers (i.e. not Alexa; Google Speaker; et al.)
-   **Hosting old DVD films**: I have lots of DVDs in the loft and would like to be able to watch them (without having to buy a new DVD player)
-   **Learning more about networking**: configuring my own network is enjoyable to me and is something I want to increase my knowledge in. Hosting my own services for my family and myself is a great way to do this.
-   **Teach my Son how to own and control his own digital identity (he’s 7 months old)**: I want my Son to be armed with the knowledge of modern day digital existence and the privacy nightmares that engulf 95% of the web. And I want Him to have the knowledge and ability to be able to control his own data and identity, should He wish to when he’s older.

## Documenting my journey

I will be documenting my Homelab journey as best as I can, and will tag all of these posts with the [category of Homelab](https://davidpeach.me/category/homelab/).