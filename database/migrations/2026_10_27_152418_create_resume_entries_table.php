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
        Schema::create('resume_entries', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->jsonb('title');
            $table->string('organization');
            $table->string('location')->nullable();
            $table->jsonb('description')->nullable();
            $table->string('url')->nullable();
            $table->string('logo')->nullable();
            $table->date('started_on');
            $table->date('ended_on')->nullable();
            $table->string('date_precision')->default('year');
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['type', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_entries');
    }
};
