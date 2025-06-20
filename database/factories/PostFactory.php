<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(rand(6, 8)); // ini sengaja menggunakan fungsi rand() untuk mendpatkan bilangan random, aslinya bisa langsung masukkan angka ke dalam parameternya
        return [
            'title' => $title, // mangacu pada data '$title'
            'slug' => Str::slug($title), // menggunakan fungsi slug bawaan laravel
            'author_id' => User::factory(), // ini akan mentrigger UserFactory  untuk membuat data user, tiap kali data post dibuat, data user pun akan ikut dibuat
            'category_id' => Category::factory(),
            'body' => fake()->text()
        ];
    }
}
