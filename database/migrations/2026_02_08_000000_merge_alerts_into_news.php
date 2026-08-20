<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fusion Actualités/Alertes (Phase 7) : une seule fonctionnalité.
        // Le résumé devient optionnel (repli automatique sur le début du
        // contenu) pour couvrir aussi les annonces courtes type "alerte".
        Schema::table('news_articles', function (Blueprint $table) {
            $table->string('excerpt_fr')->nullable()->change();
            $table->string('excerpt_en')->nullable()->change();
        });

        Schema::dropIfExists('alerts');
    }

    public function down(): void
    {
        Schema::table('news_articles', function (Blueprint $table) {
            $table->string('excerpt_fr')->nullable(false)->change();
            $table->string('excerpt_en')->nullable(false)->change();
        });
    }
};
