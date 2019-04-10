<?php namespace RemiDeltombe\News\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRemideltombeNewsCategory extends Migration
{
    public function up()
    {
        Schema::create('remideltombe_news_category', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 128);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('remideltombe_news_category');
    }
}
