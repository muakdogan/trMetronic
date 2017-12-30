<?php
use App\Form;
use App\iller;
use App\Il;
use App\ilceler;
use App\semtler;
use App\adresler;
use App\adres_turleri;
use App\Sektor;
use App\Firma;
use App\FirmaReferans;
use App\iletisim_bilgileri;
use App\FirmaSatilanMarka;
use App\TicariBilgi;
use App\TicaretOdasi;
use App\Adres;
use App\Ilce;
use App\Semt;
use App\Ilan;
use App\Teklif;
use App\MaliBilgi;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Mail\Mailer;
use Barryvdh\Debugbar\Facade as Debugbar;

Route::get('/sessionKill', function () {
  Auth::logout();
  Session::flush();
  return Redirect::to('/');
});

Route::get('/DbTest', function () {
  if( DB::connection()->getDatabaseName() ){
    echo 'Connected Database : ',DB::connection()->getDatabaseName();
  }
});

Route::group(['middleware' => ['web']], function () {
  //Login Routes...

  //public/admin/login
  //public in altındaki klasörün içine yönlendiriyor
  Route::get('/admin/login','AdminAuth\AuthController@showLoginForm');

  Route::post('/admin/login','AdminAuth\AuthController@login');
  //Route::get('/admin/logout','AdminAuth\AuthController@logout');
  Route::get('/admin/logout','AdminAuth\AuthController@logout');
  // Registration Routes...
  Route::get('admin/register', 'AdminAuth\AuthController@showRegistrationForm');
  Route::post('admin/register', 'AdminAuth\AuthController@register');

  Route::post('admin/password/email','AdminAuth\PasswordController@sendResetLinkEmail');
  Route::post('admin/password/reset','AdminAuth\PasswordController@reset');
  Route::get('admin/password/reset/{token?}','AdminAuth\PasswordController@showResetForm');

  Route::get('/admin/dashboard', 'AdminController@index');
  Route::post('/admin/firmaOnay', 'AdminController@firmaOnay')->name('firmaOnaySubmit');//form submit butonu isimli rota istedi


});

Route::get('/userrr', function () {
    return view('layouts.appUser');
});
Route::get('/password/reset/{belirleme}/{token?}','Auth\PasswordController@showResetForm');

Route::get('/admin/kalemlerTablolari',['middleware' => 'admin' , function () {
  return view('admin.kalemlerTablolari');
}]);

//Route::resource('kullaniciLog', 'ActivityController');
/*Route::get('/kullaniciLog', function () {

$latestActivities = Activity::with('user')->latest()->limit(100)->get();
return view('admin.kullaniciLog', array('latestActivities' => $latestActivities));
});*/
Route::post('/updateTree', function () {
  $id = Input::get('id');
  $value = Input::get('value');
  $type = Input::get('type');
  $kalem = App\Kalem::find($id);

  if( $type == "checkbox"){
    $kalem->is_aktif = $value;
  }
  else if($type == "updateName"){
    $kalem->adi = $value;
  }
  else if($type == "updateNaceKodu"){
    $kalem->nace_kodu = $value;
  }

  $kalem->save();
});

