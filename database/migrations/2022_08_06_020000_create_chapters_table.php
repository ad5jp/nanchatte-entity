<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_chapters', function (Blueprint $table) {
            $table->integer('chapter_id', true);
            $table->integer('book_id');
            $table->string('chapter_title');
            $table->integer('sequence');
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
        Schema::dropIfExists('m_chapters');
    }
}
