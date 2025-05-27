---
title: What is the PHP __call magic method?
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2022-05-29T20:07:07.000Z
metadata:
  featuredImage: https://davidpeach.me/wp-content/uploads/2020/07/php-elephant.jpg
  media:
    featuredImage: /assets/php-elephant-egADTv3BIGEv.jpg
  categories:
    - Programming
  tags:
    - PHP
  uuid: 11ty/import::wordpress::https://davidpeach.me/?p=44020
  type: wordpress
  url: https://davidpeach.me/2022/05/29/what-is-the-php-__call-magic-method/
tags:
  - programming
---
Consider this PHP class:

```
<?php
class FooClass
{
    public function bar(): string
    {
        return 'Bar';
    }
}
```

We could call the `bar` method as follows:

```
<?php
$fooClass = new FooClass;

$fooClass->bar();

// returns the string 'Bar'
```

However, in PHP, we have **the ability to call methods that don’t actually exist on a class**. They can instead be **caught by a “magic method” named `__call`**, which you can define on your class.

```
<?php
class BazClass
{
    public function __call(string $name, array $args)
    {
        // $name will be given the value of the method
        // that you are trying to call

        // $args will be given all of the values that
        // you have passed into the method you are
        // trying to call
    }
}
```

So if you instantiated the `BazClass` above and called a non-existing method on it with some arguments, you would see the following behavior:

```
<?php
$bazClass = new BazClass;
$bazClass->lolcats('are' 'awesome');
```

In this example, `BazClass`‘s `__call` method would catch this method call, **as there is no method on it named `lolcats`**.

The `$name` value in `__call` would then be set to the string “lolcats”, and the `$args` value would be set to the array `[0 => 'are', 1 => 'awesome']`.

You may not end up using the `__call` method much in your day to day work, but it is used by frameworks that you possibly _will_ be using, such as Laravel.