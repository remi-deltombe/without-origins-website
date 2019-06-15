<?php namespace RemiDeltombe\Esport\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRemideltombeEsportResult extends Migration
{
    public function up()
    {
        Schema::create('remideltombe_esport_result', function($table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('game_id')->nullable();

            $table->text('title');
            $table->string('slug', 256);
            $table->boolean('is_active')->default(1);

            $table->string('team_a_name', 256)->nullable();
            $table->string('team_a_color', 32)->nullable();
            $table->string('team_a_logo', 256)->nullable();

            $table->string('team_b_name', 256)->nullable();
            $table->string('team_b_color', 32)->nullable();
            $table->string('team_b_logo', 256)->nullable();

            $table->text('matches')->nullable();

            $table->string('thumb', 256)->nullable();
            $table->text('description')->nullable();

            $table->string('image', 256)->nullable();
            $table->text('content')->nullable();

            $table->string('publication_author', 256)->nullable();
            $table->dateTime('publication_date')->nullable();

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
        Schema::dropIfExists('remideltombe_esport_result');
    }
}
