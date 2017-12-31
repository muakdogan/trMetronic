<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puanlama extends Model
{
    //
    protected $table = 'puanlamalar';
    
    public $timestamps = false;
    
    public function firmalar()
    {
        return $this->belongsTo('App\Firma', 'firma_id', 'id');
    }
    public function ilanlar()
    {
        return $this->belongsTo('App\Ilan', 'ilan_id', 'id');
    }
    public function kullanicilar()
    {
        return $this->belongsTo('App\Kullanici', 'yorum_yapan_kullanici_id', 'id');
    }
    public function yorum()
    {
        return $this->hasOne('App\Yorum', 'ilan_id', 'ilan_id');
    }

    public function puanGetir($yorum_yapilan_firma_id,$ilan_id){
        return Puanlama::where('firma_id',$yorum_yapilan_firma_id)->where('ilan_id',$ilan_id)->where('yorum_yapan_firma_id',session()->get('firma_id'))->where('yorum_yapan_kullanici_id',session()->get('kullanici_id'))->first();
    }
  
}
