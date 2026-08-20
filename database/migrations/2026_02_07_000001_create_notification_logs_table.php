<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            // Polymorphe : rattaché soit à une Actualité, soit à une Alerte.
            $table->morphs('notifiable');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('channel')->default('whatsapp');
            // "en_attente" tant que la Phase 8 (API WhatsApp) n'est pas branchée.
            $table->enum('status', ['en_attente', 'envoye', 'echec'])->default('en_attente');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_logs');
    }
};
