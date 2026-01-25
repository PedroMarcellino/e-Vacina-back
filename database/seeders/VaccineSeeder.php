<?php

namespace Database\Seeders;

use App\Models\Vaccine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class VaccineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vaccines = [
            ['name' => 'BCG', 'age_range' => 'Bebe'],
            ['name' => 'Hepatite B', 'age_range' => 'Bebe'],
            ['name' => 'Pentavalente', 'age_range' => 'Bebe'],
            ['name' => 'Poliomielite (VIP/VOP)', 'age_range' => 'Bebe'],
            ['name' => 'Rotavírus', 'age_range' => 'Bebe'],
            ['name' => 'Pneumocócica 10', 'age_range' => 'Bebe'],
            ['name' => 'Meningocócica C', 'age_range' => 'Bebe'],
            ['name' => 'Febre Amarela', 'age_range' => 'Bebe'],
            ['name' => 'Tríplice Viral (SCR)', 'age_range' => 'Bebe'],
            ['name' => 'Tetraviral (SCRV)', 'age_range' => 'Bebe'],
            ['name' => 'Hepatite A', 'age_range' => 'Bebe'],
            ['name' => 'DTP', 'age_range' => 'Bebe'],
            ['name' => 'Varicela', 'age_range' => 'Bebe'],

            // ======================
            // 🧑 JOVEM
            // ======================
            ['name' => 'HPV', 'age_range' => 'Jovem'],
            ['name' => 'Meningocócica ACWY', 'age_range' => 'Jovem'],
            ['name' => 'Tríplice Viral (reforço)', 'age_range' => 'Jovem'],
            ['name' => 'Hepatite B (reforço)', 'age_range' => 'Jovem'],

            // ======================
            // 👨 ADULTO
            // ======================
            ['name' => 'dT (Dupla Adulto)', 'age_range' => 'Adulto'],
            ['name' => 'dTpa', 'age_range' => 'Adulto'],
            ['name' => 'Febre Amarela (reforço)', 'age_range' => 'Adulto'],
            ['name' => 'Tríplice Viral (adulto)', 'age_range' => 'Adulto'],
            ['name' => 'Hepatite B (adulto)', 'age_range' => 'Adulto'],
            ['name' => 'Influenza', 'age_range' => 'Adulto'],
            ['name' => 'Covid-19', 'age_range' => 'Adulto'],

            // ======================
            // 👴 IDOSO
            // ======================
            ['name' => 'Influenza (idoso)', 'age_range' => 'Idoso'],
            ['name' => 'Covid-19 (idoso)', 'age_range' => 'Idoso'],
            ['name' => 'Pneumocócica 23', 'age_range' => 'Idoso'],
            ['name' => 'dT (reforço)', 'age_range' => 'Idoso'],
            ['name' => 'Febre Amarela (avaliar)', 'age_range' => 'Idoso'],
        ];

        $users = User::all();

        foreach ($users as $user) {
            foreach ($vaccines as $vaccine) {
                Vaccine::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'name' => $vaccine['name'],
                    ],
                    [
                        'age_range' => $vaccine['age_range'],
                        'status' => 'A Tomar',
                        'application_date' => null,
                    ]
                );
            }
        }
    }
}
