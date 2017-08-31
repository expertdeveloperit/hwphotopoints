<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriePostsViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series_post_views', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('series_list_id')->unsigned();
            $table->foreign('series_list_id')->references('id')->on('series_posts');
            $table->string('image_view');
            $table->string('value');
            $table->string('pan_view');
            $table->longText('description');
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
        Schema::dropIfExists('series_post_views');
    }
}
