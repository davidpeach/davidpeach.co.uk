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

Welcome to my new website. Currently being built "in the wild" using [11ty](https://11ty.dev).

I got sick of using WordPress and not having an easy and full control over the entirety of my website. So this new site, at my original domain, is my place to 
really focus in on learning and sharing the best new features in front end technologies.

I am a backend (PHP) developer by trade, but have always had a cursory interest in front end technologies.

I want to start working on my front end skills too now.

## Blog

<ol role="list">
    {%- for post in posts -%}
    <li>
        <article>
            <h3>
                <a href="{{ post.url }}">
                    {{ post.data.title | safe }}
                </a> 
            </h3>
            <p>
                <a href="{{ post.url }}">
                    <date>{{ post.date | readableDate }}</date>
                </a>
            </p>
            <div>{{ post.content | safe }}</div>
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

