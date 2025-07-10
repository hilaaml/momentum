<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Character;
use Illuminate\Support\Facades\Storage;

class CharacterSeeder extends Seeder
{
    public function run(): void
    {
        $characters = [
            [
                'name' => 'Banana Cat',
                'image' => 'banana_cat.png',
                'required_seconds' => 3600, // 1 jam
            ],
            [
                'name' => 'Erm Cat',
                'image' => 'erm_cat.png',
                'required_seconds' => 10800, // 3 jam
            ],
            [
                'name' => 'Scared Hamster',
                'image' => 'scared_hamster.png',
                'required_seconds' => 21600, // 6 jam
            ],
            [
                'name' => 'Stress Cat',
                'image' => 'stress_cat.png',
                'required_seconds' => 43200, // 12 jam
            ],
            [
                'name' => 'Tung Hamster',
                'image' => 'tung_hamster.png',
                'required_seconds' => 43200, // 12 jam
            ],
        ];

        foreach ($characters as $data) {
            Character::create([
                'name' => $data['name'],
                'image_path' => 'characters/' . $data['image'],
                'required_seconds' => $data['required_seconds'],
            ]);
        }
    }
}
