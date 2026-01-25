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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('child_id')->constrained()->cascadeOnDelete();

            $table->timestamp('entry_time');
            $table->timestamp('exit_time')->nullable();

            $table->enum('time_plan', ['30', '60']);
            $table->integer('extra_time_minutes')->nullable();

            $table->decimal('base_amount', 8, 2);
            $table->decimal('discount_amount', 8, 2)->nullable();
            $table->decimal('final_amount', 8, 2);

            $table->enum('payment_method', ['credit', 'debit', 'pix', 'cash']);

            $table->enum('status', [
                'in_progress',
                'completed',
                'canceled',
                'waiting_payment'
            ]);

            $table->boolean('has_bonus')->default(false);
            $table->string('bonus_note')->nullable();

            $table->foreignId('created_by_user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
