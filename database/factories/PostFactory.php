<?php

namespace Database\Factories;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence;
        $date = new Carbon($this->faker->dateTime());

        return [
            'title' => $title,
            'body_raw' => $this->faker->paragraph,
            'status' => 'live',
            'published_at' => $date,
            'slug' => makePostSlug($date, $title),
        ];
    }
}
