<?php

namespace Tests\Feature;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_can_view_an_archive_of_posts_in_reverse_published_at_order()
    {
        Post::factory()->count(3)
                ->state(new Sequence(
                    [
                        'title' => 'Post A Title',
                        'body_html' => '<p>This is the post A content</p>',
                        'published_at' => new Carbon('1st January 2025'),
                    ],
                    [
                        'title' => 'Post B Title',
                        'body_html' => '<p>This is the post B content</p>',
                        'published_at' => new Carbon('1st December 2025'),
                    ],
                    [
                        'title' => 'Post C Title',
                        'body_html' => '<p>This is the post C content</p>',
                        'published_at' => new Carbon('1st July 2025'),
                    ],
                ))
                ->create();

        $response = $this->get('/posts');

        $response->assertSeeTextInOrder([
            'Post B Title',
            'published on 1st December, 2025',
            'This is the post B content',
            'Post C Title',
            'published on 1st July, 2025',
            'This is the post C content',
            'Post A Title',
            'published on 1st January, 2025',
            'This is the post A content',
        ]);
    }

    /** @test */
    public function guests_can_view_a_single_post()
    {
        $post = Post::factory()->create([
            'title' => 'The post title',
            'body_html' => 'This is the post content',
        ]);

        $response = $this->get(route('post.show', ['post' => $post]));
        $response->assertStatus(200);
        $response->assertSee('The post title')
                ->assertSee('This is the post content');
    }

    /** @test */
    public function i_can_visit_the_post_create_page()
    {
        $this->w();
        $this->login();

        $response = $this->get(route('dashboard.post.create'));

        $response->assertStatus(200);
    }

    /** @test */
    public function guests_cannot_visit_the_post_create_page()
    {
        $response = $this->get(route('dashboard.post.create'));

        $response->assertStatus(302);
    }

    /** @test */
    public function i_can_create_posts_when_authenticated()
    {
        $this->w();
        $this->login();

        $response = $this->post(route('dashboard.post.store'), [
            'title' => 'My created post',
            'body_raw' => "## welcome to my post content\nthis is the content\n\nthis is more content",
        ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'My created post',
            'body_raw' => "## welcome to my post content\nthis is the content\n\nthis is more content",
            'body_html' => "<h2>welcome to my post content</h2>\n<p>this is the content</p>\n<p>this is more content</p>\n",
        ]);

        $response->assertRedirect(route('post.show', 1));
    }

    /** @test */
    public function i_can_view_all_posts_in_the_dashboard()
    {
        $this->login();

        Post::factory()->count(3)
                ->state(new Sequence(
                    [
                        'title' => 'Post A Title',
                    ],
                    [
                        'title' => 'Post B Title',
                    ],
                    [
                        'title' => 'Post C Title',
                    ],
                ))
                ->create();

        $response = $this->get(route('dashboard.post.index'));

        $response->assertSee('Post A Title')
                ->assertSee('Post B Title')
                ->assertSee('Post C Title');
    }

    /** @test */
    public function guests_can_not_view_posts_in_the_dashboard()
    {
        $response = $this->get(route('dashboard.post.index'));

        $response->assertStatus(302);
    }

    /** @test */
    public function i_can_visit_the_post_edit_page_and_see_current_post_values()
    {
        $this->login();
        $this->w();
        $post = Post::factory()->create([
            'title' => 'Post title',
            'body_raw' => 'The post content',
            'body_html' => '<p>The post content</p>',
        ]);

        $response = $this->get(route('dashboard.post.edit', ['post' => $post]));

        $response->assertStatus(200);

        $response->assertSee('Post title')
            ->assertSee('The post content');
    }

    /** @test */
    public function i_can_update_existing_posts()
    {
        $this->login();

        $post = Post::factory()->create([
            'title' => 'Old post title',
            'body_raw' => 'Old post content',
            'body_html' => '<p>Old post content</p>',
        ]);

        $response = $this->put(route('dashboard.post.update', ['post' => $post]), [
            'title' => 'Updated title',
            'body_raw' => 'updated post content',
        ]);

        $response->assertRedirect(route('dashboard.post.index'));

        $this->assertDatabaseHas('posts', [
            'title' => 'Updated title',
            'body_raw' => 'updated post content',
            'body_html' => "<p>updated post content</p>\n",
        ]);
        $this->assertDatabaseMissing('posts', [
            'title' => 'Old post title',
            'body_raw' => 'Old post content',
            'body_html' => "<p>Old post content</p>\n",
        ]);
    }
}
