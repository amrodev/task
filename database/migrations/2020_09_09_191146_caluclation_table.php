<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CaluclationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculations', function (Blueprint $table) {
            $table->id();
            $table->integer('argument1');
            $table->integer('argument2');
            $table->float('average', 15, 2);
            $table->float('area', 15, 2);
            $table->float('squared_area', 15, 2);          
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
        Schema::dropIfExists('users');
    }
}
