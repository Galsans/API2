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
            'department_id' => 1,
        ]);
        Department::create([
            'name' => 'Sekred',
            'department_id' => 1,
        ]);
        Department::create([
            'name' => 'Percetakan',
            'department_id' => 1,
        ]);
        Department::create([
            'name' => 'Litbang',
            'department_id' => 1,
        ]);
        Department::create([
            'name' => 'Bahasa',
            'department_id' => 1,
        ]);
        Department::create([
            'name' => 'Sosial Media',
            'department_id' => 1,
        ]);
        Department::create([
            'name' => 'Mediaindonesia.com',
            'department_id' => 1,
        ]);


        // Data Department 2
        Department::create([
            'name' => 'Foto',
            'department_id' => 2,
        ]);
        Department::create([
            'name' => 'Artistik',
            'department_id' => 2,
        ]);
        Department::create([
            'name' => 'Multimedia',
            'department_id' => 2,
        ]);

        // Data Department 3
        Department::create([
            'name' => 'HR',
            'department_id' => 3,
        ]);
        Department::create([
            'name' => 'GA',
            'department_id' => 3,
        ]);
        Department::create([
            'name' => 'IT',
            'department_id' => 3,
        ]);

        // Data Department 4
        Department::create([
            'name' => 'Keuangan',
            'department_id' => 4,
        ]);
        Department::create([
            'name' => 'Akunting & Pajak',
            'department_id' => 4,
        ]);
        Department::create([
            'name' => 'Pusrchasing',
            'department_id' => 4,
        ]);

        // Data Department 5
        Department::create([
            'name' => 'Sales',
            'department_id' => 5,
        ]);
        Department::create([
            'name' => 'Akunting & Distribusi',
            'department_id' => 5,
        ]);
        Department::create([
            'name' => 'Promo',
            'department_id' => 5,
        ]);
        Department::create([
            'name' => 'Marketing Support',
            'department_id' => 5,
        ]);
        Department::create([
            'name' => 'Admin Support',
            'department_id' => 5,
        ]);
    }
}
