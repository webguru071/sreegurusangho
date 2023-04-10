<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['App','PageHeading'])->default('App');
            $table->text('field');
            $table->longText('value')->nullable();
            $table->string('slug',255)->nullable();
            $table->unsignedBigInteger('created_by_id');
            $table->timestamps();

            $table->unique('slug','settings_uq_1');
            $table->unique(["type","field"],'settings_uq_2');

            $table->foreign('created_by_id','settings_fk_1')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
