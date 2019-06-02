<?php namespace RemiDeltombe\Album\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRemideltombeAlbumAlbum extends Migration
{
    public function up()
    {
        Schema::create('remideltombe_album_album', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 64);
            $table->boolean('is_active');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('remideltombe_album_album');
    }
}
