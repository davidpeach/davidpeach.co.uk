---
title: What the hell was I thinking
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2025-04-15T21:01:38.000Z
metadata:
  categories:
    - Journal
  tags:
    - Laravel
    - Programming
  uuid: >-
    11ty/import::wordpress::https://davidpeach.me/2025/04/15/what-the-hell-was-i-thinking/
  type: wordpress
  url: https://davidpeach.me/2025/04/15/what-the-hell-was-i-thinking/
tags:
  - journal
---
“What the hell was I thinking?”; “Huh?”; “Who’s the fucking idiot who did this?.. oh. It was me…”.

Three questions every developer / coder / programmer / whatever-er asks themselves from time to time.

And I am definitely no different.

I built an initial version of a web-based tool for work some time ago. I built it with some speed to get it done as quickly as possible. But I should have taken longer and focused in more on the ongoing code quality.

I wrote tests from the get-go, but I let it slip a little when I would dip back into the project for little updates and tweaks across the last twelve months.

The other day I ran a static analysis tool over the project for the first time.

Christ on a bike.

So for the past day or so I’ve been battling hard to climb up the 9 rung ladder to the highly sought after status of level 9 all green. (Larastan/phpstan this is).

I’m currently on level 7 with about 15 errors to fix.

I have found that from implementing the fixes — many of which have been type hinting and generics-related — I am understanding the code — and the underlying framework Laravel — much better.

I’ve even found a very odd design decision in Laravel. The \`auth()->id()\` method can return either of the following:

-   int
-   string
-   null

Why not just “int” and “null”?

Anyway.

It’s been fun and I’m looking forward to fighting through level 8 before defeating the final boss — level 9 All Green. 🟩🟩🟩🟩🟩