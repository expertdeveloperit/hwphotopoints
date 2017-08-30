<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_information', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('file_name');
            $table->string('file_location_aws');
            $table->string('file_thumb_location_aws');
            $table->string('uploaded_by');
            $table->string('uploading_date');
            $table->string('year');
            $table->string('season');
            $table->string('series');
            $table->string('image_view');
            $table->string('views');
            $table->string('post_name');
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
        Schema::dropIfExists('media_information');
    }
}
