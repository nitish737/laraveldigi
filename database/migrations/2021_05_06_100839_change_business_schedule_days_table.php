<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeBusinessScheduleDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_schedule_days', function (Blueprint $table) {
            $table->dropColumn('hours');

            $table->text("start_time")->nullable();
            $table->text("end_time")->nullable();            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_schedule_days', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'end_time']);

        });
    }
}
