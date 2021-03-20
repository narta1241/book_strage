<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeUserSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('user_series', function (Blueprint $table) {
          $table->bigInteger('series_id')->unsigned()->change();
          $table->foreign('series_id')->references('id')->on('series')->onDelete('cascade');
      });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_series', function (Blueprint $table) {
            $table->integer('series_id');
        });
    }
}
