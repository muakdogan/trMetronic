<?php

namespace App\Http\Controllers;

use App\FirmaKullanici;
use Illuminate\Http\Request;

use App\Http\Requests;
use Password;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use App\Firma;
use App\Kullanici;
use Illuminate\Support\Str;
use DB;
use Barryvdh\Debugbar\Facade as Debugbar;

class KullaniciController extends Controller
{
  use ResetsPasswords;

    protected $subject = "Your Account Password";

    public function __construct(Guard $auth, PasswordBroker $passwords)
    {
        $this->auth = $auth;
        $this->passwords = $passwords;
        // $this->subject = 'Your Account Password';

        $this->middleware('guest', ['only' => ['notify']]);//Kullanıcı login olduğunda belli bir sayfaya (/ilanAra) redirect olması için?
        $this->middleware('firmaYetkili', ['except' => ['notify']]);
    }

    public function notify(Request $request, $id)
    {
        $firma = Firma::find($id);
           $roller=  App\Rol::all();
            
        
          $kullanici= new App\Kullanici();
          $kullanici->adi = Str::title(strtolower($request->adi));
          $kullanici->soyadi = Str::title(strtolower($request->soyadi));
          $kullanici->email = $request->email;
          $kullanici->save();
          
            $user = $kullanici->user ?: new App\User();
           
            $user->email = $request->email;
            
            $user->password =Hash::make('tamrekabet');

            $rol=$request->rol;

            $kullanici->users()->save($user);
             
            $firma->kullanicilar()->attach($kullanici,['rol_id'=>$rol]);
             
            $data = ['ad' => $request->adi, 'soyad' => $request->soyadi];
        
            dump( $this->passwords->sendResetLink(
                ['email' => $request->email]),
                function($message){
                    $message->subject('Your Account Password');
                }
            );
            return view('Kullanici.kullaniciIslemleri')->with('firma',$firma)->with('roller',$roller);
    }

    public function kullaniciIslemleri()
    {
        $firma = Firma::find(session()->get('firma_id'));
        $kullanici = Kullanici::find(session()->get('kullanici_id'));
        Debugbar::info($kullanici->firma_kullanici->roller->adi);
        $roller=  \App\Rol::all();
        return view('Kullanici.kullaniciIslemleri')->with('firma',$firma)->with('roller',$roller)->with('kullanici',$kullanici);
    }

    public function kullaniciIslemleriGuncelle(Request $request) {
    DB::beginTransaction();
    try {
        $kullanici = Kullanici::find($request->kullanici_id);
        $firmaKullanici =$kullanici->firma_kullanici()->first();
        if($firmaKullanici->firma_id != session()->get('firma_id')){
            abort(403);
        }
        $kullanici->adi = Str::title(strtolower($request->adi));
        $kullanici->soyadi = Str::title(strtolower($request->soyadi));
        //$kullanici->email = $request->email;
        $kullanici->save();
        $firmaKullanici->rol_id =$request->rol;
        $firmaKullanici->unvan=$request->unvan;
        $firmaKullanici->save();
        DB::commit();
        return redirect('/kullaniciIslemleri');
        // all good
    } catch (\Exception $e) {
        DB::rollback();
        return "error";
    }
}

    public function kullaniciSifreDegisikligi(Request $request){
        $kullanici= Kullanici::find(session()->get('kullanici_id'));
        $kullanici->password =Hash::make($request->sifre);
        $kullanici->save();
        return redirect('/kullaniciIslemleri');
    }

    public function kullaniciSil(Request $request){
        $firma = Firma::find(session()->get('firma_id'));
        $kullanici = $firma->kullanicilar()->where('kullanici_id',$request->kullanici_id)->delete();
        return redirect('/kullaniciIslemleri');
    }

    public function kullaniciBilgileri () {
        return view('Kullanici.kullaniciBilgileri')->with('firma',Firma::find(session()->get('firma_id')));
    }

    public function kullaniciBilgileriUpdate (Request $request) {
        $kullanici= Kullanici::find(session()->get('kullanici_id'));
        $kullanici->adi = Str::title(strtolower($request->adi));
        $kullanici->soyadi = Str::title(strtolower($request->soyadi));
        $kullanici->telefon = $request->telefon;
        $kullanici->save();
        return redirect('/kullaniciIslemleri');
    }

    public function kullaniciIslemleriEkle (Request $request,$id) {

        DB::beginTransaction();

        try {
            $firma = Firma::find($id);
            $roller=  \App\Rol::all();

            $kullanici= new \App\Kullanici();
            $kullanici->adi = Str::title(strtolower($request->adi));
            $kullanici->soyadi = Str::title(strtolower($request->soyadi));
            $kullanici->email = $request->email;
            $kullanici->onayli = 1;
            $kullanici->save();

            $rol=$request->rol;
            $unvan=$request->unvan;
            $firma->kullanicilar()->attach($kullanici,['rol_id'=>$rol,'unvan'=>$unvan]);

            $this->sendResetLinkEmail($request);//yeni kullanıcının şifresini belirleyebilmesi için

            DB::commit();
            // all good
        } catch (\Exception $e) {
            $error="error";
            DB::rollback();
            return Response::json($error);
        }
        //return Redirect::to('/kullaniciIslemleri/'.$firma->id);


    }
}
