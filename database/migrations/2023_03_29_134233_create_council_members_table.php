<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('council_members', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->nullable();
            $table->text('name_bn')->nullable();

            $table->string('council')->nullable();
            $table->string('branch')->nullable();
            $table->string('membership_type')->nullable();
            $table->string('member_position')->nullable();
            $table->text('member_position_bn')->nullable();

            $table->text('short_description_en')->nullable();
            $table->text('short_description_bn')->nullable();

            $table->text('description_en')->nullable();
            $table->text('description_bn')->nullable();

            $table->text('image')->nullable();
            $table->string('slug',255)->unique();
            $table->unsignedBigInteger('created_by_id');
            $table->timestamps();

            $table->foreign('created_by_id','council_members_fk_1')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('council_members');
    }
};
