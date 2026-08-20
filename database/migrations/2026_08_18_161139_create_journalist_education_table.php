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
        Schema::create('journalist_education', function (Blueprint $table) {
            $table->id();

            $table->foreignId('journalist_profile_id')
                ->constrained('journalist_profiles')
                ->cascadeOnDelete();

            $table->string('institution');

            $table->string('degree')->nullable();

            $table->string('field_of_study')->nullable();

            $table->year('start_year')->nullable();

            $table->year('end_year')->nullable();

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journalist_education');
    }
};