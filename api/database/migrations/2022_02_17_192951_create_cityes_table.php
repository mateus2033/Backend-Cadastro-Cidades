<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cityes', function (Blueprint $table) {
            $table->increments('id'); 
            $table->string('name',100);         
            $table->integer('iso_ddd');
            $table->integer('population');      
            $table->integer('income_per_capital');
            $table->integer('state_id')->nullable()->unsigned();
            $table->foreign('state_id')->references('id')->on('states');
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
        Schema::dropIfExists('cityes');
    }
};
