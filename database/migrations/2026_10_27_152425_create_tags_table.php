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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->jsonb('name');
            $table->jsonb('slug');
            $table->timestamps();
        });

        foreach (['id', 'en'] as $locale) {
            DB::statement("create unique index tags_slug_{$locale}_unique on tags ((slug->>'{$locale}'))");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
