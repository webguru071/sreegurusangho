<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('donate_accounts', function (Blueprint $table) {
            $table->id();
            $table->text('name_en');
            $table->text('name_bn');
            $table->text('account_en');
            $table->text('account_bn');
            $table->string('slug',255);
            $table->unsignedBigInteger('created_by_id');
            $table->text('image')->nullable();
            $table->timestamps();

            $table->foreign('created_by_id','donate_accounts_fk_1')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('donate_accounts');
    }
};
