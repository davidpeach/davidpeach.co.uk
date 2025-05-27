---
title: 'HTML 5: Omitting unnecessary speech marks'
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2012-08-08T16:03:00.000Z
metadata:
  categories:
    - Programming
  tags:
    - Programming
    - Web Development
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=41366
  type: wordpress
  url: https://davidpeach.me/2012/08/08/html-5-omitting-unnecessary-speech-marks/
tags:
  - programming
---
In my last post I described how it is possible to cut down on your HTML filesize and save some time in your coding by omitting optional closing tags.

As a follow up to that post I thought I’d also describe another process to save even more on your filesize and a little bit more time still.

Please note however, these examples i’m describing are really micro-optimizations. For every project you make to be the best that it can be, I would strongly recommend looking into combining your scripts into one single file and minifying it. Minifying your CSS can also go a long way to improving speed. Those techniques, as well as others, are a seperate issue but are definiately worth your time in learning.

### Back to the speech marks

A lot of us developers, me included, have a habit of wrapping up our attributes in speech marks, whether single or double, as in the following example:

```
<head>
  <meta charset="utf-8">
  <title>Example Title</title>
  <link rel="stylesheet" href="css/style.css">
</head>
```

The truth is, however, that in most cases you can leave the speech marks out completely, as in the following example:

```
<head>
  <meta charset=utf-8>
  <title>Example Title</title>
  <link rel=stylesheet href=css/style.css>
</head>
```

The browser will still render that correctly, and if you view the page source with the Chrome dev tools ‘inspect element’, you’ll see that the speech marks have in fact been put in for you!

### Most Cases you say?

There is one situation where you will still need to use speech marks. This is when attributes have more than one value, or includes any white space. For Example:

```
<section>
  <span class="main-class secondary-class"></span>
  <img class=section-image src="images/image name with spaces.jpg">
</section>
```

So as a rule, when declaring attributes on html elements, you can omit all speech marks where there’s no white space contained. This is because the attribute ends when it hits the white space. I hope this helps you all to add an extra little bit of optimization into both your workflow and the size of your code.

If you have any of your own tips for code optimization, please share it in the comments section below. Thanks!