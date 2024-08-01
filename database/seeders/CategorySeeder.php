<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Personal Computer', 'kode' => 'PC'],
            ['name' => 'Monitor', 'kode' => 'MN'],
            ['name' => 'Laptop', 'kode' => 'LT'],
            ['name' => 'Printer', 'kode' => 'PR'],
            ['name' => 'Mouse & Keyboard', 'kode' => 'MK'],
            ['name' => 'iMac', 'kode' => 'IM'],
            ['name' => 'Macbook', 'kode' => 'MB'],
            ['name' => 'Server', 'kode' => 'SV'],
            ['name' => 'Router', 'kode' => 'RB'],
            ['name' => 'Switch/Hub', 'kode' => 'SH'],
            ['name' => 'Wifi', 'kode' => 'WF'],
            ['name' => 'Cable', 'kode' => 'NC'],
            ['name' => 'Storage', 'kode' => 'ST'],
            ['name' => 'Obeng set (Screndriver)', 'kode' => 'TS'],
            ['name' => 'Crimping tool', 'kode' => 'TS'],
            ['name' => 'Wire tracker/Lan tester', 'kode' => 'TS']
        ];

        foreach ($data as $item) {
            Category::create($item);
        }
    }
}
