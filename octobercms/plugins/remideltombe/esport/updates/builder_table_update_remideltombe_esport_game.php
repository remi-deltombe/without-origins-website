<?php namespace RemiDeltombe\Esport\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateRemideltombeEsportGame extends Migration
{
    public function up()
    {
        Schema::table('remideltombe_esport_game', function($table)
        {
            $table->integer('sort_order')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('remideltombe_esport_game', function($table)
        {
            $table->dropColumn('sort_order');
        });
    }
}
