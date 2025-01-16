<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
class PasienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'alamat' => $this->faker->address(),
            'no_ktp' => $this->faker->unique()->numerify('############'),
            'no_hp' => $this->faker->phoneNumber(),
            'no_rm' => 'RM-' . $this->faker->unique()->numerify('#########'),
        ];
    }

    public function timestamp()
    {
        return $this->state(function (array $attributes) {
            return [
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });
    }
}
