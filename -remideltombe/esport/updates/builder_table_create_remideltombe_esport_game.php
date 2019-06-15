<?php namespace RemiDeltombe\Esport\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRemideltombeEsportGame extends Migration
{
    public function up()
    {
        Schema::create('remideltombe_esport_game', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('menu_id')->nullable();
            $table->string('name', 256);
            $table->string('slug', 256);
            $table->string('logo', 256)->nullable();
            $table->string('background', 256)->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('remideltombe_esport_game');
    }
}
