<?php namespace RemiDeltombe\Page\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRemideltombePagePage extends Migration
{
    public function up()
    {
        Schema::create('remideltombe_page_page', function($table)
        {
            $table->engine = 'InnoDB';
            
            $table->increments('id');

            $table->string('name', 256);
            $table->string('url', 256);
            $table->boolean('is_active')->default(1);

            $table->string('image', 256);
            $table->text('content')->nullable();

            $table->text('social_title')->nullable();
            $table->text('social_description')->nullable();
            $table->string('social_image', 256)->nullable();

            $table->text('seo_title')->nullable();
            $table->text('seo_description')->nullable();

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('remideltombe_page_page');
    }
}
