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
        Schema::create('v_game', function (Blueprint $table) {
            $table->id();
            $table->string('Title');
            $table->string('Genre');
            $table->string('Developer');
            $table->string('Publisher');
            $table->year('Release year');
            $table->string('Region Code');
            $table->string('Platform');
            $table->string('Cover Art');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_game');
    }
};
