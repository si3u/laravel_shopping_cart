<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWallpaperCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallpaper_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wallpaper_id');
            $table->boolean('check_status')->default(false);
            $table->boolean('read_status')->default(false);
            $table->char('name');
            $table->char('email');
            $table->text('message');
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
        Schema::dropIfExists('wallpaper_comments');
    }
}
