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
        Schema::create('voucher_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('voucherTypeId');
            $table->string('name');
            $table->string('duration');
            $table->string('status');
            $table->integer('import');
            $table->integer('stock');
            $table->integer('soldToday')->default(0);
            $table->integer('soldThisMonth')->default(0);
            $table->integer('soldTotal')->default(0);
            $table->string('remainingTime');
            $table->integer('warningStockLow')->default(0);
            $table->integer('warningStockCritical')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_profiles');
    }
};
