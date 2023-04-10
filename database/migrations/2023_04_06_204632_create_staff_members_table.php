<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffMembersTable extends Migration
{
    public function up()
    {
        Schema::create('staff_members', function (Blueprint $table) {
            $table->id();
            $table->string('name_en',255);
            $table->text('name_bn');
            $table->string('type');
            $table->text('image')->nullable();
            $table->text('short_text_en')->nullable();
            $table->text('short_text_bn')->nullable();
            $table->text('text_en')->nullable();
            $table->text('text_bn')->nullable();
            $table->unsignedBigInteger('created_by_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('staff_members');
    }
}
