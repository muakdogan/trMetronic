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

@extends('layouts.app')
<br>
<br>
<!-- Main Content -->
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Şifre Sıfırlama</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                            </div>
                    @endif


                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Adres</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-envelope"></i>Şifremi yenilemek için link gönder.
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
