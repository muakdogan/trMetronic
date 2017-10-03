<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeklifHareketlerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('teklif_hareketler', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('teklif_id')->unsigned();
            $table->foreign('teklif_id')->references('id')->on('teklifler')->onDelete('cascade');
            $table->string('kdv_dahil_fiyat');
            $table->string('kdv_haric_fiyat');
            $table->string('kdv_orani');
            $table->integer('para_birimleri_id')->unsigned();
            $table->foreign('para_birimleri_id')->references('id')->on('para_birimleri')->onDelete('cascade');
            $table->date('tarih');
            $table->integer('kullanici_id')->unsigned();
            $table->foreign('kullanici_id')->references('id')->on('kullanicilar')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('teklif_hareketler');
    }
}
