<?php

namespace Database\Factories;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name"=> fake()->sentence(1,true),
            "description"=> fake()->paragraph(15,true),
            "obtained"=> fake()->dateTime()->format("Y-m-d"),
           // "image"=> fake()->imageUrl(640, 480, 'animals', true)
        ];
    }
}
