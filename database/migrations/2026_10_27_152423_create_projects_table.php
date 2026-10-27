<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Translatable columns are stored as jsonb keyed by locale, and every
     * locale's slug gets its own unique expression index.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->jsonb('title');
            $table->jsonb('slug');
            $table->jsonb('excerpt')->nullable();
            $table->jsonb('body')->nullable();
            $table->jsonb('role')->nullable();
            $table->string('client_name')->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->string('project_url')->nullable();
            $table->string('repository_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('cover_image')->nullable();
            $table->jsonb('gallery')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamp('published_at')->nullable()->index();
            $table->jsonb('meta_title')->nullable();
            $table->jsonb('meta_description')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();
        });

        foreach (['id', 'en'] as $locale) {
            DB::statement("create unique index projects_slug_{$locale}_unique on projects ((slug->>'{$locale}'))");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
