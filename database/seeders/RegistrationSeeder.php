<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Registration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $divisions = Division::all();

        if ($divisions->isEmpty()) {
            $this->command->warn('⚠️ RegistrationSeeder: Divisi tidak ditemukan, pendaftar tidak bisa di-seed.');
            return;
        }

        for ($i = 1; $i <= 10; $i++) {
            Registration::create([
                'name' => fake()->name(),
                'nim' => '22' . fake()->numerify('#####'),
                'study_program' => fake()->randomElement(['Teknik Informatika', 'Sistem Informasi', 'Bisnis Digital']),
                'batch_year' => '202' . rand(2, 4),
                'email' => fake()->unique()->safeEmail(),
                'phone' => '0812' . fake()->numerify('########'),
                'birth_place' => fake()->city(),
                'birth_date' => fake()->dateTimeBetween('-22 years', '-18 years')->format('Y-m-d'),
                'address' => fake()->address(),
                'division_id' => $divisions->random()->id,
                'reason' => 'Ingin menambah pengalaman dan belajar banyak hal baru terkait divisi ini di UKM IT COS.',
                'created_at' => now()->subDays(rand(1, 30)),
            ]);
        }

        $this->command->info('✅ RegistrationSeeder: Data pendaftar dummy berhasil di-seed.');
    }
}
