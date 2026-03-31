<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('architect_specialization')) {
            Schema::create('architect_specialization', function (Blueprint $table) {
                $table->id();
                $table->foreignId('architect_profile_id');
                $table->foreignId('specialization_id');
                $table->timestamps();
            });
        }

        if (
            Schema::hasTable('architect_profiles')
            && ! $this->foreignKeyExists('architect_specialization', 'architect_specialization_architect_profile_id_foreign')
        ) {
            Schema::table('architect_specialization', function (Blueprint $table) {
                $table->foreign('architect_profile_id')
                    ->references('id')
                    ->on('architect_profiles')
                    ->cascadeOnDelete();
            });
        }

        if (
            Schema::hasTable('specializations')
            && ! $this->foreignKeyExists('architect_specialization', 'architect_specialization_specialization_id_foreign')
        ) {
            Schema::table('architect_specialization', function (Blueprint $table) {
                $table->foreign('specialization_id')
                    ->references('id')
                    ->on('specializations')
                    ->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('architect_specialization');
    }

    private function foreignKeyExists(string $table, string $constraint): bool
    {
        $database = DB::getDatabaseName();

        return DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('CONSTRAINT_SCHEMA', $database)
            ->where('TABLE_NAME', $table)
            ->where('CONSTRAINT_NAME', $constraint)
            ->where('CONSTRAINT_TYPE', 'FOREIGN KEY')
            ->exists();
    }
};
