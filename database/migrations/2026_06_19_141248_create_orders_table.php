<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);
            $table->enum('status', ['pending', 'confirmed', 'processing', 'ready', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_method', ['cash', 'transfer', 'e_wallet'])->default('cash');
            $table->enum('payment_status', ['unpaid', 'paid', 'refunded'])->default('unpaid');
            $table->enum('order_type', ['dine_in', 'takeaway'])->default('dine_in');
            $table->string('table_number')->nullable();
            $table->text('notes')->nullable();
            $table->text('customer_name')->nullable();
            $table->text('customer_phone')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};