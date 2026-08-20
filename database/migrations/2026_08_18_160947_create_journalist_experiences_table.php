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
        Schema::create('journalist_experiences', function (Blueprint $table) {
            $table->id();

            $table->foreignId('journalist_profile_id')
                ->constrained('journalist_profiles')
                ->cascadeOnDelete();

            $table->string('organization');

            $table->string('designation');

            $table->date('start_date')->nullable();

            $table->date('end_date')->nullable();

            $table->boolean('is_current')->default(false);

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journalist_experiences');
    }
};