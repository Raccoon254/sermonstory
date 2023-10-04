<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('scriptures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('story_id');
            $table->text('content');
            $table->timestamps();
            $table->foreign('story_id')->references('id')->on('stories')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scriptures');
    }
};
