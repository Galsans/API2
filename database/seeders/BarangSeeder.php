<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Barang::create([
            "brand" => "asus",
            "asset_id" => "REDMN0010820",
            "user_id" => 1,
            "category_id" => 2,
            "type_monitor" => "acer",
            "status" => "in use",
            "unit_device" => "monitor",
            "date_barang_masuk" => "2020-08-12",
            "qrcode" => "/storage/qrcodes/barcode1.svg",
            "note" => "lorem ipsum dolor sit amet",
            "spek_origin" => "loreknsdu",
            "spek_akhir" => "bagus",
        ]);
        Barang::create([
            "brand" => "asus",
            "asset_id" => "ARMPR0020820",
            "user_id" => 2,
            "category_id" => 4,
            "type_monitor" => "acer",
            "status" => "in use",
            "unit_device" => "monitor",
            "date_barang_masuk" => "2020-08-12",
            "qrcode" => "/storage/qrcodes/barcode2.svg",
            "note" => "lorem ipsum dolor sit amet",
            "spek_origin" => "loreknsdu",
            "spek_akhir" => "bagus",
        ]);

        Barang::create([
            "brand" => "asus",
            "asset_id" => "KAPMK0030820",
            "user_id" => 3,
            "category_id" => 5,
            "type_monitor" => "acer",
            "status" => "in use",
            "unit_device" => "monitor",
            "date_barang_masuk" => "2020-08-12",
            "qrcode" => "/storage/qrcodes/barcode3.svg",
            "note" => "lorem ipsum dolor sit amet",
            "spek_origin" => "loreknsdu",
            "spek_akhir" => "bagus",
        ]);

        Barang::create([
            "brand" => "asus",
            "asset_id" => "HGIIM0070820",
            "user_id" => 4,
            "category_id" => 6,
            "type_monitor" => "acer",
            "status" => "in use",
            "unit_device" => "monitor",
            "date_barang_masuk" => "2020-08-12",
            "qrcode" => "/storage/qrcodes/barcode4.svg",
            "note" => "lorem ipsum dolor sit amet",
            "spek_origin" => "loreknsdu",
            "spek_akhir" => "bagus",
        ]);
        Barang::create([
            "brand" => "asus",
            "asset_id" => "SNMSV0080920",
            "user_id" => 5,
            "category_id" => 8,
            "type_monitor" => "acer",
            "status" => "in use",
            "unit_device" => "monitor",
            "date_barang_masuk" => "2020-09-12",
            "qrcode" => "/storage/qrcodes/barcode5.svg",
            "note" => "lorem ipsum dolor sit amet",
            "spek_origin" => "loreknsdu",
            "spek_akhir" => "bagus",
        ]);
    }
}
