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
            $table->boolean('whatsapp_opt_in')->default(true)->change();
        });

        // Bascule aussi les comptes déjà créés (ex. tes comptes de test)
        // sur "Oui" pour rester cohérent avec le nouveau défaut.
        DB::table('users')->update(['whatsapp_opt_in' => true]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('whatsapp_opt_in')->default(false)->change();
        });
    }
};
