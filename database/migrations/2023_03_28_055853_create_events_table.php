<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->string('name_en',200);
            $table->text('name_bn');

            $table->text('details_en')->nullable();
            $table->text('details_bn')->nullable();

            $table->text('day_en')->nullable();
            $table->text('day_bn')->nullable();

            $table->date('date_en')->nullable();
            $table->string('date_bn')->nullable();

            $table->string('slug')->nullable()->unique();
            $table->string('banner')->nullable();
            $table->unsignedBigInteger('created_by_id');

            $table->timestamps();

            $table->foreign('created_by_id','events_fk_1')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};
