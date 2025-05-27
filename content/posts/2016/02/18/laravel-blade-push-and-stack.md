---
title: Laravel Blade push and stack
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2016-02-18T15:46:29.000Z
metadata:
  categories:
    - Programming
  tags:
    - Laravel
    - PHP
    - Programming
    - Web Development
  uuid: 11ty/import::wordpress::https://chegalabonga.com/?p=13
  type: wordpress
  url: https://davidpeach.me/2016/02/18/laravel-blade-push-and-stack/
tags:
  - programming
---
Laravel’s blade view compiler is second to none. I’ve used a couple of different templating engines and blade is by far my favourite.

## Including Partials

The way in which we include partials of views within our main views is as follows:  
`@include(‘partials.my-first-partial’)`  
It will inject that partial’s content in the specified place.

## Defining Sections

Within our views, we define “sections” with the following syntax:

@section(‘section\_name’)

    The section’s content within here

@stop

And we can define as many sections as we need for our project.

## When the same section is used in multiple places within one compilation

Imagine we have master template file as such:

// layouts.main.blade.php
<!doctype html>

...

@yield(‘partials.form’)

...

@yield(‘custom\_scripts’)

Let’s suppose we have the following layout template that extends our main layout one and is including three partials. This example is a form template including its various inputs from separate partials. For my own website I have a different form for each of my post types and so I have the inputs in separate partials for easy reuse.

// partials.form.blade.php
@extends(‘layouts.main’)

\<form>@include(‘parials.form-title’)
@include(‘parials.form-content’)
@include(‘parials.form-tags’)\</form>

Let’s next suppose that in a couple of those partial input views you need to inject some custom scripting. This is a slightly contrived example, but it will illustrate the point.

// partials.form-content.blade.php
\<textarea class="content" name="content">\</textarea>

@section(‘custom\_scripts’)
// dummy javascript as example
$(‘.content’).doSomething();
@stop
// partials.form-tags.blade.php
\<select class="tags" name="tags">
\<option value="tagone">Tag One\</option>
\<option value="tagtwo">Tag Two\</option>
\<option value="tagthree">Tag Three\</option>
\</select>

@section(‘custom\_scripts’)
$(‘.tags’).doSomethingElse()
@stop

Now, when the form page gets compiled, only the first occurrence of the ‘custom\_scripts’ section will be included.

So what if you needed to be able to define this section in chunks across partials?

## Introducing Blade’s Push & Stack directives

To give this functionality, Laravel does in fact have two little-known directives called ‘push’ and ‘stack’.

They allow you to ‘stack up’ items across partials with the ‘push’ directive, which can then be echoed out together with the ‘stack’ directive.

Here’s the above form example but with ‘push’ and ‘stack’ used in place of ‘section’ and ‘yield’.

// layouts.main.blade.php
<!doctype html>

...

@yield(‘partials.form’)

...

@stack(‘custom\_scripts’)

// partials.form-content.blade.php
\<textarea class="content" name="content">\</textarea>

@push(‘custom\_scripts’)
// dummy javascript as example
$(‘.content’).doSomething();
@endpush
// partials.form-tags.blade.php
\<select class="tags" name="tags">
\<option value="tagone">Tag One\</option>
\<option value="tagtwo">Tag Two\</option>
\<option value="tagthree">Tag Three\</option>
\</select>

@push(‘custom\_scripts’)
$(‘.tags’).doSomethingElse()
@endpush

This will now compile all uses of the @push(‘custom\_scripts’) and echo them out as one wherever you call @stack(‘custom\_scripts’)

When I was shown this technique by a mate at work, it blew my mind.

Have fun.