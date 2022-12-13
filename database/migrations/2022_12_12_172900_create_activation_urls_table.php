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
        Schema::create('activation_urls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registration_page_id');
            $table->unsignedBigInteger('user_id');
            $table->string('url');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreign('registration_page_id')->references('id')->on('registration_pages')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activation_urls');
    }
};
