<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('password');
        });

        // Akun admin
        DB::table('users')->where('email', 'admin@gmail.com')->update(['role' => 'admin']);

        // Pengaman: kalau tidak ada admin sama sekali, akun pertama dijadikan admin
        if (!DB::table('users')->where('role', 'admin')->exists()) {
            $pertama = DB::table('users')->orderBy('id')->value('id');

            if ($pertama) {
                DB::table('users')->where('id', $pertama)->update(['role' => 'admin']);
            }
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};