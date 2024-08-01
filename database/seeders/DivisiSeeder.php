<?php

namespace Database\Seeders;

use App\Models\Divisi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Divisi::create([
            'name' => 'Pemberitaan',
            'kode' => 'RED',
        ]);
        Divisi::create([
            'name' => 'Artistik & Multimedia',
            'kode' => 'ARM',
        ]);
        Divisi::create([
            'name' => 'HR-GA & IT',
            'kode' => 'HGI',
        ]);
        Divisi::create([
            'name' => 'Keuangan',
            'kode' => 'KAP',
        ]);
        Divisi::create([
            'name' => 'Sales & Marketing',
            'kode' => 'SNM',
        ]);
    }
}
