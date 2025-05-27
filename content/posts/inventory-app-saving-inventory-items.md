---
title: Inventory app &#8212; saving inventory items.
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-02-09T14:55:26.000Z
metadata:
  categories:
    - Programming
  tags:
    - PHP
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=47383
  type: wordpress
  url: https://davidpeach.me/2023/02/09/inventory-app-saving-inventory-items/
tags:
  - programming
---
This is the absolute bare bones minimum implementation for my inventory keeping: saving items to my inventory list.

Super simple, but meant only as an example of how I’d work when working on an API.

Here are the [changes made to my Inventory Manager](https://github.com/davidpeach/inventory/pull/3/files). Those changes include the test and logic for the initial index endpoint too. I may blog about that part in a separate post soon.

## Writing the store test

One of Laravel’s many strengths is how well it is set up for testing and just how nice those tests can read. Especially now that I’ve started using Pest.

[Here is the test](https://github.com/davidpeach/inventory/blob/4f119d4cd6e715cc22d8056a60045edefe8b4553/tests/Feature/Http/Controllers/Inventory/StoreControllerTest.php) I wrote for the `store` endpoint I was yet to write:

```
test('inventory items can be created', function () {
    $response = $this->postJson(route(name: 'inventory.store'), [
        'name' => 'My Special Item',
    ]);

    $response->assertStatus(201);

    $this->assertDatabaseHas(Inventory::class, [
        'name' => 'My Special Item',
    ]);
});
```

Firstly I post to an endpoint, that I am yet to create, with the most minimal payload I want: an item’s name:

```
$response = $this->postJson(route(name: 'inventory.store'), [
    'name' => 'My Special Item',
]);
```

Then I can check I have the correct status code: an HTTP Created 201 status:

```
$response->assertStatus(201);
```

Finally I check that the database table where I will be saving my inventory items has the item I have created in the test:

```
$this->assertDatabaseHas(Inventory::class, [
    'name' => 'My Special Item',
]);
```

The first argument to the `assertDatabaseHas` method is the model class, which Laravel will use to determine the name of the table for that model. Either by convention, or by the value you override it with on the model.

The second argument is an array that should match the table’s column name and value. Your model can have other columns and still pass. It will only validate that the keys and values you pass to it are correct; you don’t need to pass every column and value — that would become tedious.

## Writing the store logic

There is a term I’ve heard in Test-driven development called “sliming it out”. If I remember correctly, this is when you let the test feedback errors dictate every single piece of code you add.

You wouldn’t add any code at all until a test basically told you too.

I wont lie – I actually love this idea, but it soon becomes tiresome. It’s great to do when you start out in TDD, in my opinion, but soon you’ll start seeing things you can add before running the test.

For example, you know you’ll need a database table and a model class, and most likely a Model Factory for upcoming tests, so you could run the artisan command to generate those straight away:

```
php artisan make:model -mf Inventory

# or with sail
./vendor/bin/sail artisan make:model -mf Inventory
```

I dont tend to generate my Controller classes with these, as I now use single-action controllers for personal projects.

### Store Route

Within the `routes/web.php` file, I add the following:

```
use App\Http\Controllers\Inventory\StoreController;

Route::post('inventory', StoreController::class)->name('inventory.store');
```

Using a single-action class here to keep logic separated. Some would see this as over-engineering, especially if keeping controller code to a minimum anyway, but I like the separation.

Adding an explicit “name” to the endpoint, means I can just refer to it throughout the app with that name. Like in the test code above where I generate the endpoint with the “route” helper function:

```
route(name: 'inventory.store')
```

### Store Controller

```
<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Inventory;

use App\Http\Requests\InventoryStoreRequest;
use App\Models\Inventory;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class StoreController
{
    public function __invoke(InventoryStoreRequest $request): Response|ResponseFactory
    {
        Inventory::create([
            'name' => $request->get(key: 'name'),
        ]);

        return response(content: 'Inventory item created', status: 201);
    }
}
```

Super straight forward at the moment. After receiving the request via the custom request class (code below), I just create an inventory item with the name on the request.

I then return a response with a message and an HTTP Created 201 status.

This code does assume that it was created fine so I might look at a better implementation of this down the line…

…but not before I have a test telling me it needs to change.

### InventoryStoreRequest class

This is a standard generated request class with the following `rules` method:

```
/**
 * Get the validation rules that apply to the request.
 *
 * @return array<string, mixed>
 */
public function rules(): array
{
    return [
        'name' => 'required',
    ];
}
```

Again, nothing much to it. It makes sure that a name is required to be passed.

Its not saying anything about what that value could be. We could pass a date time or a mentally-long string.

I’ll fix that in a future post.

### An extra test for the required name

In order to be “belt and braces”, I have also added a test that proves that we require a name to be passed. Pest makes this laughable simple:

```
test('inventory items require a name', function () {
    $this->postJson(route(name: 'inventory.store'))
        ->assertJsonValidationErrorFor('name');
});
```

This just performs a post request to the store endpoint, but passes no data. We then just chain the `assertJsonValidationErrorFor` method, giving it the parameter that should have caused the failed validation. In this case “name”.

As the validation becomes more sophisticated I will look at adding more of these tests, and even possibly running all “required” fields through the some test method with Pests data functionality. Essentially the same as how PHPUnit’s Data Providers work.

## Useful Links

[Complete changes in git for when I added the store and the index endpoints to my Inventory app](https://github.com/davidpeach/inventory/pull/3/files).