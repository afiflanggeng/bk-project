<?php

namespace Database\Factories;

use App\Models\Poli;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dokter>
 */
class DokterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $id_poli = Poli::all()->random()->id;
        return [
            'nama' => $this->faker->name(),
            'alamat' => $this->faker->address(),
            'no_hp' => $this->faker->phoneNumber('+628'),
            'id_poli' => $id_poli
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
