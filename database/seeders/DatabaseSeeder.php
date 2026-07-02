<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);

        $makanan = \App\Models\Category::create(['name' => 'Makanan']);
        $minuman = \App\Models\Category::create(['name' => 'Minuman']);
        $cemilan = \App\Models\Category::create(['name' => 'Cemilan']);
        $paket = \App\Models\Category::create(['name' => 'Paket Liwet']);
        $coffee = \App\Models\Category::create(['name' => 'Coffee']);

        // Insert some menus for Paket Liwet
        for ($i = 1; $i <= 5; $i++) {
            \App\Models\Menu::create([
                'category_id' => $paket->id,
                'name' => 'Paket Liwet ' . $i,
                'description' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the',
                'price' => 45000,
                'stok' => 10,
                'image' => '/assets/bg_mobile.png' // using placeholder
            ]);
        }

        // Insert some other menus
        \App\Models\Menu::create([
            'category_id' => $makanan->id,
            'name' => 'Nasi Goreng Spesial',
            'description' => 'Nasi goreng dengan telur dan ayam.',
            'price' => 25000,
            'stok' => 5,
        ]);
        \App\Models\Menu::create([
            'category_id' => $makanan->id,
            'name' => 'Ayam Bakar Madu',
            'description' => 'Ayam bakar manis gurih dengan madu pilihan.',
            'price' => 30000,
            'stok' => 12,
        ]);
    }
}
