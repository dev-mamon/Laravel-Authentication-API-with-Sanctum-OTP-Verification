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
        Schema::create('user_finances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('finance_id')->constrained('finances')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_submitted')->default(false);
            $table->float('allowance')->default(0);
            $table->float('expenses')->default(0);
            $table->float('save_amount')->default(0);
            $table->text('content')->nullable();
            $table->timestamps();
            $table->unique(['finance_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_finances');
    }
};
