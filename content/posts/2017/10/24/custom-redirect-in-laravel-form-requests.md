---
title: How to easily set a custom redirect in Laravel form requests
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2017-10-24T18:00:00.000Z
metadata:
  featuredImage: https://davidpeach.me/wp-content/uploads/2017/10/DOHaH57XcAArzKt.jpg
  media:
    featuredImage: /assets/DOHaH57XcAArzKt-FCkUKFGewMY3.jpg
  categories:
    - Programming
  tags:
    - Laravel
    - PHP
    - Programming
    - Web Development
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=13636
  type: wordpress
  url: https://davidpeach.me/2017/10/24/custom-redirect-in-laravel-form-requests/
tags:
  - programming
---
In [Laravel](https://laravel.com) you can create custom request classes where you can house the validation for any given route. If that validation then fails, Laravel’s default action is to redirect the visitor back to the previous page. This is commonly used for when a form is submitted incorrectly – The visitor will be redirected back to said form to correct the errors. Sometimes, however, you may wish to redirect the visitor to a different location altogether.

## TL;DR (Too long; didn’t read)

At the top of your custom request class, add one of the following protected properties and give it your required value. I have given example values to demonstrate:

```
protected $redirect = '/custom-page'; // Any URL or path
protected $redirectRoute = 'pages.custom-page'; // The named route of the page
protected $redirectAction = 'PagesController@customPage'; // The controller action to use.
```

This will then redirect your visitor to that location should they fail any of the validation checks within your custom form request class.

## Explaination

When you create a request class through the Laravel artisan command, it will create one that extends the base Laravel class [`Illuminate\Foundation\Http\FormRequest`](https://github.com/laravel/framework/blob/5.5/src/Illuminate/Foundation/Http/FormRequest.php). Within this class the three protected properties listed above are initialised from **line 33**, but not set to a value.

Then further down the page of the base class, on **line 127** at the time of writing, there is a protected method called `getRedirectUrl`. This method performs a series of checks for whether or not any of the three redirect properties have actually been set. The first one it finds to be set by you, in the order given above, is the one that will be used as the custom redirect location.

Here is that `getRedirectUrl` method for your convenience:

```
/**
* Get the URL to redirect to on a validation error.
*
* @return string
*/
protected function getRedirectUrl()
{
    $url = $this->redirector->getUrlGenerator();

    if ($this->redirect) {
        return $url->to($this->redirect);
    } elseif ($this->redirectRoute) {
        return $url->route($this->redirectRoute);
    } elseif ($this->redirectAction) {
        return $url->action($this->redirectAction);
    }

    return $url->previous();
}
```

Do you have any extra tips to add to this? Let me know in the comments below.

Thanks.