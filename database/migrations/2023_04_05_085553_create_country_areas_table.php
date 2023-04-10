<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryAreasTable extends Migration
{
    public function up()
    {
        Schema::create('country_areas', function (Blueprint $table) {
            $table->id();
            $table->string('name_en',200);
            $table->text('name_bn');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('created_by_id');
            $table->timestamps();

            $table->unique(["name_en","parent_id"],'country_areas_uq_1');
            $table->unique(["name_bn","parent_id"],'country_areas_uq_2');
        });
    }

    public function down()
    {
        Schema::dropIfExists('country_areas');
    }
}
