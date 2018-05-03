<?php
namespace App\Http\Controllers;
use App\Firma;
use App\Sektor;
use App\Il;
use App\IletisimBilgisi;
use App\Adres;
use App\SirketTuru;
use App\TicariBilgi;
use App\TicaretOdasi;
use App\FirmaSatilanMarka;
use App\Ilce;
use App\Semt;
use Input;
use Session;
use File;
use Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\OnayliTedarikci;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Str;
use DB;
use Request as Req; // "Illuminate\Http\Request" ile karismamasi icin yeniden adlandirildi
use View;

class FirmaController extends Controller{

    public function __construct()
    {
      $this->middleware('firmaYetkili', ['except' => ['showFirma']]);
      $this->middleware('auth',['only'=>['showFirma']]);
    }

    /*public function properFunc($string){

    $proper=Str::title(strtolower($string));
    return response($proper);
    }*/

    public function showFirma(){
        $firma = Firma::find(session()->get('firma_id'));

        if (Gate::denies('show', $firma)) {
            return Redirect::to('/');
        }

        $firmaSektorleri=$firma->sektorler()->get();

        $firmaFatura = $firma->adresler()->where('tur_id', '=', '2')->first();
        if (!$firmaFatura) {
               $firmaFatura = new Adres();
               $firmaFatura->iller = new Il();
               $firmaFatura->ilceler = new Ilce();
               $firmaFatura->semtler = new Semt();
        }
        $firmaAdres = $firma->adresler()->where('tur_id', '=', '1')->first();
        if (!$firmaAdres) {
               $firmaAdres = new Adres();
               $firmaAdres->iller = new Il();
               $firmaAdres->ilceler = new Ilce();
               $firmaAdres->semtler = new Semt();
        }
        if (!$firma->ticari_bilgiler) {
                $firma->ticari_bilgiler = new TicariBilgi();
                $firma->ticari_bilgiler->ticaret_odalari = new TicaretOdasi();
                $firma->ticari_bilgiler->sektorler = new Sektor();
        }

        if (!$firma->kalite_belgeleri) {
            $firma->firma_kalite_belgeleri = new App\FirmaKaliteBelgesi();
        }

        if (!$firma->firma_referanslar) {
           $firma->firma_referanslar = new App\FirmaReferans();
        }
        else {
           $firmaReferanslar = $firma->firma_referanslar()->orderBy('ref_turu', 'desc')->orderBy('is_yili', 'desc')->get();
        }
        if (!$firma->firma_brosurler) {
                 $firma->firma_brosurler = new App\FirmaBrosur();
        }
        if (!$firma->firma_calisma_bilgileri) {
               $firma->firma_calisma_bilgileri = new \App\FirmaCalismaBilgisi();
               $calismaGunu = '';
        } else{
               $calismaGunu = $firma->firma_calisma_bilgileri->calisma_gunleri->adi;
        }
        $calisan= DB::table('firma_calisma_bilgileri')->where('firma_id', $firma->id)->count();
        $uretilenMarka = DB::table('uretilen_markalar')->where('firma_id', '=', $firma->id)->get();
        $satilanMarka = FirmaSatilanMarka::where('firma_id', '=', $firma->id)->get();
        $iller = Il::all();
        $sirketTurleri=  SirketTuru::all();
        $vergiDaireleri= \App\VergiDairesi::all();
        $ticaretodasi=  \App\TicaretOdasi::all();
        $ustsektor=  Sektor::all();
        $departmanlar=  \App\Departman::all();
        $faaliyetler= \App\Faaliyet::all();
        $kalite_belgeleri= \App\KaliteBelgesi::all();
        $calisma_günleri= \App\CalismaGunu::all();
        return view('Firma.firmaProfili', ['firma' => $firma], ['iller' => $iller])->with('sirketTurleri',$sirketTurleri)
                ->with('vergiDaireleri',$vergiDaireleri)->with('ustsektor',$ustsektor)
                ->with('ticaretodasi',$ticaretodasi)->with('departmanlar',$departmanlar)
                ->with('faaliyetler',$faaliyetler)->with('kalite_belgeleri',$kalite_belgeleri)
                ->with('calisma_günleri',$calisma_günleri)->with('firmaFatura',$firmaFatura)->with('firmaAdres',$firmaAdres)
                ->with('uretilenMarka',$uretilenMarka)->with('satilanMarka',$satilanMarka)->with('calisan',$calisan)
                ->with('firmaReferanslar',$firmaReferanslar)
                ->with('calismaGunu',$calismaGunu)->with('firmaSektorleri',$firmaSektorleri);
     }

