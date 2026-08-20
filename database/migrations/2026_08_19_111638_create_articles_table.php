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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Journalist
            |--------------------------------------------------------------------------
            */

            $table->foreignId('journalist_profile_id')
                ->constrained('journalist_profiles')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Category
            |--------------------------------------------------------------------------
            */

            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Article Information
            |--------------------------------------------------------------------------
            */

            $table->string('title');

            $table->string('slug')->unique();

            $table->text('excerpt')->nullable();

            $table->longText('content');


            /*
            |--------------------------------------------------------------------------
            | Featured Image
            |--------------------------------------------------------------------------
            */

            $table->string('featured_image')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Article Status
            |--------------------------------------------------------------------------
            |
            | draft
            | pending
            | published
            | rejected
            |
            */

            $table->enum('status', [
                'draft',
                'pending',
                'published',
                'rejected',
            ])->default('draft');


            /*
            |--------------------------------------------------------------------------
            | Admin Rejection Reason
            |--------------------------------------------------------------------------
            */

            $table->text('rejection_reason')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Publishing
            |--------------------------------------------------------------------------
            */

            $table->timestamp('published_at')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Statistics
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('views')->default(0);


            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('status');

            $table->index('published_at');

            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};