Route::get('/findChildrenTree/{sektor_id}', function ($sektor_id) {
  $id = Input::get('id');
  $kalemler = DB::select( DB::raw("SELECT adi as 'title',id as 'key',
    (SELECT (CASE WHEN COUNT(*) > 0 THEN 'true' END) from kalemler as k2 where k1.id= k2.parent_id)  as folder,
    (SELECT (CASE WHEN COUNT(*) > 0 THEN 'true' END) from kalemler as k3 where k1.id= k3.parent_id)  as lazy, is_aktif
    FROM kalemler as k1
    where k1.parent_id = '$id' AND sektor_id= '$sektor_id'"  ));

    return Response::json($kalemler);

  });

  Route::get('/getSektorler', function (Request $request) {

              $mal_turu= Input::get('mal_turu');
              if($mal_turu!=3){
                $sektorler = \App\Sektor::where('kalem_turu', '=', $mal_turu)->orWhere('kalem_turu','=',4)->get();
                DebugBar::info("if");
              }
              else{

                $sektorler = \App\Sektor::where('kalem_turu', '=', $mal_turu)->get();
                DebugBar::info("else");
              }
              DebugBar::info($sektorler);
              return Response::json($sektorler);

   });

  Route::get('/admin/tablesControl',['middleware' => 'admin' , function () {
    return view('admin.genproduction.projects');
  }]);//admin.index

  Route::get('/admin/api/v1/admins/{id?}', 'Admins@index');
  Route::post('/admin/api/v1/admins', 'Admins@store');
  Route::post('/admin/api/v1/admins/{id}', 'Admins@update');
  Route::delete('/admin/api/v1/admins/{id}', 'Admins@destroy');

  /*Route::get('/adminAnasayfa', function () {
  $firmalar=Firma::all();
  return view('admin.dashboard')->with('firmalar',$firmalar);
});*/

Route::get('/', function() {
  return view('FrontEnd.index');
});

/*Route::get('/', function () {
  return view('Anasayfa.temelAnasayfa');
});*/

Route::get('/admin/firmaList', 'AdminController@firmaList');

Route::get('/firmaListeOnaylı',function (){

  $onayli = DB::table('firmalar')
  ->where('onay', 1)->orderBy('olusturmaTarihi', 'desc') ->paginate(2, ['*'], '2pagination');

  return Response::json(View::make('admin.firmaListOnayli',array('onayli'=> $onayli))->render());
});

Route::get('/admin/yorumList', 'AdminController@yorumList');

Route::POST('/firmaDavet', function () {

  $davetEdilenFirma = Input::get('isim');

  $mail_adres = Input::get('mailAdres');
  $kontrol = App\Kullanici::where('email',$mail_adres);
  $firma_id = Input::get('firma_id');
  $firma = Firma::find($firma_id);

  if(count($kontrol) == 0){
    $data = ['firma_adi' => $davetEdilenFirma, 'davet_eden_firma' => $firma->adi];
    Mail::send('auth.emails.firmaDavet', $data, function($message) use($data,$mail_adres)
    {
      $message->to($mail_adres, $data['davet_eden_firma'])
      ->subject('FİRMANIZ DAVET EDİLDİ!');

    });
    $mesaj = "Başarıyla Davet Edildi";
  }
  else{
    $mesaj =  "Bu Firma Sistemimizde Kayıtlıdır.";
  }
  return Response::json($mesaj);
});

Route::get('/admin/yorumOnay/{id}/{yorum_kul_id}', 'AdminController@yorumOnay');

Route::get('/kullaniciIslemleri', 'KullaniciController@kullaniciIslemleri');
Route::get('/kullaniciBilgileri', 'KullaniciController@kullaniciBilgileri');
Route::post('/kullaniciBilgileriUpdate','KullaniciController@kullaniciBilgileriUpdate');

Route::post('/kullaniciSifreDegisikligi', 'KullaniciController@kullaniciSifreDegisikligi');
Route::post('/kullaniciIslemleriEkle/{id}', 'KullaniciController@kullaniciIslemleriEkle');
Route::delete('/kullaniciDelete','KullaniciController@kullaniciSil');

Route::post('/kullaniciIslemleriGuncelle', 'KullaniciController@kullaniciIslemleriGuncelle');

Route::get('/kullanici/{kullanici_id?}',function($kullanici_id){
  $kullanici = DB::table('kullanicilar')
  ->join('firma_kullanicilar', 'kullanicilar.id', '=', 'firma_kullanicilar.kullanici_id')
  ->select('kullanicilar.*', 'firma_kullanicilar.rol_id', 'firma_kullanicilar.unvan')
  ->where('kullanicilar.id', $kullanici_id)->first();
  return Response::json($kullanici);
});

Route::get('/firmalist', ['middleware'=>'auth' ,function () {
  $firmalar = Firma::paginate(2);
  return view('Firma.firmalar')->with('firmalar', $firmalar);
}]);

Route::get('/firmaDetay/{firma_id}', 'FirmaController@firmaDetay');
Route::get('/davetEdildigim', 'IlanController@davetEdildigimIlanlar');
Route::get('/yardim', 'FirmaController@yardim');
Route::get('/image/{id}', ['middleware'=>'auth',function ($id) {
  $firmas = Firma::find($id);
  return view('firmas.upload')->with('firmas', $firmas);
}]);

// 'FirmaController@firmaKayitFormValidator',
Route::get('/firmaKayit', function () {
  $iller = App\Il::all();
  $iller_query= DB::select(DB::raw("SELECT *
                                FROM  `iller`
                                WHERE adi = 'İstanbul'
                                OR adi =  'İzmir'
                                OR adi =  'Ankara'
                                UNION
                                SELECT *
                                FROM iller"));
   $sektorler=DB::table('sektorler')->orderBy('adi','ASC')->get();


  return view('FrontEnd.FirmaKayit')->with('iller', $iller)->with('sektorler',$sektorler)->with('iller_query',$iller_query);
  //return view('Firma.genFirmaKayit')->with('iller', $iller)->with('sektorler',$sektorler)->with('iller_query',$iller_query);
  // Önceki Hali "Firma.firmaKayit" Güncel Hali "Firma.genFirmaKayit"
});

Route::get('/yeniFirmaKaydet' ,function () {
  $kullanici_id=  App\Kullanici::find(session()->get('kullanici_id'));
  $iller = App\Il::all();
  $sektorler= App\Sektor::all();
  return view('Firma.yeniFirmaKaydet')->with('iller', $iller)->with('sektorler',$sektorler)->with('kullanici_id',$kullanici_id);
});

Route::get('/firmaIslemleri/{id?}',['middleware'=>'auth', function ($id = null) {
    //firma işlemlerindeki parametre opsiyonel yapıldı, eğer parametre geçirilmiyorsa sessiondan alınarak atama yapılıyor
    if($id == null && (session()->has('firma_id')))
    $id = session()->get('firma_id');
    $firma = Firma::find($id);

    if (Gate::denies('show', $firma)) {
    return Redirect::to('/');
    }

    $davetEdilIlanlar=DB::table('belirli_istekliler')
        ->join('ilanlar', 'ilanlar.id', '=', 'belirli_istekliler.ilan_id')
        ->join('firmalar', 'firmalar.id', '=', 'ilanlar.firma_id')
        ->select('ilanlar.id as ilan_id','ilanlar.adi as ilan_adi','ilanlar.kapanma_tarihi as ilan_kapanma_tarihi','firmalar.adi as firma_adi','firmalar.id as firma_id')
        ->where( 'kapanma_tarihi','>=', date('Y-m-d'))->where('belirli_istekliler.firma_id', $id)
        ->distinct()
        ->limit(3)
        ->get();

    $ilanlarFirma = $firma->ilanlar()->orderBy('yayin_tarihi','desc')->limit(3)->get();

    $teklifler= $firma->teklifler()->limit(3)->get();

    $tekliflerCount= $firma->teklifler()->count();

    return view('Firma.firmaIslemleri')->with('firma',$firma)->with('davetEdilIlanlar', $davetEdilIlanlar)
          ->with('ilanlarFirma', $ilanlarFirma)->with('teklifler', $teklifler)->with('tekliflerCount', $tekliflerCount);
}]);

Route::post('/ilanAra', 'IlanController@showIlan');
Route::get('/ilanAra', 'IlanController@showIlan');
Route::get('/ilanAra/{page}', 'IlanController@showIlan');

Route::post('/firmaHavuzu', 'FirmaController@showFirmalar');
Route::get('/firmaHavuzu', 'FirmaController@showFirmalar');
Route::get('/firmaHavuzu/{page}', 'FirmaController@showFirmalar');
Route::get('/onayliTedarikciEkle',  'FirmaController@onayliTedarikciEkle'); /// Tüm firmalar Sekmesinin Controlleri fonksiyonu
Route::get('/onayliTedarikciCikar',  'FirmaController@onayliTedarikciCikar'); /// Tüm firmalar Sekmesinin Controlleri fonksiyonu
Route::get('/onayliTedarikcilerim',  'FirmaController@onayliTedarikcilerim'); /// onayli firmalar sekmesinin controller fonksiyonu

Route::get('/kullaniciFirma',function () {
  $kullanici_id=Input::get('kullanici_id');
  $querys = DB::table('firma_kullanicilar')
  ->where( 'firma_kullanicilar.kullanici_id', '=',  $kullanici_id)
  ->join('firmalar', 'firma_kullanicilar.firma_id', '=', 'firmalar.id')
  ->select('firmalar.adi');
  $querys=$querys->get();
  return Response::json($querys);
});

Route::get('/il',function(){
  $il_id = Input::get('data');
  $il = \App\Il::find($il_id);
  return Response::json($il);
});
Route::get('/odeme',function(){
  $odeme_id= Input::get('data');
  $odeme = \App\OdemeTuru::find($odeme_id);
  return Response::json($odeme);

});
Route::get('/sektor',function(){
  $sektor_id= Input::get('data');
  $sektor =  \App\Sektor::find($sektor_id);
  return Response::json($sektor);

});
Route::post('/getIlan',function () {
  $querys = DB::table('ilanlar')
  ->join('firmalar', 'ilanlar.firma_id', '=', 'firmalar.id')
  ->join('adresler', 'adresler.firma_id', '=', 'firmalar.id')
  ->join('iller', 'adresler.il_id', '=', 'iller.id')
  ->select('ilanlar.adi as ilanadi', 'ilanlar.*','firmalar.id as firmaid', 'firmalar.*','adresler.id as adresid','adresler.*','iller.adi as iladi');
  /*$il_id = Input::get('il');
  $bas_tar = Input::get('bas_tar');
  $bit_tar = Input::get('bit_tar');   */
  $opts = isset($_POST['filterOpts'])? $_POST['filterOpts'] : array('');
  $options=json_decode($opts);
  foreach ($options as $option){
    if($option['sektorler'] != NULL){
      $querys->whereIn('firma_sektor',$option['sektorler']);
    }

  }
  $querys=$querys->get();
  return Response::json($querys);
});

Route::post('/form', 'Auth\AuthController@kayitForm');

Route::post('/yeniFirma/{id}', function (Request $request,$id) {

  DB::beginTransaction();

  try {

    $kullanici= App\Kullanici::find($id);

    $firma= new Firma();
    $firma->adi=Str::title(strtolower($request->adi));
    $now = new \DateTime();
    $firma->olusturmaTarihi=$now;
    $firma->save();

    $iletisim = $firma->iletisim_bilgileri ?: new App\IletisimBilgisi();
    $iletisim->telefon = $request->telefon;
    $firma->iletisim_bilgileri()->save($iletisim);

    $adres = $firma->adresler()->where('tur_id', '=', '1')->first() ?: new  App\Adres();
    $adres->il_id = $request->il_id;
    $adres->ilce_id = $request->ilce_id;
    $adres->semt_id = $request->semt_id;
    $adres->adres =Str::title(strtolower( $request->adres));
    $tur = 1;
    $adres->tur_id = $tur;
    $firma->adresler()->save($adres);

    $firma->sektorler()->attach($request->sektor_id);

    $kullanici->firmalar()->attach($firma);

    $data = ['ad' => $kullanici->adi, 'soyad' => $kullanici->soyadi];

    Mail::send('auth.emails.mesaj', $data, function($message) use($data,$id)
    {
      $kullanici= App\Kullanici::find($id);
      $message->to($kullanici->users->email, $data['ad'])
      ->subject('YENİ FİRMA EKLEME İSTEĞİ!');

    });

    DB::commit();
    // all good
  } catch (\Exception $e) {
    $error="error";
    DB::rollback();
    return Response::json($error);
  }
  //return redirect('/');
});

Route::get('ilanlarim/{firma_id}', 'IlanController@ilanlarim');

Route::get('basvurularim/{firma_id}', 'IlanController@basvurularim');

Route::get('/basvuruDetay/',function (){
  $teklifler =  \App\Teklif::all();

  $teklif_id = Input::get('teklif_id');
  foreach($teklifler as $teklif){
    if($teklif->ilanlar->ilan_turu==1){
      $detaylar = DB::table('mal_teklifler')
      ->join('ilan_mallar', 'ilan_mallar.id', '=', 'mal_teklifler.ilan_mal_id')
      ->join('ilanlar', 'ilanlar.id', '=', 'ilan_mallar.ilan_id')
      ->join('birimler', 'birimler.id', '=', 'ilan_mallar.birim_id')
      ->where( 'mal_teklifler.teklif_id', '=', $teklif_id)
      ->select('ilan_mallar.*','ilanlar.adi as ilanadi','birimler.adi as birimadi');

      $detaylar=$detaylar->get();
    }
    else if($teklif->ilanlar->ilan_turu==2){
      $detaylar = DB::table('hizmet_teklifler')
      ->join('ilan_hizmetler', 'ilan_hizmetler.id', '=', 'hizmet_teklifler.ilan_hizmet_id')
      ->join('ilanlar', 'ilanlar.id', '=', 'ilan_hizmetler.ilan_id')
      ->join('birimler', 'birimler.id', '=', 'ilan_hizmetler.fiyat_standardi_birim_id')
      //->join('birimler', 'birimler.id', '=', 'ilan_hizmetler.miktar_birim_id')
      ->where( 'hizmet_teklifler.teklif_id', '=', $teklif_id)
      ->select('ilan_hizmetler.*','ilanlar.adi as ilanadi','birimler.adi as fiyat_standardi_birim_adi');

      $detaylar=$detaylar->get();
    }
    else if($teklif->ilanlar->ilan_turu=='Götürü Bedel'){
      $detaylar = DB::table('goturu_bedeller_teklifler')
      ->join('ilan_goturu_bedeller', 'ilan_goturu_bedeller.id', '=', 'goturu_bedeller_teklifler.ilan_goturu_bedel_id')
      ->join('ilanlar', 'ilanlar.id', '=', 'ilan_goturu_bedeller.ilan_id')
      ->where( 'goturu_bedeller_teklifler.teklif_id', '=', $teklif_id)
      ->select('ilan_goturu_bedeller.*','ilanlar.adi as ilanadi');

      $detaylar=$detaylar->get();

    }
    else if($teklif->ilanlar->ilan_turu==3){
      $detaylar = DB::table('yapim_isi_teklifler')
      ->join('ilan_yapim_isileri', 'ilan_yapim_isileri.id', '=', 'yapim_isi_teklifler.ilan_yapim_isi_id')
      ->join('ilanlar', 'ilanlar.id', '=', 'ilan_yapim_isleri.ilan_id')
      ->join('birimler', 'birimler.id', '=', 'ilan_yapim_isleri.birim_id')
      ->where( 'yapim_isi_teklifler.teklif_id', '=', $teklif_id)
      ->select('ilan_yapim_isleri.*','ilanlar.adi as ilanadi','birimler.adi as birimadi');

      $detaylar=$detaylar->get();
    }
  }
  return Response::json($detaylar);
});

Route::get('/belirli/','IlanController@getBelirliFirmalar');

Route::get('/basvuruControl/',function (){
  $firma_id = session()->get('firma_id');
  $ilan_id = Input::get('ilan_id');
  $sektorler =  \App\FirmaSektor::where('firma_sektorler.firma_id', '=',session()->get('firma_id'))
  ->select('sektor_id');
  $sektorler = $sektorler->get()->toArray();
  $basvuruControl = DB::table('teklifler')
  ->join('firmalar', 'firmalar.id', '=', 'teklifler.firma_id')
  ->join('ilanlar', 'ilanlar.id', '=', 'teklifler.ilan_id')
  ->whereIn('ilanlar.ilan_sektor', $sektorler)
  ->where('teklifler.ilan_id', '=', $ilan_id)
  ->where('teklifler.firma_id', '=', $firma_id);
  $basvuruControl = $basvuruControl->count();

  return Response::json($basvuruControl);
});

Route::get('/IlanFirmaControl/',function (){
  $firma_adi = session()->get('firma_adi');
  $ilan_id = Input::get('ilan_id');

  $basvuruControl = DB::table('firmalar')
  ->join('ilanlar', 'ilanlar.firma_id', '=', 'firmalar.id')
  ->where('ilanlar.id', '=', $ilan_id)
  ->where('firmalar.adi', '=', $firma_adi);

  $basvuruControl = $basvuruControl->count();
  return Response::json($basvuruControl);
});

Route::get('/emailControl/',function (){
  $email = Input::get('email');
  $emailControl = DB::table('users')
  ->where('email', '=', $email);

  $emailControl = $emailControl->count();
  return Response::json($emailControl);
});
Route::get('/email_girisControl/',function (){
  $email_giris = Input::get('email_giris');
  $email_girisControl = DB::table('kullanicilar')
  ->where('email', '=', $email_giris);

  $email_girisControl = $email_girisControl->count();
  return Response::json($email_girisControl);
});

Route::get('ilanTeklifVer/{ilan_id}',['middleware'=>'auth' ,function ($ilan_id) {
    $firma = Firma::find(session()->get('firma_id'));
    $ilan = Ilan::find($ilan_id);
    $birimler=  \App\Birim::all();
    $teklifler= DB::select(DB::raw("SELECT *
        FROM teklif_hareketler th1
        JOIN (
          SELECT teklif_id, MAX( tarih ) tarih
          FROM teklifler t, teklif_hareketler th
          WHERE t.id = th.teklif_id
          AND t.ilan_id ='$ilan_id'
          GROUP BY th.teklif_id
        )th2 ON th1.teklif_id = th2.teklif_id
        AND th1.tarih = th2.tarih
        ORDER BY kdv_dahil_fiyat ASC "));
    $kullanici = App\Kullanici::find(session()->get('kullanici_id'));

    return view('Firma.ilan.ilanDetay')->with('firma', $firma)->with('ilan', $ilan)
            ->with('birimler',$birimler)->with('teklifler',$teklifler);
  }]);

  Route::get('/ilanOlustur/{firma_id}', 'IlanController@ilanOlustur');

  Route::post('/ilanOlusturEkle/{firma_id}', 'IlanController@ilanOlusturEkle');

  //firma profil route...
  Route::post('firmaProfili/uploadImage/{id}', 'FirmaController@uploadImage');
  Route::delete('firmaProfili/deleteImage/{id}', 'FirmaController@deleteImage');
  Route::post('firmaProfili/iletisimAdd/{id}', 'FirmaController@iletisimAdd');
  Route::post('firmaProfili/tanitim/{id}', 'FirmaController@tanitimAdd');
  Route::post('firmaProfili/malibilgi/{id}', 'FirmaController@maliBilgiAdd');
  Route::post('firmaProfili/ticaribilgi/{id}', 'FirmaController@ticariBilgiAdd');
  Route::post('firmaProfili/kalite/{id}', 'FirmaController@kaliteAdd');
  Route::post('firmaProfili/kaliteGuncelle/{id}', 'FirmaController@kaliteGuncelle');
  Route::post('firmaProfili/referans/{id}', 'FirmaController@referansAdd');
  Route::post('firmaProfili/firmaCalisan/{id}', 'FirmaController@calisanGunleriAdd');
  Route::post('firmaProfili/bilgilendirmeTercihi/{id}', 'FirmaController@bilgilendirmeTercihiAdd');
  Route::post('firmaProfili/firmaBrosur/{id}', 'FirmaController@uploadPdf');
  Route::post('firmaProfili/firmaBrosurGuncelle/{id}', 'FirmaController@brosurUpdate');
  Route::post('firmaProfili/referansUpdate/{id}', 'FirmaController@referansUpdate');
  Route::delete('firmaProfili/kaliteSil/{id}', 'FirmaController@deleteKalite');
  Route::delete('firmaProfili/referansSil/{id}', 'FirmaController@deleteReferans');
  Route::delete('firmaProfili/brosurSil/{id}', 'FirmaController@deleteBrosur');
  Route::get('/firmaProfili', 'FirmaController@showFirma');
  Route::get('/uyelikBilgileri', 'FirmaController@uyelikBilgileri');
  Route::get('/firma/{ref_id?}',function($ref_id){
    $referans=  FirmaReferans::find($ref_id);
    return Response::json($referans);

  });
  Route::get('/firmabrosur/{brosur_id?}',function($brosur_id){
    $brosur= App\FirmaBrosur::find($brosur_id);
    return Response::json($brosur);
  });

    Route::get('/ilanDuzenle/{firmaID}/{ilanID}', 'IlanController@ilanDuzenle');
    Route::post('/ilanDuzenle/{firmaID}/{ilanID}', 'IlanController@ilanDuzenleSubmit');

  //firma ilan route... /////////////////////////////////////////////////

  Route::get('/firmaMal/{ilan_mal_id?}',function($ilan_mal_id){
    $mal=  App\IlanMal::find($ilan_mal_id);
    return Response::json($mal);
  });
  Route::get('/firmaHizmet/{ilan_hizmet_id?}',function($ilan_hizmet_id){
    $hizmet= App\IlanHizmet::find($ilan_hizmet_id);
    return Response::json($hizmet);
  });
  Route::get('/firmaGoturuBedel/{ilan_goturu_bedel_id?}',function($ilan_goturu_bedel_id){
    $goturu= App\IlanGoturuBedel::find($ilan_goturu_bedel_id);
    return Response::json($goturu);
  });
  Route::get('/firmaYapimİsi/{ilan_yapim_isi_id?}',function($ilan_yapim_isi_id){
    $yapim= App\IlanYapimIsi::find($ilan_yapim_isi_id);
    return Response::json($yapim);
  });
  /////////////////////////////////////SET SESSION//////////////////////
  Route::get('/set_session' ,function () {

    $firmaId = Input::get('role');
    $firma = Firma::find($firmaId);
    Session::set('firma_id', $firmaId);
    Session::set('firma_adi', $firma->adi);
    Session::set('firma_logo', $firma->logo);
    return;
  });
  //////////////////////////////////////Puan Yorum //////////////////////
Route::post('/yorumPuan/{ilan_id}/{yorum_yapilan_firma_id}/' , 'IlanController@yorumPuan');

Route::get('kismiRekabet/{firmaID}/{ilanID}' ,'IlanController@kismiRekabetService');
Route::post('/teklifGonder/{firma_id}/{ilan_id}/{kullanici_id}', 'IlanController@teklifGonder');
Route::get('teklifGor/{id}/{ilanid}' ,'IlanController@teklifGor');
Route::get('ilaniPasifEt' ,'IlanController@ilaniPasifEt');
Route::get('ilaniAktifEt' ,'IlanController@ilaniAktifEt');
Route::post('KazananBelirleKismiAcik','IlanController@kazananBelirleKismiAcik');
Route::post('KazananBelirleKismiKapali','IlanController@kazananBelirleKismiKapali');

/////////////// Rekabet //////////////////////////////////////
Route::get('rekabet/{ilan_id}' ,function ($ilanid) {
    $ilan = App\Ilan::find($ilanid);
    $firma_id = session()->get('firma_id');
    $ilanSahibi=0;
    if($firma_id == $ilan->firmalar->id){
      $ilanSahibi=1;
    }
    $teklifler = $ilan->teklif_hareketler()->whereRaw('tarih IN (select MAX(tarih) FROM teklif_hareketler GROUP BY teklif_id)')->get();

    $minFiyat = $ilan->minFiyat();
    $kazanK = null;
    if($ilan->kismi_fiyat == 0){
        $kazananKapali = App\KismiKapaliKazanan::where("ilan_id",$ilan->id)->get(); /////ilanın kazananı var mı kontrolü
        $kisKazanCount=0;
        foreach($kazananKapali as $kazanK){
            $kisKazanCount=1;
        }
    }
    else{
        $kazananKapali = App\KismiAcikKazanan::where("ilan_id",$ilan->id)->get(); /////ilanın kazananı var mı kontrolü
        $kisKazanCount=0;
        foreach($kazananKapali as $kazanK){
            $kisKazanCount=1;
        }
    }

    return View::make('Firma.ilan.rekabet',array('teklifler'=> $teklifler,'ilanSahibi'=> $ilanSahibi,'ilan'=>$ilan,'minFiyat'=>$minFiyat,'kazanK'=>$kazanK,'kisKazanCount'=>$kisKazanCount))->render();
});

////////////////////////ilan detay ///////////////////////////
Route::get('ilanDetay', function () {
  $ilan_id = Input::get('ilan_id');
  $ilan = Ilan::find($ilan_id);
  return Response::json($ilan);
});

Route::get('/ajax-subcat', function (Request $request) {

  $il_id = Input::get('il_id');
  $ilceler = \App\Ilce::where('il_id', '=', $il_id)->get();
  return Response::json($ilceler);
});
Route::get('/ajax-subcatt', function () {
  $ilce_id = Input::get('ilce_id');
  $semtler = \App\Semt::where('ilce_id', '=', $ilce_id)->get();
  return Response::json($semtler);
});
Route::get('/vergi_daireleri', function (Request $request) {

  $il_id = Input::get('il_id');
  $vergi_daireleri = \App\VergiDairesi::where('il_id', '=', $il_id)->get();
  return Response::json($vergi_daireleri);
});
Route::get('/ticaret_odalari', function (Request $request) {

  $il_id = Input::get('il_id');
  $ticaret_odalari = \App\TicaretOdasi::where('il_id', '=', $il_id)->get();
  return Response::json($ticaret_odalari);
});

Route::auth();

Route::get('kullanici/onay/{kullanici_id}/{token}', 'Auth\AuthController@activateUser')->name('kullanici.onay');