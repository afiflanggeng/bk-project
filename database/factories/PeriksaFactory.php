<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Periksa>
 */
class PeriksaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_daftar_poli' => $this->faker->numberBetween(1, 10),
            'tgl_periksa' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'catatan' => $this->faker->sentence(),
            'biaya_periksa' => $this->faker->numberBetween(100000, 1000000),
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
