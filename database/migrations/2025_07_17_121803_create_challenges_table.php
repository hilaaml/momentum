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
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_id'); // User yang membuat
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['time', 'task']);
            $table->integer('target_seconds')->nullable(); // untuk time-oriented
            $table->integer('target_days'); // berapa hari challenge ini berjalan
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challenges');
    }
};
