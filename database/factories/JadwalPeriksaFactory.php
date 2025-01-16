<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JadwalPeriksa>
 */
class JadwalPeriksaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
        return [
            'id_dokter' => $this->faker->numberBetween(1, 10),
            'hari' => $this->faker->randomElement($hari),
            'jam_mulai' => $this->faker->time(),
            'jam_selesai' => $this->faker->time(),
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
