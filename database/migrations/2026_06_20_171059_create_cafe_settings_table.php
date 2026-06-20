<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cafe_settings', function (Blueprint $table) {
            $table->id();
            $table->time('open_time')->default('08:00:00');
            $table->time('close_time')->default('22:00:00');
            $table->boolean('accept_reservation')->default(true);
            $table->time('reservation_start_time')->default('00:00:00');
            $table->time('reservation_end_time')->default('23:59:59');
            $table->integer('max_reservation_days')->default(7);
            $table->string('cafe_name')->default('Cafe Kopi Nusantara');
            $table->text('cafe_address')->nullable();
            $table->string('cafe_phone')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cafe_settings');
    }
};