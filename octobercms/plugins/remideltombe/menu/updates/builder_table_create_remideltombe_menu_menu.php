<?php namespace remideltombe\Menu\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRemideltombeMenuMenu extends Migration
{
    public function up()
    {
        Schema::create('remideltombe_menu_menu', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 256);
            $table->text('items');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('remideltombe_menu_menu');
    }
}