    public function firmaDetay($firma_id){
        $firma=Firma::where('id', $firma_id)->with([
            'firma_satilan_markalar',
            'uretilen_markalar',
            'adresler' => function($query) use ($firma_id){
            $query->where('tur_id', '1')->union(DB::table('adresler')->where('firma_id', $firma_id)->where('tur_id', '2'))->orderBy('tur_id', 'ASC');
            },
            'adresler.iller',
            'adresler.ilceler',
            'adresler.semtler',
            'mali_bilgiler',
            'ticari_bilgiler',
            'departmanlar',
            'faaliyetler',
            'sirket_turleri',
            'kalite_belgeleri',
            'firma_referanslar' => function($query){$query->orderBy('ref_turu', 'desc')->orderBy('is_yili', 'desc');},
            'firma_brosurler',
            'firma_calisma_bilgileri'
        ])->first();

        if (!count($firma))
            abort('404');

        //hatalar icin
        $sirketTurleri=  SirketTuru::all();
        $firmaFatura = $firma->adresler()->where('tur_id', '=', '2')->first();
        if (!$firmaFatura) {
            $firmaFatura = new Adres();
            $firmaFatura->iller = new Il();
            $firmaFatura->ilceler = new Ilce();
            $firmaFatura->semtler = new Semt();
        }
        $firmaAdres = $firma->adresler()->where('tur_id', '=', '1')->first();
        $kalite_belgeleri= \App\KaliteBelgesi::all();
        $firmaSektorleri=$firma->sektorler()->get();
        //
        //yorumlar ve puanlar arasında eloquent ilişkisi olmadığı için query builder.
        $yorumlar = DB::table('yorumlar')->where('yorumlar.firma_id', $firma_id)->orderBy('yorumlar.tarih', 'DESC')
        ->join('puanlamalar', 'yorumlar.firma_id', '=', 'puanlamalar.firma_id')
        ->join('firmalar', 'yorumlar.yorum_yapan_firma_id', '=', 'firmalar.id')//firma isimleri için
        ->get();

        $onaylimi=false;//kullanıcının onaylı firmalarında var mı
        {
            $onaylimi=DB::table('onayli_tedarikciler')->select('firma_id')->where('firma_id', session()->get('firma_id'))->where('tedarikci_id', $firma_id)->first();
        }

        return view('Firma.firmaDetay')->with(['firma'=>$firma, 'yorumlar'=>$yorumlar])->with('sirketTurleri',$sirketTurleri)
            ->with('firmaFatura',$firmaFatura)->with('kalite_belgeleri',$kalite_belgeleri)->with('firmaAdres',$firmaAdres)
            ->with('firmaSektorleri',$firmaSektorleri)->with('onaylimi',$onaylimi);
    }

    public function uyelikBilgileri(){
        $firma = Firma::where('id', session()->get('firma_id'))->with(['odemeler'])->first();
        return view('Firma.uyelikBilgileri', ['firma' => $firma]);
    }

