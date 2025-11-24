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
        Schema::create('journalings', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->string('week');
            $table->timestamps();

            $table->unique(['year', 'week']); // prevent duplicate week per year
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journalings');
    }
};
