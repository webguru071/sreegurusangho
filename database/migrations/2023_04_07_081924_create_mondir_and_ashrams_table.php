<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMondirAndAshramsTable extends Migration
{
    public function up()
    {
        Schema::create('mondir_and_ashrams', function (Blueprint $table) {
            $table->id();
            $table->string('name_en',255);
            $table->text('name_bn');
            $table->string('branch')->nullable();
            $table->text('image')->nullable();
            $table->text('text_en')->nullable();
            $table->text('text_bn')->nullable();
            $table->unsignedBigInteger('created_by_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mondir_and_ashrams');
    }
}
