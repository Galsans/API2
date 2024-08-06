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
        Schema::create('make_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('jenis_permintaan', ['barang_baru', 'perbaikan/upgrade']);
            $table->enum('status', ['pending', 'in prosess', 'done', 'reject'])->default('pending');
            $table->foreignId('barang_id')->nullable()->references('id')->on('barangs')->onDelete('cascade');
            $table->text('description');
            $table->text('keperluan');
            $table->string('bukti')->nullable();
            $table->string('kode_pengambilan')->nullable();
            $table->date('tanggal_pengambilan')->nullable();
            $table->date('tanggal_penerimaan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('make_requests');
    }
};
