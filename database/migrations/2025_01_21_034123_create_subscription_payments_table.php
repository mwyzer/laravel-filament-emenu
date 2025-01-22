<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('subscription_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_id');
            $table->string('proof'); // Storing file paths for images
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscription_payments');
    }
}
