<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cafe_settings', function (Blueprint $table) {
            $table->text('cafe_description')->nullable()->after('cafe_name');
            $table->string('cafe_email')->nullable()->after('cafe_phone');
            $table->time('weekend_open_time')->nullable()->after('close_time');
            $table->time('weekend_close_time')->nullable()->after('weekend_open_time');
        });
    }

    public function down(): void
    {
        Schema::table('cafe_settings', function (Blueprint $table) {
            $table->dropColumn(['cafe_description', 'cafe_email', 'weekend_open_time', 'weekend_close_time']);
        });
    }
};