<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Session;
use Auth;

class UserLoggedIn
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
      $user = Auth::user();

      if (!$user->onayli) {
          //$this->activationFactory->sendActivationMail($user);
          auth()->logout();
          Session::flush();
          return back()->with('activationWarning', true);
      }
      //set the session varibles after login - mete 8May17
      app('request')->session()->put('kullanici_id', $user->id);
      app('request')->session()->put('kullanici_adi', $user->adi . " " . $user->soyadi);
      //birden fazla firma olunca aşağısı değişecek
      $firma_id = $user->firmalar()->first()->id;
      app('request')->session()->put('firma_id', $firma_id);
      app('request')->session()->put('firma_adi', $user->firmalar()->first()->adi);
      app('request')->session()->put('firma_logo', $user->firmalar()->first()->logo);
      $role_id = $user->get_role_id($firma_id);
      app('request')->session()->put('role_id', $user->get_role_id($firma_id));

      //return redirect()->intended($this->redirectPath());
      //return redirect($this->redirectPath());
    }
}
