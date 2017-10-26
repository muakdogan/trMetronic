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
    <form class="login-form" action="{{url('/password/email')}}" method="post">
        <h3>Şifrenizi hatırlamıyor musunuz?</h3>
        <p> Kayıtlı email adresinizi girerek şifrenizi yeniden belirlemek için bir eposta alabilirsiniz. </p>
        <div class="form-group">
            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
        </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn grey-salsa btn-outline"> Geri </button>
            <button type="submit" class="btn green pull-right"> Şifremi yenile </button>
        </div>
    </form>
  </div>
@endsection
