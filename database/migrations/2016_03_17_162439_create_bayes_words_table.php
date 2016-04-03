<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBayesWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bayes_words', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('word')->index();
            $table->integer('count');
            $table->integer('bayes_category_id')
                ->references('id')->on('bayes_categories')
                ->index()
                ->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bayes_words');
    }
}
