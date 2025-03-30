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
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('total_price', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->decimal('total_discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2);
            $table->decimal('total_tax', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2);
            $table->decimal('grand_total', 10, 2);
            $table->string('currency')->default('USD');
            $table->string('payment_method');
            $table->string('status')->default('pending');
            $table->string('success_url')->nullable();
            $table->string('cancel_url')->nullable();
            $table->string('failure_url')->nullable();
            $table->json('extras')->nullable();
            $table->timestamps();
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
