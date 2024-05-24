<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\JenisCucian;
use App\Models\Pesanan;
use App\Models\Ulasan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Admin::factory()->count(3)->create();
        $user = User::factory()->count(10)->create();
        $jenis_cucian = JenisCucian::factory()->count(5)->create();

        for ($i = 1; $i <= 25; $i++) {
            Pesanan::factory()->for($user->random())->for($jenis_cucian->random())->has(Ulasan::factory())->create();
        }
    }
}
