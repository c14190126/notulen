<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotulensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notulens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('perusahaan_id');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('judul_meeting');
            $table->text('isi_notulen');
            $table->text('catatan_klien')->nullable();
            // $table->integer('jumlah_revisi')->default(0);
            // $table->date('tanggal_revisi')->nullable();
            $table->foreignId('edited_by')->nullable();
            $table->boolean('private')->default(false);
            $table->text('tanda_tangan')->nullable();
            $table->text('tanda_tangan_deus');
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
        Schema::dropIfExists('notulens');
    }
}
