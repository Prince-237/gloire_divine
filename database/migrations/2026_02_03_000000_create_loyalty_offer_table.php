<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loyalty_offer', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('discount_percent')->default(15);
            $table->unsignedInteger('min_amount')->default(5000);
            $table->string('title_fr')->default('La Carte de Fidélité "La Gloire Divine"');
            $table->string('title_en')->default('"La Gloire Divine" Loyalty Card');
            $table->text('description_fr')->nullable();
            $table->text('description_en')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loyalty_offer');
    }
};
