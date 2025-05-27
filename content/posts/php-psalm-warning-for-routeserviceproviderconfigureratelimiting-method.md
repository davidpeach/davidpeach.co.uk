---
title: PHP Psalm warning for RouteServiceProvider configureRateLimiting method
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2022-06-30T10:25:14.000Z
metadata:
  featuredImage: https://davidpeach.me/wp-content/uploads/2019/07/Laravel-logo.jpg
  media:
    featuredImage: /assets/Laravel-logo-E3pEQsXjBH6G.jpg
  categories:
    - Programming
  tags:
    - PHP
  uuid: 11ty/import::wordpress::https://davidpeach.me/?p=45003
  type: wordpress
  url: >-
    https://davidpeach.me/2022/06/30/php-psalm-warning-for-routeserviceproviderconfigureratelimiting-method/
tags:
  - programming
---
When running psalm in a Laravel project, I get the following error by default:

```
PossiblyNullArgument - app/Providers/RouteServiceProvider.php:45:46 - 
Argument 1 of Illuminate\Cache\RateLimiting\Limit::by cannot be null, 
possibly null value provided
```

This is the default implementation for `configureRateLimiting` in the `RouteServiceProvider` class in Laravel:

```
protected function configureRateLimiting()
{
    RateLimiter::for('api', function (Request $request) {
        return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
    });
}
```

I change it to the following to get psalm to pass (I’ve added named parameters and the `static` keyword before the callback function):

```
protected function configureRateLimiting()
{
    RateLimiter::for(name: 'api', callback: static function (Request $request) {
        $limitIdentifier = $request->user()?->id ?: $request->ip();
        if (!is_null($limitIdentifier)) {
            return Limit::perMinute(maxAttempts: 60)->by(key: $limitIdentifier);
        }
    });
}
```