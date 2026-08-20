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
        Schema::create('journalist_profiles', function (Blueprint $table) {
            $table->id();

            // One user can have only one journalist profile
            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            // Public profile URL
            $table->string('slug')->unique();

            // Professional information
            $table->string('designation')->nullable();
            $table->string('organization')->nullable();
            $table->string('headline')->nullable();

            // About journalist
            $table->text('bio')->nullable();

            // Images
            $table->string('profile_image')->nullable();
            $table->string('cover_image')->nullable();

            // Contact information
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();

            // Experience
            $table->unsignedInteger('experience_years')->default(0);

            // Verification & account status
            $table->boolean('is_verified')->default(false);
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journalist_profiles');
    }
};