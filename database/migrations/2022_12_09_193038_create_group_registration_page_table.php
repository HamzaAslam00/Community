<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_registration_page', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('registration_page_id');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('registration_page_id')->references('id')->on('registration_pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_registration_page');
    }
};
