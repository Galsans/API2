<?php

namespace Database\Seeders;


use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Departmet 1
        Department::create([
            'name' => 'Pemberitaan',
            'divisi_id' => 1,
        ]);
        Department::create([
            'name' => 'Sekred',
            'divisi_id' => 1,
        ]);
        Department::create([
            'name' => 'Percetakan',
            'divisi_id' => 1,
        ]);
        Department::create([
            'name' => 'Litbang',
            'divisi_id' => 1,
        ]);
        Department::create([
            'name' => 'Bahasa',
            'divisi_id' => 1,
        ]);
        Department::create([
            'name' => 'Sosial Media',
            'divisi_id' => 1,
        ]);
        Department::create([
            'name' => 'Mediaindonesia.com',
            'divisi_id' => 1,
        ]);


        // Data Department 2
        Department::create([
            'name' => 'Foto',
            'divisi_id' => 2,
        ]);
        Department::create([
            'name' => 'Artistik',
            'divisi_id' => 2,
        ]);
        Department::create([
            'name' => 'Multimedia',
            'divisi_id' => 2,
        ]);

        // Data Department 3
        Department::create([
            'name' => 'HR',
            'divisi_id' => 3,
        ]);
        Department::create([
            'name' => 'GA',
            'divisi_id' => 3,
        ]);
        Department::create([
            'name' => 'IT',
            'divisi_id' => 3,
        ]);

        // Data Department 4
        Department::create([
            'name' => 'Keuangan',
            'divisi_id' => 4,
        ]);
        Department::create([
            'name' => 'Akunting & Pajak',
            'divisi_id' => 4,
        ]);
        Department::create([
            'name' => 'Pusrchasing',
            'divisi_id' => 4,
        ]);

        // Data Department 5
        Department::create([
            'name' => 'Sales',
            'divisi_id' => 5,
        ]);
        Department::create([
            'name' => 'Akunting & Distribusi',
            'divisi_id' => 5,
        ]);
        Department::create([
            'name' => 'Promo',
            'divisi_id' => 5,
        ]);
        Department::create([
            'name' => 'Marketing Support',
            'divisi_id' => 5,
        ]);
        Department::create([
            'name' => 'Admin Support',
            'divisi_id' => 5,
        ]);
    }
}
