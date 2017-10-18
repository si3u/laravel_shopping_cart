<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prints', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tel');
            $table->integer('width');
            $table->integer('height');
            $table->integer('canvas');
            $table->boolean('read_status')->default(0);
            $table->boolean('processing_status')->default(0);
            $table->text('file', 500);
            $table->text('file_ext', 6);
            $table->string('local', 2);
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
        Schema::dropIfExists('prints');
    }
}
