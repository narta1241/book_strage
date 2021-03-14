<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameBookToBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('book', 'books');
        Schema::rename('favorite_book', 'favorite_books');
        Schema::rename('series_review', 'series_reviews');
        Schema::rename('book_review', 'book_reviews');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('books', 'book');
        Schema::rename('favorites_books', 'favorite_book');
        Schema::rename('series_reviews', 'series_review');
        Schema::rename('book_reviews', 'book_review');
    }
}
