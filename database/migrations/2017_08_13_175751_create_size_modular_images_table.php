<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSizeModularImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('size_modular_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('modular_image_id');
            $table->integer('number');
            $table->integer('width');
            $table->integer('height');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('size_modular_images');
    }
}
