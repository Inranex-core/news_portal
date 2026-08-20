<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journalist_expertise', function (Blueprint $table) {
            $table->id();

            $table->foreignId('journalist_profile_id')
                ->constrained('journalist_profiles')
                ->cascadeOnDelete();

            $table->foreignId('expertise_id')
                ->constrained('expertises')
                ->cascadeOnDelete();

            $table->unique([
                'journalist_profile_id',
                'expertise_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journalist_expertise');
    }
};