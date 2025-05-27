---
title: 'CSS… how to use sass and compass: Part Two'
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2012-07-23T13:01:00.000Z
metadata:
  categories:
    - Programming
  tags:
    - CSS
    - Programming
    - Web Development
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=41364
  type: wordpress
  url: https://davidpeach.me/2012/07/23/css-how-to-use-sass-and-compass-part-two/
tags:
  - programming
---
Please note: for the sake of brevity, when using sass and compass, I refer to them both as compass.

Following on from our previous tutorial, I would like to introduce you to @import. @import is a css feature that will allow you to import stylesheets into one another. For example:

```
@import "normalize.css"; 
body{
    background:lightblue;
    width:1000px;
    margin:auto;
}
```

This will bring in ‘normalize.css’ from the same folder as the stylesheet itself, and then apply the body properties.

With this, however, it will grab each @import on page load and add unnecessary time to your page download speed. In this part of my compass tutorial, I will show you how to incorporate @import and use compass to compile them all into one stylesheet during production.

### How styles get compiled

Remember from the last part of the tutorial when we changed the style.scss file, and it updated our style.css one? Well we could in fact have any number of files, with different names, and they would each update in the same way. So if you had a base.scss, it would compile to base.css, typography.scss would update typography.css, and so on. You need not create the .css version either, as compass will do this for you automatically if it can’t find one when it compiles.

The way in which it compiles is defined in the config.rb file. As mentioned in the previous post, I highly recommend you set it to ‘:compressed’ before uploading to your server, as this will improve your page loading speed. The reason for this is that it removes any and all comments and white space.

### Example Stylesheet setup

Below I have listed the default structure of my stylesheets. Create them as .scss files in your sass folder and please note the underscores, as these are needed. You wont be needing any .css versions. The only css file you will need is style.css.

I recommend you save a copy of the whole project directory when you have these stylesheets setup. That way you will have a nice starting off point for each of your projects.

-   \_normalize.scss
-   \_helpers.scss
-   \_print.scss

Remember that stylesheet I advised you to temporarily save to your desktop? Well we are now going to bring that back in. If you open it in your code editor, you will see it is split into three main areas (not including the media queries part). The main code up top is the [normalize](http://web.archive.org/web/20120829033718/http://necolas.github.com/normalize.css/). Then you have useful helper classes, and finally a set of print styles.

Copy and paste each part of the stylesheet into their respective .scss files.

Now re-open your style.scss and delete any previous code out, and write the following:

```
@import "normalize";
@import "helpers";
@import "print";
```

Save it. Notice how I have _not_ included the underscore or the ‘.scss’ extension, as these are not required when importing them.

If it isn’t already running, start compass off watching your project as shown in the previous part. Compass should detect the changes to style.scss straight away and compile to its css equivalent. So now on re-opening style.css, you should see how normalize, helpers and print have all been pulled in from their imports on style.scss

What this now means is that you could theoretically split your styles into as many separate sheets as your wanted. As long as you remember to @import them into style.scss, then compass will see any changes to any of them and compile them all together into the one style.css. See, I told you they were awesome.

I encourage you to go now and experiment with splitting up your own stylesheets into manageable chunks. You will soon find a balance that suits your own tastes.

Thank you for reading the tutorials this far. I hope these first two parts have given you a good start with using sass and compass, although I did say I’d only refer to them as compass… Darn it! Oh well.

I realize this isn’t the most exciting of the features available to them. After all, I haven’t even mentioned mixins or even nesting (coming up in next part), but for me at least this has been the most indespensible of the features I’ve learnt so far.

I hope this helps you get up and running with Sass and Compass with ease. Let me know how you get on. Thanks.