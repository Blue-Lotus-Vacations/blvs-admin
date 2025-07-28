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
        Schema::create('top_folders', function (Blueprint $table) {
            $table->id();
            $table->string('agent');
            $table->unsignedInteger('folder_count');
            $table->enum('trend', ['up', 'down', 'stable'])->default('stable');
            $table->unsignedInteger('global_rank')->nullable();
            $table->string('image')->nullable(); // stored in /storage/top-folders/
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_folders');
    }
};
