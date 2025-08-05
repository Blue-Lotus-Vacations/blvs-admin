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
        Schema::create('totalprofits', function (Blueprint $table) {
            $table->id();
            $table->string('agent');
            $table->unsignedInteger('profit')->default(0);
            $table->unsignedInteger('global_rank')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('totalprofits');
    }
};
