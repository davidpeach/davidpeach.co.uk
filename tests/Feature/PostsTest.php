<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_can_view_an_archive_of_posts()
    {
        Post::factory()->count(3)
                ->state(new Sequence(
                    [
                        'title' => 'Post A Title',
                        'body' => 'This is the post A content',
                    ],
                    [
                        'title' => 'Post B Title',
                        'body' => 'This is the post B content',
                    ],
                    [
                        'title' => 'Post C Title',
                        'body' => 'This is the post C content',
                    ],
                ))
                ->create();

        $response = $this->get('/posts');

        $response->assertSee('Post A Title')
                ->assertSee('This is the post A content')
                ->assertSee('Post B Title')
                ->assertSee('This is the post B content')
                ->assertSee('Post C Title')
                ->assertSee('This is the post C content');
    }
}
