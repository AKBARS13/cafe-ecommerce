<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cafe_settings', function (Blueprint $table) {
            $table->string('qris_image')->nullable()->after('cafe_email');
            $table->string('qris_merchant_name')->nullable()->after('qris_image');
            $table->text('qris_instructions')->nullable()->after('qris_merchant_name');
            $table->boolean('qris_enabled')->default(false)->after('qris_instructions');
        });
    }

    public function down(): void
    {
        Schema::table('cafe_settings', function (Blueprint $table) {
            $table->dropColumn(['qris_image', 'qris_merchant_name', 'qris_instructions', 'qris_enabled']);
        });
    }
};