---
layout: layouts/mainlayout.njk
templateEngineOverride: njk,md
pagination:
    data: collections.post
    size: 10
    reverse: true
    alias: posts
permalink: "/{% if pagination.pageNumber > 0 %}page/{{ pagination.pageNumber | plus: 1 }}/{% endif %}index.html"
---

<div class="h-card">
    <a class="u-url u-uid" rel="me" href="{{ metadata.url }}">
        <img class="u-photo" src="/assets/me.jpg" alt="David Peach" width="150px" height="150px">
    </a>
    <p class="p-name">{{ metadata.author.name }}</p>
    <p class="p-note">{{ metadata.author.bio }}</p>
    <a class="u-email" href="mailto:{{ metadata.author.email }}">Contact Me</a>
</div>

Welcome to my new website. Currently being built "in the wild" using [11ty](https://11ty.dev).

I got sick of using WordPress and not having an easy and full control over the entirety of my website. So this new site, at my original domain, is my place to 
really focus in on learning and sharing the best new features in front end technologies.

I am a backend (PHP) developer by trade, but have always had a cursory interest in front end technologies.

I want to start working on my front end skills too now.

## Blog

<ol role="list" class="archive-roll">
    {%- for post in posts -%}
    <li>
        <article class="h-entry">
            {%- set kind = post.data.postKind | default("note") -%}
            {%- set post_content = post.content -%}
            {%- set post_date = post.date -%}
            {%- if kind == "note" -%}
            {%-  include "partials/note.njk" -%}
            {%- endif -%}
        </article>
    </li>
    {%- endfor -%}
</ol>
<nav aria-label="Pagination">
    <ul class="pagination-list">
        <li>
            {% if pagination.href.previous %}
            <a href="{{ pagination.href.previous }}">← Newer Posts</a>
            {% else %}
            <span>← Newer Posts</span>
            {% endif %}
        </li>
        <li>
            Page {{ pagination.pageNumber + 1 }} of {{ pagination.pages.length }}
        </li>
        <li>
            {% if pagination.href.next %}
            <a href="{{ pagination.href.next }}">Older Posts →</a>
            {% else %}
            <span>Older Posts →</span>
            {% endif %}
        </li>
    </ul>
</nav>

You can also find me in these other places:

<ul>
    <li><address><a href="https://github.com/davidpeach">Github</a></address>
    <li><address><a href="https://phpc.social/@peach">Mastodon</a></address>
</ul>

