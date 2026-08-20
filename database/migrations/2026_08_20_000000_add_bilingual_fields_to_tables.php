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
        // Articles table
        Schema::table('articles', function (Blueprint $table) {
            $table->string('title_bn')->nullable()->after('title');
            $table->text('excerpt_bn')->nullable()->after('excerpt');
            $table->longText('content_bn')->nullable()->after('content');
        });

        // Categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name_bn')->nullable()->after('name');
        });

        // Journalist profiles table
        Schema::table('journalist_profiles', function (Blueprint $table) {
            $table->string('designation_bn')->nullable()->after('designation');
            $table->string('organization_bn')->nullable()->after('organization');
            $table->text('bio_bn')->nullable()->after('bio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['title_bn', 'excerpt_bn', 'content_bn']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['name_bn']);
        });

        Schema::table('journalist_profiles', function (Blueprint $table) {
            $table->dropColumn(['designation_bn', 'organization_bn', 'bio_bn']);
        });
    }
};
