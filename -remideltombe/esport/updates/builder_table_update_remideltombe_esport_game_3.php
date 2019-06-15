<?php namespace RemiDeltombe\Esport\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateRemideltombeEsportGame3 extends Migration
{
    public function up()
    {
        Schema::table('remideltombe_esport_game', function($table)
        {
            $table->text('races')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('remideltombe_esport_game', function($table)
        {
            $table->dropColumn('races');
        });
    }
}