    public function showFirmalar(){
    $firma_id = session()->get('firma_id');
    $iller = Il::all();
    $sektorler= Sektor::all();
    $firma = Firma::find($firma_id);
    $onayli_tedarikciler=OnayliTedarikci::where('firma_id', $firma_id)->select('tedarikci_id')->get();
    Debugbar::info($onayli_tedarikciler);
    $il_id = Input::get('il');
    $sektorlerInput = Input::get('sektor');
    $radSearch= Input::get('radSearch');
    $input= Input::get('input');
    /*SELECT *, (select case
       when exists (
          SELECT 1
          FROM onayli_tedarikciler o
          WHERE o.tedarikci_id = f.id
             AND o.firma_id = 9
       )
       then 1
       else 0
    end)
    FROM firmalar f */
    //$firmalar=Firma::select("*");
    $firmalar = Firma::join('adresler', 'adresler.firma_id', '=', 'firmalar.id')
            ->join('iller', 'adresler.il_id', '=', 'iller.id')
            ->where('adresler.tur_id', '=' , 1)
            ->select("firmalar.*","firmalar.adi as firma_adi","iller.adi as iladi",DB::raw("(case
            when exists (
               SELECT 1
               FROM onayli_tedarikciler o
               WHERE o.tedarikci_id = firmalar.id
                  AND o.firma_id = 9
            )
            then 1
            else 0
         end)as onay"));
    if($radSearch != NULL){
        if($radSearch == "sektor"){
            $firmalar = $firmalar->join('firma_sektorler', 'firmalar.id', '=', 'firma_sektorler.firma_id')
            ->join('sektorler', 'firma_sektorler.sektor_id', '=', 'sektorler.id')->where('sektorler.adi',$input);
        }
        else if($radSearch == "sehir"){
            DebugBar::info($input);
            $firmalar=$firmalar->where('iller.adi',Str::upper($input));
        }
        else if($radSearch == "firma"){
            $firmalar=$firmalar->where('firmalar.adi', 'like', '%' . $input . '%');
        }

    }
    if($radSearch == ""){
        if($input != NULL){
            Debugbar::info("girdi Else");
            $firmalar = $firmalar->where(function ($query) use ($input) {
                    $query->whereExists(function ($q) use($input) {
                        $q->select(DB::raw(1))
                        ->join('sektorler', 'sektorler.id', '=', 'firma_sektorler.sektor_id')
                        ->from('firma_sektorler')
                        ->whereRaw('firmalar.id = firma_sektorler.firma_id')->where('sektorler.adi',$input);
                    })
                    ->orWhere('iller.adi',Str::upper($input))
                    ->orWhere('firmalar.adi', 'like', '%' . $input . '%');
                });
        }
    }
    if($il_id != NULL){
        $firmalar=$firmalar->whereIn('adresler.il_id',$il_id);
    }

    if($sektorlerInput != NULL){
        $firmalar = $firmalar->join('firma_sektorler', 'firmalar.id', '=', 'firma_sektorler.firma_id')
            ->join('sektorler', 'firma_sektorler.sektor_id', '=', 'sektorler.id')->whereIn('sektorler.id',$sektorlerInput);
    }

    $firmalar=$firmalar->paginate(5);
     DebugBar::info($firmalar);
    if (Req::ajax()) {
        return Response::json(View::make('Firma.firmalar',array('firmalar'=> $firmalar))->render());
    }

    return View::make('Firma.firmaHavuzu')-> with('firmalar',$firmalar)
            ->with('iller', $iller)->with('sektorler',$sektorler)
            ->with('firma',$firma)->with('onayliTedarikciler',$onayli_tedarikciler);

    }

    public function onayliTedarikciEkle(){
    $firma_id = session()->get('firma_id');
    if($firma_id) {
        $tedarikci_id = Input::get('tedarikci_id');
        $kontrol = OnayliTedarikci::where('firma_id', $firma_id)->where('tedarikci_id', $tedarikci_id)->count();
        if ($kontrol == 0) {
            $tedarikci = new OnayliTedarikci();
            $tedarikci->firma_id = $firma_id;
            $tedarikci->tedarikci_id = $tedarikci_id;
            $tedarikci->save();
        }
    }
    }

    public function onayliTedarikciCikar(){
    $firma_id = session()->get('firma_id');
    if($firma_id){
        $tedarikci_id = Input::get('tedarikci_id');
        OnayliTedarikci::where('firma_id',$firma_id)->where('tedarikci_id',$tedarikci_id)->delete();
    }
    }

    public function onayliTedarikcilerim(){
    $onayli_tedarikciler  = Firma::join('adresler', 'adresler.firma_id', '=', 'firmalar.id')
            ->join('iller', 'adresler.il_id', '=', 'iller.id')
            ->where('adresler.tur_id', '=' , 1)
            ->whereExists(function ($query) {
                $query->select(DB::raw("*"))
                      ->from('onayli_tedarikciler')
                      ->whereRaw('onayli_tedarikciler.firma_id='.session()->get("firma_id"))
                      ->whereRaw('onayli_tedarikciler.tedarikci_id = firmalar.id');
            })
            ->select("firmalar.*","firmalar.adi as firma_adi","iller.adi as iladi")->get();
    return View::make('Firma.onayliTedarikciler')-> with('onayli_tedarikciler',$onayli_tedarikciler);
    }

    public function uploadImage(Request $request) {
        $file = array('logo' => $request->file('logo'));
        $rules = array('logo' => 'required|mimes:jpeg,bmp,png|max:100000'); //mimes:jpeg,bmp,png and for max size max:10000
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
            return Redirect::to('firmaProfili')->withInput()->withErrors($validator);
        }
        else {
            if ($request->file('logo')->isValid()) {
                $destinationPath = 'uploads'; // upload path
                $extension = $request->file('logo')->getClientOriginalExtension();
                $fileName = rand(11111, 99999) . '.' . $extension;

                $firma = Firma::find($request->id);
                $oldName=$firma->logo;
                $firma->logo = $fileName;
                $firma->save();
                $request->file('logo')->move($destinationPath, $fileName);
                Session::set('firma_logo', $fileName);

                Session::flash('success', 'Upload successfully');
                File::delete("uploads/$oldName");
                if(session()->get('firma_id')!=''){
                    FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
                }
                return Redirect::to('firmaProfili');
            }
            else {
                Session::flash('error', 'uploaded file is not valid');
                return Redirect::to('firmaProfili')->withInput()->withErrors($validator);
            }
        }
    }

