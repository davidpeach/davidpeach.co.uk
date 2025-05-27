---
title: Given, When, Then &#8212; how I approach Test-driven development in Laravel
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-01-07T12:26:50.000Z
metadata:
  featuredImage: https://davidpeach.me/wp-content/uploads/2019/07/Laravel-logo.jpg
  media:
    featuredImage: /assets/Laravel-logo-E3pEQsXjBH6G.jpg
  categories:
    - Programming
  tags:
    - Laravel
    - PHP
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=41409
  type: wordpress
  url: >-
    https://davidpeach.me/2023/01/07/given-when-then-how-i-approach-test-driven-development-in-laravel/
tags:
  - programming
---
Laravel is an incredible PHP framework and the best starting point for pretty much any web-based application (if writing it in PHP, that is).

Along with it’s many amazing features, comes a beautiful framework from which to test what you are building.

For the longest time I cowered at the idea of writing automated tests for what I built. It was a way of working that was brought in by a previous workplace of mine and my brain fought against it for ages.

Since that time a few years ago I slowly came to like the idea of testing. Then over the past year or so I have grown to love it.

I have met some people that are incredibly talented developers, but for me made the prospect of automated testing both confusing and intimidating.

That was until I came across [Adam Wathan’s](https://adamwathan.me/) excellent [Test Driven Laravel](https://course.testdrivenlaravel.com/) course. He made testing immediately approachable and broke it down into three distinct phases (per test): “Given”, “When” and “Then”. Also known as “Arrange”, “Act” and “Assert”. I forget which phrase he used, but either way the idea is like this.

## “Given” this environment

The first step is to set up the “world” in which the test should happen.

One example would be if you were building an API that would return PlayStation game data to you. In order to return games, there must be games there to return.

In Laravel we have factories that we can create for quickly creating test entries for our models. Here is an example of a Game model that uses its factory to create a game for us:

```
$game = Game::factory()->create([
    'title' => 'The Last of Us part 2',
    'developer' => 'Naughty Dog',
]);
```

## “When” this thing I want to test happens

Here you would do the thing that you are testing.

Maybe that is sending some data to an API endpoint in your application. Or perhaps you are testing a single utility class can do a specific action, so you call the method on that class.

Here, let’s continue the idea of return games from an api call. We’ll use the `$game` variable from the previous example and access its ID to build our `GET` endpoint:

```
$response = $this->json('get', '/api/games/' . $game->id,);
```

Here the `$response` variable gets the response from the json get call, allowing you to later make assertions against it.

## “Then” I should see this particular outcome

In this last step you would make assertions against what has happened. This could be checking if a record exists in a database with specific values, or asserting that an email got sent.

Basically anything you need to make sure happened, or didn’t happen, for you to be sure you are getting your desired functionality.

Let’s finish our game example by asserting that we got json back with the expected data. We do this by calling the appropriate method off of the `$response` variable from the previous example.

```
$response->assertJson([
    'title' => 'The Last of Us part 2',
    'developer' => 'Naughty Dog',
]);
```

## The full example test code

```
$game = Game::factory()->create([
    'title' => 'The Last of Us part 2',
    'developer' => 'Naughty Dog',
]);
$response = $this->json('get', '/api/games/' . $game->id,);
$response->assertJson([
    'title' => 'The Last of Us part 2',
    'developer' => 'Naughty Dog',
]);
```

## Much more to explore

There is so much to automated testing and I’m still relatively new to it all myself.

You can “fake” other things in your application in order to not run live things in tests. For example when testing emails are sent you don’t really want to be actually sending emails when you run your tests. Therefore you would “fake” the functionality of sending the mail.

I hope that this post has been an easy-to-follow intro to how I myself approach testing.

I have found that even as my tests have gotten more complex in certain situations, I still always stick to the same structural idea:

1.  **Given** this is the world my code lives in.
2.  **When** I perform this particular action.
3.  **Then** I should see this specific outcome.