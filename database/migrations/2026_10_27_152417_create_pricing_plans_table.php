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
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->jsonb('name');
            $table->jsonb('tagline')->nullable();
            $table->jsonb('description')->nullable();
            $table->decimal('price', 14, 2)->nullable();
            $table->char('currency', 3)->default('IDR');
            $table->jsonb('price_suffix')->nullable();
            $table->jsonb('features')->nullable();
            $table->jsonb('cta_label')->nullable();
            $table->string('cta_url')->nullable();
            $table->boolean('is_highlighted')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};
