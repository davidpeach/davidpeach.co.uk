---
title: WYSIWYGs will kill us all
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2014-03-14T14:22:00.000Z
metadata:
  categories:
    - Programming
  tags:
    - Programming
    - Web Development
    - wordpress
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=39353
  type: wordpress
  url: https://davidpeach.me/2014/03/14/wysiwygs-will-kill-us-all/
tags:
  - programming
---
So okay, maybe they wont literally kill us all, but you’ve got to admit — they can be pretty damn annoying. At least with ones I have used.

I’m not dissing wysiwygs — just what they get used for.

Firstly let me just say that I use a wysiwyg editor on my own blog and it does exactly what I need it to. I type text and it saves that text. I click to add a link and it adds a link. Brill!

For a blog, where writing long posts with the odd link and / or bolding of text, a wysiwyg really is great. But what I don’t believe in is using a wysiwyg for anything more than that.

Let me explain.

With a standard WordPress install, when you write a post or page, the content from the wysiwyg is spat out by the function `the_content()`. This displays all that content in one block within the page. Of course WordPress is — at its roots, a blogging platform (and a damn good one) so the ease of writing and publishing has always been at the forefront.

But what if our content is more than just a blog post? What if it’s an album or film review? Or specifications for a car? If we bundle all of the content into one block then we are a stepping away from what we need most nowadays, which is structured content.

## The need for Structured Data

The need for structured data these days is more important then ever. With the whole multi device landscape, a site’s content needs to be able to display beautifully whereever it is viewed. We need to be able to control as much of the content in as much of a modular way as possible. Also, as a result of making content more modular, it means it can be a lot easier to group and sort that content.

For example, if we have a database of 500 albums with all of the content for each album in its own single block of content, it makes it extremely difficult to categorize those into various artists or genres. Whereas if it was set it up in a way that has separate fields for each content chunk — an artist field; a genre field; etc — then those albums could be easily sorted and categorized.

Karen McGrane gave a fantastic talk at An Event Apart, Boston in 2012, where she talked about the TV Guide who made a wise decision about their content structure back in the 1980s. She talked about how the TV Guide wrote out three different descriptions of the same programmes — One small, one medium and one long. This was before TV on demand or Tivo, where now that sort of structured content is invaluable for use across different devices and contexts.

I recommend you watch the video, but I wanted to include a great quote from that talk here:

> …a clean base of presentation–independent, well–structured content that you have designed, from the start, with the intent that you may want it to go out and live on a wide variety of different platforms. In fact you know from the beginning this content is going to have to live in a variety of different places…
> 
> <cite>Karen McGrane An Event Apart, Boston, 2012</cite>

## Example – content for a music album

All the content for an album in one chunk:

```
<-- Output Html of the_content() in a wordpress site --> 
<p>This Train features 12 songs from the angelic, sometimes haunting, voice of Chrysta Bell. It was produced by David Lynch and features songs written by them both, including the track 'Polish Poem' from the film 'Inland Empire'.</p> 
<p>Artist: Chrysta Bell</p> 
<p>Produced by : David Lynch</p> 
<p>Release Date: September 29, 2011</p> 
<p>Tracklisting:</p>
<ol>
<li>This Train</li>
<li>Right Down To You</li>
<li>I Die</li>
<li>Swing With Me</li>
<li>Angel Star</li>
<li>Friday Night Fly</li>
<li>Down By Babylon</li>
<li>Real Love</li>
<li>Bird of Flames</li>
<li>Polish Poem</li>
<li>The Truth Is</li>
<li>All the Things</li>
</ol>
```

So while the above html code is okay, it doesn’t allow for much flexibility.

What happens if — in a few years — the website gets a complete redesign? Imagine there are 500 albums in the site’s database. Well then we’ve got a problem. We can have a lovely new shiny design but the bulk of the content is already set in stone somewhat.

In the example above we have the track listing below the review. What if we wanted to flip that? Or better yet, what if the new design wanted the track listing removed? What do we do then? Use regular expressions on the html to remove the track listing from the content?

No.

Also, as mentioned in Karen McGrane’s talk, the content should be able to live in a variety of different places. What happens if the content is viewed through a smart watch, or internet fridge? Will we want all of that content handed to us in one chunk?

Probably not.

Maybe we want to display just the Album title and artist with the option of loading in the track listing if needed.

In the music album example above, we can see sensible chunks of content that could be easily separated into sensible content chunks:

-   Track Listing
-   Review / Description (perhaps differing versions for use in different contexts?)
-   Producer
-   Artist
-   Title
-   Release Date

Using separate input fields for each of these chunks, means that each part of the content is individually available and much more flexible in how and where this content can be displayed.

WordPress has custom fields that can be entered on a per page/post basis, as well as the ability to add custom post types. No doubt other CMSs have similar options available — I’m just not very clued up on those ones.

The use of these custom fields is definitely a step in the right direction, but what we need is for CMSs to be more content-modular at their core. Like I said before, I’m not clued up on CMSs — other than WordPress and OpenCart — so please don’t hunt me down and shoot me in the face if there are indeed CMSs out there already like this.

And if there are please let me know of some good ones.

Tar!

## Inspiring this post

This post was originally going to be me snivel–bitching about wysiwygs. But I heard this podcast on the web ahead, which talks about content structure in great depth and it got me thinking about it in more detail than my initial post. The podcast also mentioned that talk by Karen McGrane.

On the evening of me writing this post, before publishing the following day, I travelled down to Milton Keynes Geek Night and saw five fantastic talks.

One of those talks was by [Relly Annett-Baker](https://24ways.org/authors/rellyannettbaker/) called ‘Future Perfect Tense: creating good content for an imperfect web’. A lot of what Relly was talking about was stuff I had been thinking about that day — so that was nice.

I will link the recording of the talk when it goes online as it is well worth a listen.