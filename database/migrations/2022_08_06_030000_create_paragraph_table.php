<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_paragraphs', function (Blueprint $table) {
            $table->integer('paragraph_id', true);
            $table->integer('chapter_id');
            $table->integer('sequence');
            $table->text('content');
            $table->integer('start_page');
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
        Schema::dropIfExists('m_paragraphs');
    }
};
