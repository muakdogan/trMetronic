@extends('layouts.fe.loginAndPassword')
@section('content')
  <!-- BEGIN LOGIN -->
  <div class="content">
    @if (session('activationWarning'))
      <div class="alert alert-warning">
        Hesabınız aktifleştirilmemiş. Lütfen yolladığımız onay email'ını kontrol ediniz.
      </div>
    @elseif ($errors->has('email'))
      <div class="alert alert-danger">{{$errors->first('email')}}</div>
    @elseif ($errors->first('password'))
      <div class="alert alert-danger">{{$errors->first('password')}}</div>
    @endif
      <!-- BEGIN LOGIN FORM -->
      <form class="login-form" method="post" action="{{url('/login') }}">
          {!! csrf_field() !!}
          <h3 class="form-title">Hesap Bilgileriniz</h3>
          <div class="alert alert-danger display-hide">
              <button class="close" data-close="alert"></button>
              <span> Mail adresi ve şifrenizi giriniz. </span>
          </div>
          <div class="form-group">
              <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
              <label class="control-label visible-ie8 visible-ie9">Mail adresi</label>
              <div class="input-icon">
                  <i class="fa fa-user"></i>
                  <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Mail adresi" name="email" required/> </div>
          </div>
          <div class="form-group">
              <label class="control-label visible-ie8 visible-ie9">Şifre</label>
              <div class="input-icon">
                  <i class="fa fa-lock"></i>
                  <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Şifre" name="password" /> </div>
          </div>
          <div class="form-actions">
              <label class="rememberme mt-checkbox mt-checkbox-outline">
                  <input type="checkbox" name="remember" value="1" /> Beni hatırla!
                  <span></span>
              </label>
              <button type="submit" class="btn green pull-right"> Giriş </button>
          </div>
          <!--div class="login-options">
              <h4>Or login with</h4>
              <ul class="social-icons">
                  <li>
                      <a class="facebook" data-original-title="facebook" href="javascript:;"> </a>
                  </li>
                  <li>
                      <a class="twitter" data-original-title="Twitter" href="javascript:;"> </a>
                  </li>
                  <li>
                      <a class="googleplus" data-original-title="Goole Plus" href="javascript:;"> </a>
                  </li>
                  <li>
                      <a class="linkedin" data-original-title="Linkedin" href="javascript:;"> </a>
                  </li>
              </ul>
          </div-->
          <div class="forget-password">
              <h4>Şifrenizi mi unuttunuz ?</h4>
              <p>
                  <a href="{{url('/password/reset')}}" id="forget-password"> Buraya </a> tıklayarak şifre oluşturabilirsiniz. </p>
          </div>
          <div class="create-account">
              <p> Henüz bir hesabınız yok mu ?&nbsp;
                  <a href="{{url('/firmaKayit')}}" id="register-btn"> Hesap Oluştur </a>
              </p>
          </div>
      </form>
  </div>
@endsection
