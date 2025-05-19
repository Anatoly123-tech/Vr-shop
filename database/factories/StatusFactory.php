<?php

namespace Database\Factories;

use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatusFactory extends Factory
{
    protected $model = Status::class;

    public function definition()
    {
        return [
            'title' => $this->faker->randomElement(['in_stock', 'out_of_stock', 'on_order']),
            'icon' => $this->faker->imageUrl(24, 24, 'icons'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
