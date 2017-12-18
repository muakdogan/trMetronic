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




-----------
@extends('layouts.app')
<br>
<br>
<br>
<br>
<br>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$butonString}}</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                        {!! csrf_field() !!}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Adresi</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ $email or old('email') }}"
                                data-validation="email" data-validation-error-msg="Lütfen bu alanı doldurunuz!">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Şifre</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation"
                                data-validation="length" data-validation-error-msg="Şifre en az 6 karakterden oluşmalıdır."
                                data-validation-length="min6">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Şifre Tekrar</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password"
                                data-validation="confirmation" data-validation-error-msg="Şifreyi doğru tekrar ettiğinizden emin olun.">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-refresh"></i>{{$butonString}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        //jquery form validator'ı başlat
        //layouts.app'in <head> içinde include ediliyor
        $.validate({
            modules: 'security'
        });
    })
</script>
@endsection
