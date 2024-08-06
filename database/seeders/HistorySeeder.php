<?php

namespace Database\Seeders;

use App\Models\History;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        History::create([
            "barang_id" => 1,
            "user_id" => 1,
            "status" => "in use",
            "spek_upgraded" => null,
            "lokasi" => "di rumah pak admin",
        ]);
        History::create([
            "barang_id" => 2,
            "user_id" => 2,
            "status" => "in use",
            "spek_upgraded" => null,
            "lokasi" => "di rumah pak user",
        ]);
        History::create([
            "barang_id" => 3,
            "user_id" => 3,
            "status" => "in use",
            "spek_upgraded" => null,
            "lokasi" => "di kantor",
        ]);
    }
}
