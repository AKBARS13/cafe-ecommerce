<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Ubah enum order_type untuk tambah 'reservation'
            $table->dropColumn('order_type');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('order_type', ['dine_in', 'takeaway', 'reservation'])->default('dine_in')->after('payment_status');
            $table->date('reservation_date')->nullable()->after('table_number');
            $table->time('reservation_time')->nullable()->after('reservation_date');
            $table->integer('guest_count')->default(1)->after('reservation_time');
            $table->foreignId('table_id')->nullable()->after('guest_count')->constrained('tables')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['table_id']);
            $table->dropColumn(['reservation_date', 'reservation_time', 'guest_count', 'table_id']);
            $table->dropColumn('order_type');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('order_type', ['dine_in', 'takeaway'])->default('dine_in');
        });
    }
};