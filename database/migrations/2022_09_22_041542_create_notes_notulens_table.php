<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesNotulensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes_notulens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notulen_id');
            $table->foreignId('user_id');
            $table->date('tanggal_catatan');
            $table->text('isi_catatan');
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
        Schema::dropIfExists('notes_notulens');
    }
}
