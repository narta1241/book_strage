<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeSeriesReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('series_reviews', function (Blueprint $table) {
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
        Schema::table('series_reviews', function (Blueprint $table) {
            $table->integer('series_id');
        });
    }
}
