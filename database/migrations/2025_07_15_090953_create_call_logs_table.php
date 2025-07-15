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
        // database/migrations/xxxx_xx_xx_create_call_logs_table.php

        Schema::create('call_logs', function (Blueprint $table) {
            $table->id();
            $table->string('historyid')->nullable();
            $table->string('callid')->nullable();
            $table->string('duration')->nullable();
            $table->string('time_start')->nullable();
            $table->string('time_answered')->nullable();
            $table->string('time_end')->nullable();
            $table->string('reason_terminated')->nullable();
            $table->string('from_no')->nullable();
            $table->string('to_no')->nullable();
            $table->string('from_dn')->nullable();
            $table->string('to_dn')->nullable();
            $table->string('dial_no')->nullable();
            $table->string('reason_changed')->nullable();
            $table->string('final_number')->nullable();
            $table->string('final_dn')->nullable();
            $table->string('bill_code')->nullable();
            $table->string('bill_rate')->nullable();
            $table->string('bill_cost')->nullable();
            $table->string('bill_name')->nullable();
            $table->string('chain')->nullable();
            $table->string('from_type')->nullable();
            $table->string('to_type')->nullable();
            $table->string('final_type')->nullable();
            $table->string('from_dispname')->nullable();
            $table->string('to_dispname')->nullable();
            $table->string('final_dispname')->nullable();
            $table->string('missed_queue_calls')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_logs');
    }
};
