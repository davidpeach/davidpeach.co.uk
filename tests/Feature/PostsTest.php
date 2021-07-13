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

    /** @test */
    public function guests_can_view_a_single_post()
    {
        $this->withoutExceptionHandling();
        $post = Post::factory()->create([
            'title' => 'The post title',
            'body' => 'This is the post content',
        ]);

        $response = $this->get(route('post.show', ['post' => $post]));
        $response->assertStatus(200);
        $response->assertSee('The post title')
                ->assertSee('This is the post content');
    }

    /** @test */
    public function i_can_visit_the_post_create_page()
    {
        $this->login();

        $response = $this->get('/posts/create');

        $response->assertStatus(200);
    }

    /** @test */
    public function guests_cannot_visit_the_post_create_page()
    {
        $response = $this->get('/posts/create');

        $response->assertStatus(302);
    }

    /** @test */
    public function i_can_create_posts_when_authenticated()
    {
        $this->login();

        $this->post(route('post.store'), [
            'title' => 'My created post',
            'body' => 'welcome to my post content',
        ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'My created post',
            'body' => 'welcome to my post content',
        ]);
    }
}
