<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name(),
            'author' => $this->faker->name(),
            'year' => $this->faker->year(),
            'genre' => $this->faker->name(),
        ];
    }
}
