<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'species' => $this->faker->randomElement(['สุนัข', 'แมว', 'ปลา']),
            'breed' => $this->faker->randomElement(['โกลเด้นรีทรีฟเวอร์', 'เปอร์เซีย']),
            'age' => $this->faker->numberBetween(1, 120),
            'price' => $this->faker->randomFloat(2, 100, 10000),
            'status' => $this->faker->randomElement(['available', 'sold']),
            'detail' => $this->faker->sentence,
            'photo' => $this->faker->imageUrl(),
        ];
    }
}
