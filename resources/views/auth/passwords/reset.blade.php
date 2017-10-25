@extends('layouts.fe.loginAndPassword')
@section('content')
  <div class="content">
    @if (session('status'))
      <div class="alert alert-danger">{{ session('status') }}</div>
    @endif
    @if(count($errors) > 0)
        <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        </div>
    @endif
    <form class="login-form" action="{{url('/password/reset')}}" method="post">
        {!! csrf_field() !!}
        <input type="hidden" name="token" value="{{ $token }}">
        <h3>Şifrenizi hatırlamıyor musunuz?</h3>
        <p> Kayıtlı email adresinizi girerek şifrenizi yeniden belirlemek için bir eposta alabilirsiniz. </p>
        <div class="form-group">
            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input class="form-control placeholder-no-fix" type="email" autocomplete="off" placeholder="Email" name="email"
                    data-validation="email" data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Şifre" name="password_confirmation"
                    data-validation="length" data-validation-error-msg="Şifre en az 6 karakterden oluşmalıdır."
                    data-validation-length="min6"/>
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Şifre tekrar" name="password"
                  data-validation="confirmation" data-validation-error-msg="Şifreyi doğru tekrar ettiğinizden emin olun."/>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn grey-salsa btn-outline"> Geri </button>
            <button type="submit" class="btn green pull-right"> {{$butonString}} </button>
        </div>
    </form>
  </div>

@endsection
