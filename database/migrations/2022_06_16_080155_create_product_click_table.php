<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductClickTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_click', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('aladin_mall')->nullable();
            $table->string('tokopedia')->nullable();
            $table->string('shopee')->nullable();
            $table->string('lazada')->nullable();
            $table->string('blibli')->nullable();
            $table->string('bukalapak')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_click');
    }
}
