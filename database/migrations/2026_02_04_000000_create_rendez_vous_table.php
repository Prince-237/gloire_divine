<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->date('date');
            $table->time('time')->nullable();
            $table->text('notes')->nullable();
            // Pas d'étape "en attente" — la prise de RDV est directement
            // confirmée. "annule" reste possible depuis le dashboard (Phase 5).
            $table->enum('status', ['confirme', 'annule'])->default('confirme');
            $table->timestamps();

            $table->index(['user_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rendez_vous');
    }
};
