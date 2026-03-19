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
        Schema::create('projects', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        $table->foreignId('architect_id')->constrained('users')->cascadeOnDelete();
        $table->string('property_type'); // e.g., Hunian, Restaurant
        $table->integer('area_size'); // in m2
        $table->decimal('total_price', 15, 2);
        $table->enum('status', ['pending', 'paid', 'on_progress', 'completed'])->default('pending');
        $table->string('snap_token')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
