<?php namespace RemiDeltombe\Esport\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateRemideltombeEsportGame4 extends Migration
{
    public function up()
    {
        Schema::table('remideltombe_esport_game', function($table)
        {
            $table->boolean('is_active')->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('remideltombe_esport_game', function($table)
        {
            $table->dropColumn('is_active');
        });
    }
}
