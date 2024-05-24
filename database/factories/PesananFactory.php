<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pesanan>
 */
class PesananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $enum_status = ['Sedang Dijemput', 'Sudah Sampai Toko', 'Sedang Diproses', 'Sudah Di-packing', 'Sedang Dikirim ke Rumah', 'Selesai', 'Batal'];
        return [
            'jumlah' => fake()->randomDigitNotNull(),
            'status' => fake()->randomElement($enum_status),
            'dijemput' => fake()->boolean(),
            'diantar' => fake()->boolean(),
        ];
    }
}
