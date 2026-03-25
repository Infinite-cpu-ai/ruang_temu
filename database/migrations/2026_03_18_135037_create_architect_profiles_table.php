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
        Schema::create('architect_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('specialization')->nullable();
            $table->json('project_types')->nullable();
            $table->decimal('price_per_m2', 12, 2)->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->string('location')->nullable();
            $table->string('style')->nullable();
            $table->json('portfolio_images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('architect_profiles');
    }
};
