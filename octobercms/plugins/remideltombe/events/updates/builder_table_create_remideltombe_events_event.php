<?php namespace RemiDeltombe\Events\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRemideltombeEventsEvent extends Migration
{
    public function up()
    {
        Schema::create('remideltombe_events_event', function($table)
        {
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->integer('category_id')->nullable();
            $table->integer('game_id')->nullable();
            $table->dateTime('date')->nullable();

            $table->text('title');
            $table->string('slug', 256);
            $table->boolean('is_active')->default(1);

            $table->string('thumb', 256)->nullable();
            $table->text('description')->nullable();

            $table->string('image', 256)->nullable();
            $table->text('content')->nullable();

            $table->string('publication_author', 256)->nullable();

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
        Schema::dropIfExists('remideltombe_events_event');
    }
}
