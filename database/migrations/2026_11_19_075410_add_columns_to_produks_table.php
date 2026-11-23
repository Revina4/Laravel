<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->string('nama');
            $table->unsignedBigInteger('kategori_id');
            $table->integer('harga');
            $table->integer('stok')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn(['nama', 'kategori_id', 'harga', 'stok']);
        });
    }
};