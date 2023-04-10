<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicPagesTable extends Migration
{
    public function up()
    {
        Schema::create('dynamic_pages', function (Blueprint $table) {
            $table->id();

            $table->string('name',255)->unique();
            $table->string('slug',255)->nullable()->unique();
            $table->string('template',255)->nullable();

            $table->text('title_en')->nullable();
            $table->text('title_bn')->nullable();

            $table->text('sub_title_en')->nullable();
            $table->text('sub_title_bn')->nullable();

            $table->text('text_en')->nullable();
            $table->text('text_bn')->nullable();

            $table->text('image')->nullable();

            $table->json('section_en')->nullable();
            $table->json('section_bn')->nullable();

            $table->unsignedBigInteger('created_by_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dynamic_pages');
    }
}
