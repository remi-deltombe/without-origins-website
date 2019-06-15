<?php namespace RemiDeltombe\Faker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRemideltombeFakerGeneration extends Migration
{
    public function up()
    {
        Schema::create('remideltombe_faker_generation', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('options');
            $table->text('generated');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('remideltombe_faker_generation');
    }
}
