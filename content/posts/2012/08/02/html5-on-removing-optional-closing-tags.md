---
title: 'HTML5: On removing <em>optional</em> closing tags'
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2012-08-02T13:05:00.000Z
metadata:
  categories:
    - Programming
  tags:
    - Programming
    - Web Development
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=41368
  type: wordpress
  url: https://davidpeach.me/2012/08/02/html5-on-removing-optional-closing-tags/
tags:
  - programming
---
## Firstly, an example of some html…

```
<article>


  <p>Once upon a time there was a web programmer.</p>
  <p>He found that he wanted to cut down on his html filesize.</p>
  <p>He came up with a list of ideas. They were as follows:</p>


  <ul>
    <li>Minifying his code</li>
    <li>Cutting out content, (unacceptable!!!).</li>
    <li>Remove optional tags, speech marks, etc...</li>
  </ul>


  <p>On writing the last item in the list, he exclaimed, <em>That's amazing</em>, now to tell others...</p>


</article>
```

Lovely and semantic. Now, there’s nothing at all wrong with what I’ve written above. This article is all about showing you how there are certain things in your HTML that can be left out, without breaking any part of it.

You can actually omit many closing tags and still have it render exactly how you planned.

## The example above, after removing optional closing tags:

```
<article>


  <p>Once upon a time there was a web programmer.
  <p>He found that he wanted to cut down on his html filesize.
  <p>He came up with a list of ideas. They were as follows:


  <ul>
    <li>Minifying his code
    <li>Cutting out content, (unacceptable!!!).
    <li>Remove optional tags, speech marks, etc...
  </ul>


  <p>On writing the last item in the list, he exclaimed, <em>That's amazing</em>, now to tell others...


</article>
```

### The elements removed:

Paragraph closing tags can be omitted, because when the next one begins it knows that the last one has finished. Same with the list items also. Each list is begun with its \<li>. But you’ll notice other closing tags have been kept.

### The elements remaining:

The article still needs to be closed, as the browser will otherwise think the article is ongoing. The \</ul> has also been kept, as it wraps the list, and stops the last list item from continuing onwards. And lastly in the example above, the \</em> has remained, simply because, if left out, will continue to emphasize the rest of the paragraph.

### Common Errors to be aware of:

There may be times when you will omit a closing tag, but find it may mess up your code. For Example:

```
<article>
  <h1>The heading is as expected. Yay!
  <p>But the paragraph inherits styles from the <h1>, boo!
</article>
```

The above happens, quite simply, because the browser doesn’t know that the \<h1> should close. So as a result the paragraph is treated as though it is ‘wrapped within’ the \<h1>\</h1> tags. The \<h1> in the example above is closed by the browser, when it reaches the end of its parent continer, the \<article> And so ends up rendering as the following:

```
<article>
  <h1>The heading is as expected. Yay!
    <p>But the paragraph inherits styles from the <h1>, boo!</p>
  </h1>
</article>
```

Combating this, however, is easy. See the following:

```
<article>
  <header>
    <h1>The heading is now contained within both header tags that we close in the code...
  </header>
  <p>...and so now the heading styles wont bleed into this paragraph as they are contained in the <header>
</article>
```

### By way of summary

At first it can feel odd omitting these optional closing tags, but it will, in the long run, save you both time and those precious bytes. You just need to make sure you pick your times carefully. Generally, the rule I try to stick to is: if its a container with more than one type of child element (ie. article, section, div, nav etc.) close them off in your code. But if they are single entities, such as paragraphs, headings(of same number), lists etc, that are immediately preceded by the same tags, and have no differing siblings, omit the closing tag.

It will take a bit of getting used to, but if you nest your code well you will quickly begin to notice where you can omit closing tags.

### Developer inspect tools can help

I am a huge fan and regular user of the chrome developer tools. you can use its ‘inspect element’ feature to test out your code to see where the tags are being closed by the browser. Just write a paragraph without the closing tag and view it in the inspector. When you see it in the flesh and get used to how the browser renders your code, it will give you more confidence to omit those optional tags.

In Google Chrome, right click any part of the web page, and you should see the option to ‘inspect element’ towards the bottom.