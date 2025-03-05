<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProductsTable extends Migration
{
    public function up()
    {
        Schema::create('customer_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->text('address');
            $table->foreignId('country_id')->constrained('countries');  
            $table->foreignId('state_id')->constrained('states');  
            $table->foreignId('city_id')->constrained('cities');  
            $table->string('status')->default('pending'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_products');
    }
}