    public function deleteImage($id){
      $item = Firma::findOrFail($id);
      $oldName=$item->logo;
      $item->logo=null;
      $item->save();
      File::delete("uploads/$oldName");
      Session::set('firma_logo', '');
        if(session()->get('firma_id')!=''){
            FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
        }
    return Redirect::to('firmaProfili');
    }

    public function iletisimAdd(Request $request){

    DB::beginTransaction();

    try {
        $firma = Firma::find($request->id);

        $iletisim = $firma->iletisim_bilgileri ?: new IletisimBilgisi();
        $iletisim->telefon =Str::title(strtolower( $request->telefon));
        $iletisim->fax =Str::title(strtolower( $request->fax));
        $iletisim->web_sayfasi = $request->web_sayfasi;
        $firma->iletisim_bilgileri()->save($iletisim);

        $adres = $firma->adresler()->where('tur_id', '=', '1')->first() ?: new Adres();
        $adres->il_id = $request->il_id;
        $adres->ilce_id = $request->ilce_id;
        $adres->semt_id = $request->semt_id;
        $adres->adres = Str::title(strtolower($request->adres));
        $tur = 1;
        $adres->tur_id = $tur;
        $firma->adresler()->save($adres);
        DB::commit();
        if(session()->get('firma_id')!=''){
            FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
        }
        // all good
    } catch (\Exception $e) {
        $error="error";
        DB::rollback();
        if(session()->get('firma_id')!=''){
            FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
        }
        return Response::json($error);
    }
    }

    public function tanitimAdd(Request $request){
        $firma = Firma::find($request->id);
        $firma->tanitim_yazisi = Str::title(strtolower($request->tanitim_yazisi));
        $firma->save();
        if(session()->get('firma_id')!=''){
            FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
        }
        return redirect('firmaProfili');
    }

    public function maliBilgiAdd(Request $request){

    DB::beginTransaction();

    try {
            $firma = Firma::find($request->id);
            $firma->sirket_turu =Str::title(strtolower( $request->sirket_turu));
            $firma->save();

            $maliBilgi = $firma->mali_bilgiler ?: new \App\MaliBilgi();
            $maliBilgi->unvani =Str::title(strtolower( $request->unvani));
            $maliBilgi->vergi_numarasi =Str::title(strtolower( $request->vergi_numarasi));
            $maliBilgi->vergi_dairesi_id = $request->vergi_dairesi_id;
            $maliBilgi->sermayesi = Str::title(strtolower($request ->sermayesi));
            $maliBilgi->yillik_cirosu = Str::title(strtolower($request ->yillik_cirosu));

            $maliBilgi->ciro_goster= '0';
            if(isset($request->ciro_goster)){
            $maliBilgi->ciro_goster = '1';
            }

            $maliBilgi->sermaye_goster = '0';
            if (isset($request->sermaye_goster)){
                $maliBilgi->sermaye_goster='1';
            }

            $firma->mali_bilgiler()->save($maliBilgi);

            $adres = $firma->adresler()->where('tur_id', '=', '2')->first() ?: new Adres();
            $adres->il_id = $request->mali_il_id;
            $adres->ilce_id = $request->mali_ilce_id;
            $adres->semt_id = $request->mali_semt_id;
            $adres->adres =Str::title(strtolower($request->fatura_adresi));
            $tur = 2;
            $adres->tur_id = $tur;
            $firma->adresler()->save($adres);

     DB::commit();
        if(session()->get('firma_id')!=''){
            FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
        }
        // all good
    } catch (\Exception $e) {
        $error="error";
        DB::rollback();
        if(session()->get('firma_id')!=''){
            FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
        }
        return Response::json($error);
    }
    }

