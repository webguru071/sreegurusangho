<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteMenusTable extends Migration
{
    public function up()
    {
        Schema::create('site_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name_en',255);
            $table->text('name_bn');
            $table->unsignedBigInteger('page_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('created_by_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('site_menus');
    }
}
