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
        Schema::create('team_spots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_available_id')->constrained('team_availables')->onDelete('cascade');
            $table->string('spots_name')->default(null);
            $table->string('women')->default(null);
            $table->string('children')->default(null);
            $table->string('men')->default(null);
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_spots');
    }
};
