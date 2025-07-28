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
        Schema::create('top_rankers', function (Blueprint $table) {
            $table->id();
            $table->string('agent');
            $table->unsignedInteger('folder_count')->default(0);
            $table->unsignedInteger('profit')->default(0);
            $table->enum('trend', ['up', 'down', 'stable'])->default('stable');
            $table->unsignedInteger('global_rank')->nullable();
            $table->string('image')->nullable(); // /storage/top-rankers/...
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_rankers');
    }
};
