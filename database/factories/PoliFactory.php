<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Poli>
 */
class PoliFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kataKunciPoli = ['umum', 'gigi', 'anak', 'dalam', 'bedah', 'kulit', 'mata', 'syaraf', 'jantung', 'paru'];
        return [
            'nama_poli' => $this->faker->randomElement($kataKunciPoli),
            'keterangan' => $this->faker->sentence(),
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
