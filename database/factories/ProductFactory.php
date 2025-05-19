<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'slug' => $this->faker->unique()->slug,
            'content' => $this->faker->paragraph,
            'category_id' => Category::factory(),
            'status_id' => Status::factory(),
            'img' => $this->faker->imageUrl(640, 480, 'products'), // Placeholder image URL
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'old_price' => $this->faker->randomFloat(2, 50, 1200), // Higher than price for realism
            'hit' => $this->faker->boolean(20), // 20% chance of being a hit
            'sale' => $this->faker->boolean(30), // 30% chance of being on sale
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
