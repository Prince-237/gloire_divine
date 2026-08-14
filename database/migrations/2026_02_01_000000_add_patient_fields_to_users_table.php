<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 9)->nullable()->unique()->after('email');
            $table->enum('sex', ['M', 'F'])->nullable()->after('phone');
            $table->date('date_of_birth')->nullable()->after('sex');

            // Consentement explicite requis par WhatsApp/Meta pour l'envoi de
            // notifications (actualités, alertes) — voir Phase 7/8.
            $table->boolean('whatsapp_opt_in')->default(false)->after('date_of_birth');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'sex', 'date_of_birth', 'whatsapp_opt_in']);
        });
    }
};
