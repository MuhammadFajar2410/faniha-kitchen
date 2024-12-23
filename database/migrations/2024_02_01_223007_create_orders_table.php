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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('order_number')->unique();
            $table->integer('total_amount');
            $table->integer('quantity');
            $table->enum('payment_method', ['cod', 'midtrans'])->default('cod');
            // $table->enum('payment_status', ['paid', 'unpaid', 'cancel'])->default('unpaid');
            // $table->enum('status', ['new', 'process', 'delivered', 'cancel'])->default('new');
            $table->string('name');
            $table->string('phone');
            $table->string('address');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