    public function ticariBilgiAdd(Request $request){

    DB::beginTransaction();

    try {

        $firma = Firma::find($request->id);
        $firma->kurulus_tarihi=$request->kurulus_tarihi;
        $firma->save();

        $ticariBilgi = $firma->ticari_bilgiler ?: new \App\TicariBilgi();
        $ticariBilgi->tic_sicil_no = $request->ticaret_sicil_no;
        $ticariBilgi->tic_oda_id = $request->ticaret_odasi;
        $ticariBilgi->ust_sektor = $request->ust_sektor;

        $firma->ticari_bilgiler()->save($ticariBilgi);

        if(count($request->faaliyet_sektorleri) > 1){
            foreach($request->faaliyet_sektorleri as $sektor){
                $kayitKontrol = \App\FirmaSektor::where('firma_id',$firma->id)->where('sektor_id',$sektor)->get();
                if(count($kayitKontrol) == 0){
                    $firma->sektorler()->attach($sektor);
                }
            }
        }

        else{
            $kayitKontrol = \App\FirmaSektor::where('firma_id',$firma->id)->where('sektor_id',$request->faaliyet_sektorleri)->get();
            if(count($kayitKontrol) == 0){
                $firma->sektorler()->attach($request->faaliyet_sektorleri);
            }
        }

        foreach($request->firma_faaliyet_turu as $faaliyetTur){
            $kayitKontrol = \App\FirmaFaaliyet::where('firma_id',$firma->id)->where('faaliyet_id',$faaliyetTur)->get();
            if(count($kayitKontrol) == 0){
                $firma->faaliyetler()->attach($faaliyetTur);
            }
        }

        $firma->uretilen_markalar()->delete();
        if(isset($request->firmanin_urettigi_markalar)){
            foreach($request->firmanin_urettigi_markalar as $urettigiMarka){
                $uretilenMarka = new \App\UretilenMarka();
                $uretilenMarka->adi = $urettigiMarka;
                $firma->uretilen_markalar()->save($uretilenMarka);
            }
        }

        $firma->firma_satilan_markalar()->delete();
        if (isset($request->firmanin_sattigi_markalar)){
            foreach($request->firmanin_sattigi_markalar as $sattigiMarka){
                $satilanMarka = new \App\FirmaSatilanMarka();
                $satilanMarka->satilan_marka_adi = $sattigiMarka;
                $firma->firma_satilan_markalar()->save($satilanMarka);
            }
        }

       DB::commit();
        if(session()->get('firma_id')!=''){
            FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
        }
        // all good
    } catch (\Exception $e) {
        $error="error";
        DB::rollback();
        if(session()->get('firma_id')!=''){
            FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
        }
        return Response::json($error);
    }
    }

    public function kaliteAdd(Request $request){

    DB::beginTransaction();

        try {
            $firma = Firma::find($request->id);
            $firma->kalite_belgeleri()->attach($request->kalite_belgeleri,['belge_no'=>$request->belge_no]);

           DB::commit();
            if(session()->get('firma_id')!=''){
                FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
            }
            // all good
        } catch (\Exception $e) {
            $error="error";
            DB::rollback();
            if(session()->get('firma_id')!=''){
                FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
            }
            return Response::json($error);
        }
    }

