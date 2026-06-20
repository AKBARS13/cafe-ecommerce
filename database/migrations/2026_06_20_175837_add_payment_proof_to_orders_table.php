<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_proof')->nullable()->after('paid_at');
            $table->foreignId('bank_account_id')->nullable()->after('payment_proof')->constrained()->nullOnDelete();
            $table->timestamp('payment_verified_at')->nullable()->after('bank_account_id');
            $table->text('payment_rejection_reason')->nullable()->after('payment_verified_at');
        });

        // Update enum payment_status
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_status');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_status', ['unpaid', 'pending_verification', 'paid', 'rejected', 'refunded'])
                ->default('unpaid')
                ->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['bank_account_id']);
            $table->dropColumn(['payment_proof', 'bank_account_id', 'payment_verified_at', 'payment_rejection_reason']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_status');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_status', ['unpaid', 'paid', 'refunded'])->default('unpaid');
        });
    }
};