<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicPageSectionsTable extends Migration
{
    public function up()
    {
        Schema::create('dynamic_page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('name_en',255);
            $table->text('name_bn');
            $table->enum('type', ['Text', 'Module']);
            $table->string('module',255)->nullable();
            $table->text('text_en')->nullable();
            $table->text('text_bn')->nullable();
            $table->text('image')->nullable();
            $table->unsignedBigInteger('dynamic_page_id');
            $table->unsignedBigInteger('created_by_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dynamic_page_sections');
    }
}