    public function referansAdd(Request $request){

    DB::beginTransaction();

    try {
        $firma = Firma::find($request->id);
        $firma_referans = $firma->firma_referanslar ?: new \App\FirmaReferans();
            if ($firma->firma_referanslar) {
                $firmaReferans = $firma->firma_referanslar()->where('id', '=', '$request->ref_id')->first() ? : new \App\FirmaReferans();
            } else {
                $firmaReferans = $firma->firma_referanslar()->where('ref_turu', '=', '$request->ref_turu')->first() ? : new \App\FirmaReferans();
            }

        $firmaReferans->ref_turu=Str::title(strtolower($request->ref_turu));
        $firmaReferans->adi=Str::title(strtolower($request->ref_firma_adi));
        $firmaReferans->is_adi=Str::title(strtolower($request->yapılan_isin_adi));
        $firmaReferans->is_turu=$request->isin_turu;
        $firmaReferans->is_yili=$request->is_yili;
        $firmaReferans->calisma_suresi=Str::title(strtolower($request->calısma_suresi));
        $firmaReferans->yetkili_adi=Str::title(strtolower($request->yetkili_kisi_adi));
        //$firmaReferans->yetkili_email=$request->yetkili_kisi_email;
        //$firmaReferans->yetkili_telefon=Str::title(strtolower($request->yetkili_kisi_telefon));
        $firma->firma_referanslar()->save( $firmaReferans);

       DB::commit();
        if(session()->get('firma_id')!=''){
            FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
        }
        // all good
    } catch (\Exception $e) {
        $error="error";
        DB::rollback();
        if(session()->get('firma_id')!=''){
            FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
        }
        return Response::json($error);
    }
    }

    public function referansUpdate(Request $request){
        DB::beginTransaction();
        try {
        $referans = \App\FirmaReferans::find($request->ref_id);
        $referans->ref_turu=Str::title(strtolower($request->ref_turu));
        $referans->adi=Str::title(strtolower($request->ref_firma_adi));
        $referans->is_adi=Str::title(strtolower($request->yapılan_isin_adi));
        $referans->is_turu=$request->isin_turu;
        $referans->is_yili=$request->is_yili;
        $referans->calisma_suresi=Str::title(strtolower($request->calısma_suresi));
        $referans->yetkili_adi=Str::title(strtolower($request->yetkili_kisi_adi));
        $referans->yetkili_email=$request->yetkili_kisi_email;
        $referans->yetkili_telefon=Str::title(strtolower($request->yetkili_kisi_telefon));
        $referans->save( );
        DB::commit();
            if(session()->get('firma_id')!=''){
                FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
            }
        } catch (\Exception $e) {
            $error="error";
            DB::rollback();
            if(session()->get('firma_id')!=''){
                FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
            }
            return Response::json($error);
        }
        return redirect('firmaProfili');
    }

    public function kaliteGuncelle(Request $request){
        DB::beginTransaction();
        try {
            \App\FirmaKaliteBelgesi::where('belge_id',$request->kalite_id)->where('firma_id',$request->firma_id)->where('belge_no',$request->eski_belge_no)->delete();
            $firma = Firma::find($request->id);
            $firma->kalite_belgeleri()->attach($request->kalite_belgeleri,['belge_no'=>$request->belge_no]);
           DB::commit();
            if(session()->get('firma_id')!=''){
                FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
            }
            // all good
        } catch (\Exception $e) {
            $error="error";
            DB::rollback();
            if(session()->get('firma_id')!=''){
                FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
            }
            return Response::json($error);
        }
    }

    public function brosurUpdate(Request $request,$id){
        $brosur = \App\FirmaBrosur::find($id);
        $brosur->adi=Str::title(strtolower($request->brosur_adi));
        $brosur->save( );
        if(session()->get('firma_id')!=''){
            FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
        }
        return Redirect::to('firmaProfili');
    }

    public function calisanGunleriAdd(Request $request){

    DB::beginTransaction();

    try {
    $firma = Firma::find($request->id);
     foreach($request->firma_departmanları as $departman){
        $kayitKontrol = \App\FirmaDepartman::where('firma_id',$firma->id)->where('departman_id',$departman)->get();
        if(count($kayitKontrol) == 0){
            $firma->departmanlar()->attach($departman);
        }
    }
    $firma_calisan = $firma->firma_calisma_bilgileri ?: new \App\FirmaCalismaBilgisi();
    $firma_calisan->calisma_gunleri_id=$request->calisma_gunleri;
    $firma_calisan->calisma_saatleri=Str::title(strtolower($request->calisma_saatleri));


    if(count($request->firma_calisma_profili)== 2){

         $firma_calisan->calisan_profili = 3;

    }
    else {
          foreach($request->firma_calisma_profili as $calisan){

           $firma_calisan->calisan_profili = $calisan;
          }

    }
    $firma_calisan->calisan_sayisi=Str::title(strtolower($request->calisma_sayisi));
    $firma->firma_calisma_bilgileri()->save( $firma_calisan);

        DB::commit();
        if(session()->get('firma_id')!=''){
            FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
        }
        // all good
    } catch (\Exception $e) {
        $error="error";
        DB::rollback();
        if(session()->get('firma_id')!=''){
            FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
        }
        return Response::json($error);
    }
    }

