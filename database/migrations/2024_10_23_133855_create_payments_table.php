<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(){
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2);
            $table->string('payment_method');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('payments');
    }
};
