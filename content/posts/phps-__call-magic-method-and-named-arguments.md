---
title: PHP&#8217;s __call magic method and named arguments
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2022-05-29T20:08:01.000Z
metadata:
  featuredImage: https://davidpeach.me/wp-content/uploads/2020/07/php-elephant.jpg
  media:
    featuredImage: /assets/php-elephant-egADTv3BIGEv.jpg
  categories:
    - Programming
  tags:
    - PHP
  uuid: 11ty/import::wordpress::https://davidpeach.me/?p=44011
  type: wordpress
  url: >-
    https://davidpeach.me/2022/05/29/phps-__call-magic-method-and-named-arguments/
tags:
  - programming
---
Whilst working on a little library recently, I discovered some interesting behavior with PHP’s `__call` magic method. Specifically around using named arguments in methods that are caught by the `__call` method.

Given the following class:

```
<?php
class EmptyClass
{
    public function __call(string $name, array $args)
    {
        var_dump($args); die;
    }
}
```

Calling a non-existing method without named parameters would result in the arguments being given to `__call` as an indexed array:

```
$myClass = new EmptyClass;

$myClass->method(
    'Argument A',
    'Argument B',
);

// This var dumps: [0 => 'Argument A', 1 => 'Argument B']
```

However, passing those values with named parameters, will cause them to be given to `__call` as an associative array:

```
$myClass = new EmptyClass;

$myClass->method(
    firstArg: 'Argument A',
    secondArg: 'Argument B',
);

// This var dumps: ['firstArg' => 'Argument A', 'secondArg' => 'Argument B']
```

I’m not sure if this is helpful to anyone but I thought it was quite interesting so thought I’d share. 🙂