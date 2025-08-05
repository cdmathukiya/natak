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
        Schema::create('team_available_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_available_id')->references('id')->on('team_availables')->onDelete('cascade');
            $table->foreignId('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->string('name');
            $table->string('role');
            $table->tinyInteger('is_available')->default(0)->comment('0=>Not Available, 1 => Available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_available_members');
    }
};