    public function bilgilendirmeTercihiAdd(Request $request){

    DB::beginTransaction();

    try {
        $firma = Firma::find($request->id);
        $firma->sms=0;
        $firma->mail=0;
        $firma->telefon=0;
        foreach($request->bilgilendirme_tercihi as $bilgilendirme){
            if($bilgilendirme == "Sms"){
                $firma->sms=1;
            }
            elseif ($bilgilendirme == "Mail") {
                $firma->mail=1;
            }
            elseif($bilgilendirme == "Telefon"){
                $firma->telefon=1;
            }
        }
        $firma->save();

        DB::commit();
        if(session()->get('firma_id')!=''){
            FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
        }
        // all good
    } catch (\Exception $e) {
        $error="error";
        DB::rollback();
        if(session()->get('firma_id')!=''){
            FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
        }
        return Response::json($error);
    }
    }

    public function uploadPdf(Request $request){

    $file = array('yolu' => $request->file('yolu'));
    // setting up rules
    $rules = array('yolu' => 'required|mimes:pdf|max:100000'); //mimes:jpeg,bmp,png and for max size max:10000
    // doing the validation, passing post data, rules and the messages
    $validator = Validator::make($file, $rules);

    if ($validator->fails()) {
        // send back to the page with the input data and errors
        return "Brosur Eklenemedi PDF dosya turu gerekli.";
    }
    else {
        // checking file is valid.
        if ($request->file('yolu')->isValid()) {
            $destinationPath = 'brosur'; // upload path
            $extension = $request->file('yolu')->getClientOriginalExtension(); // getting image extension
            $fileName = rand(11111, 99999) . '.' . $extension; // renameing image

            $firma = Firma::find($request->id);
            $firma_brosur= new \App\FirmaBrosur();

            /*if ($firma->firma_brosurler() != " "){
                $oldName=$firma->firma_brosurler()->first()->yolu ;

            }*/

            $firma_brosur->yolu = $fileName;
            $firma_brosur->adi=Str::title(strtolower($request->brosur_adi));
            $firma->firma_brosurler()->save($firma_brosur);

            $request->file('yolu')->move($destinationPath, $fileName); // uploading file to given path
            // sending back with message
            Session::flash('success', 'Upload successfully');
            /*if ($firma->firma_brosurler){

            File::delete("brosur/$oldName");
            }*/
            if(session()->get('firma_id')!=''){
                FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
            }
            return Redirect::to('firmaProfili');
            //return  Redirect::route('commucations')->with('fileName', $fileName);
        } else {
            // sending back with error message.
            Session::flash('error', 'uploaded file is not valid');
            if(session()->get('firma_id')!=''){
                FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
            }
            return false;
        }
    }

    }

    public function deleteKalite(Request $request,$id){
        \App\FirmaKaliteBelgesi::where('belge_id',$id)->where('firma_id',$request->firma_id)->where('belge_no',$request->belge_no)->delete();
        if(session()->get('firma_id')!=''){
            FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
        }
        return redirect('firmaProfili');
    }

    public function deleteReferans(Request $request,$id){
        $referans = \App\FirmaReferans::find($id);
        $referans->delete();
        if(session()->get('firma_id')!=''){
            FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
        }
        return redirect('firmaProfili');
    }

    public function deleteBrosur($id){
        $brosur = \App\FirmaBrosur::find($id);
        File::delete("brosur/$brosur->yolu");
        $brosur->delete();
        if(session()->get('firma_id')!=''){
            FirmaController::firmaProfilDolulukHesapla(session()->get('firma_id'));
        }
        return redirect('firmaProfili');
    }

