<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToCustomerProductsTable extends Migration
{
    public function up()
    {
        Schema::table('customer_products', function (Blueprint $table) {
            $table->string('status')->default('pending');
        });
    }

    public function down()
    {
        Schema::table('customer_products', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
