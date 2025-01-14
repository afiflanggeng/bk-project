<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DaftarPoli>
 */
class DaftarPoliFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_pasien' => $this->faker->numberBetween(1, 10),
            'id_jadwal' => $this->faker->numberBetween(1, 10),
            'keluhan' => $this->faker->sentence(),
            'no_antrian' => $this->faker->unique()->numerify('#########'),
            'status_periksa' => $this->faker->numberBetween(0, 1),
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
