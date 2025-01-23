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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('voucherProfileId');
            $table->string('code')->unique();
            $table->text('comment')->nullable();
            $table->timestamp('importDate')->nullable();
            $table->string('status');
            $table->timestamp('saleDate')->nullable();
            $table->string('buyerName')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('voucherProfileId')->references('id')->on('voucher_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
