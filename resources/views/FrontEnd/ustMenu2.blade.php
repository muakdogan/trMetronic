<header class="header">
  <div role="navigation" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header"><a href="{{url('/')}}" class="navbar-brand"><img src={{asset('images/fe/logo_big.png')}} alt="Tamrekabet" class="hidden-xs hidden-sm hidden-md"><img src={{asset('images/fe/logo_small.png')}} alt="Tamrekabet" class="visible-xs visible-sm visible-md" /></a>
        <div class="navbar-buttons">
          <button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle navbar-btn">Menu<i class="pe-7s-menu"></i></button>
        </div>
      </div>
      <div id="navigation" class="collapse navbar-collapse navbar-right">
        <ul class="nav navbar-nav">
          <li><a href="{{url('/#nasil')}}">Nasıl Çalışır</a></li>
          <li><a href="{{url('/')}}" data-id="avantaj">Avantajlarımız</a></li>
          <li><a href="#neler">Neler Var</a></li>
          <li><a href="#biz">Biz Kimiz</a></li>
          <li><a href="#iletisim">İletişim</a></li>
        </ul>
        @if (!Auth::check())
          <a href="{{url('/firmaKayit')}}" class="btn navbar-btn btn-ghost">ÜYE OL</a>
          <a href="{{url('/login')}}" class="btn navbar-btn btn-ghost">ÜYE GİRİŞİ</a>
        @else
          <a href="{{url('/firmaIslemleri')}}" class="btn navbar-btn btn-ghost">FİRMAM</a>
        @endif
      </div>
    </div>
  </div>
</header>