    public function firmaProfilDolulukHesapla($firmaID){
        $firma = Firma::find($firmaID);
        $toplamOzellik = 28;
        $doluOzellik = 0;

        //ILETISIM BILGILERI
        if ($firma->iletisim_bilgileri->telefon != ""){
            $doluOzellik++;
        }
        if ($firma->iletisim_bilgileri->fax != ""){
            $doluOzellik++;
        }
        if ($firma->iletisim_bilgileri->web_sayfasi != ""){
            $doluOzellik++;
        }
        $firmaAdresi=$firma->adresler()->where('tur_id', '=', '1')->first();
        if ($firmaAdresi){
            $doluOzellik++;
        }
        $firmaFaturaAdresi=$firma->adresler()->where('tur_id', '=', '2')->first();
        if ($firmaFaturaAdresi){
            $doluOzellik++;
        }
        //TANITIM YAZISI
        if ($firma->tanitim_yazisi != ""){
            $doluOzellik++;
        }
        //BROSUR
        if (count($firma->firma_brosurler)!=0){
            $doluOzellik++;
        }
        //MALI BILGILER
        if($firma->mali_bilgiler!=null){
            if ($firma->mali_bilgiler->unvani != ""){
                $doluOzellik++;
            }
            if ($firma->mali_bilgiler->vergi_daireleri->adi != ""){
                $doluOzellik++;
            }
            if ($firma->mali_bilgiler->vergi_numarasi != ""){
                $doluOzellik++;
            }
            if ($firma->mali_bilgiler->yillik_cirosu != ""){
                $doluOzellik++;
            }
            if ($firma->mali_bilgiler->sermayesi != ""){
                $doluOzellik++;
            }
            if ($firma->sirket_turu != ""){
                $doluOzellik++;
            }
        }

        //TICARI BILGILER
        if($firma->ticari_bilgiler!=null){
            if ($firma->ticari_bilgiler->tic_sicil_no != ""){
                $doluOzellik++;
            }
            if ($firma->ticari_bilgiler->ticaret_odalari!=null && $firma->ticari_bilgiler->ticaret_odalari->adi != ""){
                $doluOzellik++;
            }
        }

        if ($firma->kurulus_tarihi){
            $doluOzellik++;
        }
        $ustSektor=$firma->getUstSektor();
        if ($ustSektor != ""){
            $doluOzellik++;
        }
        if (count($firma->sektorler) != 0){
            $doluOzellik++;
        }
        $countUretilenMarka = DB::table('uretilen_markalar')->where('firma_id', '=', $firma->id)->count();
        if ($countUretilenMarka != 0){
            $doluOzellik++;
        }
        $countSatilanMarka = FirmaSatilanMarka::where('firma_id', '=', $firma->id)->count();
        if ($countSatilanMarka != 0){
            $doluOzellik++;
        }
        //IDARI BILGILER
        if($firma->firma_calisma_bilgileri!=null){
            if ($firma->firma_calisma_bilgileri->calisma_gunleri!=null && $firma->firma_calisma_bilgileri->calisma_gunleri->adi != ""){
                $doluOzellik++;
            }
            if ($firma->firma_calisma_bilgileri->calisma_saatleri != ""){
                $doluOzellik++;
            }
            if ($firma->firma_calisma_bilgileri->calisan_sayisi != ""){
                $doluOzellik++;
            }
        }

        $calisanProfili = $firma->getCalisanProfil();
        if ($calisanProfili != ""){
            $doluOzellik++;
        }
        if (count($firma->departmanlar) != ""){
            $doluOzellik++;
        }
        //KALITE BELGESI
        if (count($firma->kalite_belgeleri)!=0){
            $doluOzellik++;
        }
        //REFERANS
        if (count($firma->firma_referanslar)!=0){
            $doluOzellik++;
        }
        //BILGILENDIRME TERCIHI
        if ($firma->sms == 0 || $firma->sms == 1){
            $doluOzellik++;
        }

        $sonuc = ($doluOzellik / $toplamOzellik) * 100;

        $firma ->doluluk_orani= (int) $sonuc;
        $firma ->save();
    }

    public function yardim(){
        return view('firma.yardim');
    }


    //eski fonksiyonlar...suan kullanılmıyorlar
    public function firma(Request $request){
      $firma = new Firma();
      $firma->adi = $request->firmaAdi;
      $firma->save();

      foreach($request->sektor as $sektor)
          $firma->sektorler()->attach($sektor);
      return redirect('/');
    }
    public function index($id){
      $firmalar = Firma::find($id);
      $sektorler = Sektor::all();

      return view('firmaKaydet')->with('firmalar',$firmalar)->with('sektorler', $sektorler);
    }
}
