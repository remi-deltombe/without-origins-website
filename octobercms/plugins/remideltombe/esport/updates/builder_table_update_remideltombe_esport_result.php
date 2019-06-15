<?php namespace RemiDeltombe\Esport\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateRemideltombeEsportResult extends Migration
{
    public function up()
    {
        Schema::table('remideltombe_esport_result', function($table)
        {
            $table->integer('our_team')->nullable()->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('remideltombe_esport_result', function($table)
        {
            $table->dropColumn('our_team');
        });
    }
}
