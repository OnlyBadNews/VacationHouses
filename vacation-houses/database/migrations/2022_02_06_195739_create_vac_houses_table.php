<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vac_houses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city')->default('');
            $table->integer('rooms')->nullable();
            $table->integer('beds')->nullable();


            $table->timestamps();
            //TODO: list of objects
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vac_houses');
    }
}
