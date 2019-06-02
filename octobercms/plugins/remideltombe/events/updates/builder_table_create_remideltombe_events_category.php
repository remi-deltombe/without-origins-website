<?php namespace RemiDeltombe\Events\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRemideltombeEventsCategory extends Migration
{
    public function up()
    {
        Schema::create('remideltombe_events_category', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 128);
            $table->string('color', 32)->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('remideltombe_events_category');
    }
}
