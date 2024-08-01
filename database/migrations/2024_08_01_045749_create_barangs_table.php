<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('brand')->nullable();
            $table->string('asset_id')->unique();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('type_monitor')->nullable();
            $table->enum('status', ['in use', 'out', 'in service', 'rusak']);
            $table->text('unit_device');
            $table->date('date_barang_masuk');
            $table->string('qrcode')->nullable();
            $table->text('note')->nullable();
            $table->text('spek_origin');
            $table->text('spek_akhir')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
