<?php namespace RemiDeltombe\Events\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateRemideltombeEventsEvent extends Migration
{
    public function up()
    {
        Schema::table('remideltombe_events_event', function($table)
        {
            $table->text('calendar_text');
        });
    }
    
    public function down()
    {
        Schema::table('remideltombe_events_event', function($table)
        {
            $table->dropColumn('calendar_text');
        });
    }
}
