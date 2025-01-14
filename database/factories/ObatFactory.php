<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Obat>
 */
class ObatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create();
        $kataDasar = ['panadol', 'amoxicillin', 'paracetamol', 'ibuprofen', 'vitamin', 'antibiotik'];

        // Array awalan
        $awalan = ['neo', 'ultra', 'mega', 'super'];

        // Array akhiran
        $akhiran = ['plus', 'forte', 'XR', 'SR'];
        return [
            "nama_obat" => $faker->randomElement($kataDasar) . ' ' . $faker->randomElement($awalan) . ' ' . $faker->randomElement($akhiran),
            "kemasan" => $faker->randomElement(['Strip 10', 'Botol 50', 'Botol 100', 'Botol 200']),
            "harga" => $faker->randomElement([5000, 20000, 10000, 30000]),
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
