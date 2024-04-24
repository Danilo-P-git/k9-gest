<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            "Affitto",
            "Utenze",
            "Cibo per animali",
            "Varie",
            "Veterinario"
        ];
        foreach ($names as $name) {
            Category::create([
                'name' => $name
            ]);
        }
    }
}
