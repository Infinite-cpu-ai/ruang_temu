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
        Schema::table('architect_profiles', function (Blueprint $table) {
            $table->string('profile_image')->nullable()->after('portfolio_images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('architect_profiles', function (Blueprint $table) {
            $table->dropColumn('profile_image');
        });
    }
};
