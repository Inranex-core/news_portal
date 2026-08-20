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
        Schema::create('journalist_awards', function (Blueprint $table) {
            $table->id();

            $table->foreignId('journalist_profile_id')
                ->constrained('journalist_profiles')
                ->cascadeOnDelete();

            $table->string('title');

            $table->string('organization')->nullable();

            $table->year('award_year')->nullable();

            $table->text('description')->nullable();

            $table->string('certificate_image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journalist_awards');
    }
};