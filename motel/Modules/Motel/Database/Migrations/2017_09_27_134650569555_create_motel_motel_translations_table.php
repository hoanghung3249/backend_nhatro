<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotelMotelTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motel__motel_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('motel_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['motel_id', 'locale']);
            $table->foreign('motel_id')->references('id')->on('motel__motels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('motel__motel_translations', function (Blueprint $table) {
            $table->dropForeign(['motel_id']);
        });
        Schema::dropIfExists('motel__motel_translations');
    }
}
