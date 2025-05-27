---
title: 'CSS… how to use sass and compass: Part One'
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2012-07-23T09:58:00.000Z
metadata:
  categories:
    - Programming
  tags:
    - CSS
    - Programming
    - Web Development
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=41362
  type: wordpress
  url: https://davidpeach.me/2012/07/23/css-how-to-use-sass-and-compass-part-one/
tags:
  - programming
---
After listening to [Chris Coyier](http://web.archive.org/web/20120829033718/http://chriscoyier.net/) speak about using Sass in CSS, I read up on it and decided to give it a bash myself. And… oh my god… it… is… frickin’ awesome!

I love writing CSS anyway, so I wasn’t really thinking about anything to make it easier or quicker (which Sass does in spades). But what I didn’t expect was how much more creative it made me feel.

### So what are Sass and Compass?

In short, Sass is a CSS pre-processor. It enables you to write much more condensed stylesheets and then have sass ‘turn them into’ real CSS. On top of this it gives you a lot of nifty little abilities to really help with your workflow and avoid repetition of code. Compass is a separate entity and sits on top of Sass to give even more goodies.

I realize that to the uninitiated these terms may seem daunting – they did to me – but I can honestly say that once you get working with them you really will wonder how you did without them.

### Installing Sass and Compass (for windows)

What follows is how I installed Sass and Compass on my windows machine. I’ve included the installation here, but if you run on anything different, or find something not working for you, then please visit the documentation pages (links at end of this post). The docs are fantastic and will have you up and running in no time!

Firstly you’ll need to install Ruby. Don’t run away! This is all very easy, honest. Use one of the windows installers [here](http://web.archive.org/web/20120829033718/http://rubyinstaller.org/downloads/), and that’ll be that.

Once installed, open it up, type the following in and hit enter:

```
gem install sass
```

After a few seconds or so, Sass will be installed on your machine. Told you it was easy! Now you can leave it there and enjoy all of the fantastic benefits that Sass has to offer, or you can continue and install Compass in an equally simple way.

Type each line separate, hitting enter after you do:

```
gem update --system
gem install compass
```

And there you have it, Sass and Compass installed on your machine.

Next if you go to the compass install docs [here](http://web.archive.org/web/20120829033718/http://compass-style.org/install/), it will guide you through setting up your first project with compass. The reason I urge you to do this at least once, is that it will create a file called ‘config.rb’, which you will use in each project. It is the file that dictates how your styles will be compiled.

### Starting to use them in your projects

Again, I’d just like to point out that the following is how I use Sass and Compass in my own projects. There are ways of creating new projects in the command line, but I prefer to do it my own way. Mainly because, if I’m honest, the command line scares me.

For most of my projects I kick off with the [HTML5 Boilerplate](http://web.archive.org/web/20120829033718/http://html5boilerplate.com/). This is such a great resource for learning from if nothing more, but it’s also an awesome platform from which to start new projects. Get it [here](http://web.archive.org/web/20120829033718/http://html5boilerplate.com/).

Within the root directory of the Boilerplate folder, create a folder called ‘sass’ and paste the ‘config.rb’ file from the project created in the previous step. Within this config file you can edit certain properties to suit your needs. (I highly recommend setting the output style to ‘:compressed’, right before uploading to your live server)

The settings in my config file are as follows:

-   http\_path = “/”
-   css\_dir = “css”
-   sass\_dir = “sass”
-   images\_dir = “img”
-   javascripts\_dir = “js”
-   output\_style = :expanded

Lastly, to get us up and running, you need to create a file in the sass folder of your project. Let’s call it style.scss (please note the .scss extension). Then look inside your css folder of your project. If you have begun with the HTML5 Boilerplate, then there should already be a style.css file inside.

At this point, I would highly recommend making a copy of the style.css file and saving it elsewhere, perhaps to your desktop temporarily. This will become apparent as to why in part two of this tutorial.

Next, find and note down the location of your new project root (the one we are making with boilerplate, not the command line one). For Example, C:\\xampp\\htdocs\\PROJECT\_NAME (As I use xampp as my localhost). This may differ for you, but hopefully you should be able to work out your own. Then open up the ruby command prompt, type the following and hit enter:

```
cd\
```

This will set your path relative to your computer’s main hard drive. Then you simply tell compass to ‘watch’ your project for changes and to compile it into a css file:

```
compass watch xampp\htdocs\PROJECT_NAME
```

Obviously you would need to alter the path to match your own project location. If that has started correctly you should receive a message telling you that compass is ‘polling for changes’. What this means is that whatever changes are made to the sass file and saved, will be automatically converted into normal css.

Now, opening the style.scss file in your code editor, write any css style you like as a quick test. Write it exactly as you would in a normal css file, then save it. Now open up the style.css file and you should see that same code copied from the sass style file.

And that finishes off this introduction to sass and compass. I realize that the end result has given you nothing that is of use yet, but this was merely setting the stage for the awesomeness that is to come. In the next part I will show you how to further delve into the functionality of these great tools.

### Helpful Links

[Sass documentation](https://sass-lang.com/tutorial.html) | [Compass Documentation](https://compass-style.org/install/)