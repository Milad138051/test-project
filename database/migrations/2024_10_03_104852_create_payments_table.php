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
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('expense_id')->constrained('expenses')->onDelete('cascade');
                $table->decimal('amount', 15, 2);
                $table->string('sheba_number');
                $table->string('bank_code');
                $table->string('status')->default('pending'); // pending, success, failed
                $table->tinyInteger('is_scheduled')->default(0)->comment('0=>is_not_schedule,1=>is_scheduledd');
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
