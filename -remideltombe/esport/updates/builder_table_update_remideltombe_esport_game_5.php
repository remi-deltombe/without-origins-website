<?php namespace RemiDeltombe\Esport\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateRemideltombeEsportGame5 extends Migration
{
    public function up()
    {
        Schema::table('remideltombe_esport_game', function($table)
        {
            $table->boolean('is_under_construction')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('remideltombe_esport_game', function($table)
        {
            $table->dropColumn('is_under_construction');
        });
    }
}
