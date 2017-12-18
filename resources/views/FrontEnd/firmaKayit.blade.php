@extends('layouts.fe.feMaster')
<!--heade eklemeler-->
@section('head')
  <!-- BEGIN GLOBAL MANDATORY STYLES -->
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
  <link href="{{asset('MetronicFiles/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('MetronicFiles/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('MetronicFiles/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet')}}" type="text/css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
  <!-- END GLOBAL MANDATORY STYLES -->
  <!-- BEGIN THEME GLOBAL STYLES -->
  <link href="{{asset('MetronicFiles/global/css/components.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
  <link href="{{asset('MetronicFiles/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
  <!-- END THEME GLOBAL STYLES -->
  <!-- BEGIN THEME LAYOUT STYLES -->
  <link href="{{asset('MetronicFiles/layouts/layout3/css/layout.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('MetronicFiles/layouts/layout3/css/themes/default.min.css')}}" rel="stylesheet" type="text/css" id="style_color" />
  <link href="{{asset('MetronicFiles/layouts/layout3/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
  <!-- END THEME LAYOUT STYLES -->
  <link href="{{asset('css/multi-select.css')}}" media="screen" rel="stylesheet" type="text/css"></link>
@endsection



<!--content starts-->
@section('content')
    @if (count($errors) > 0)
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <section class="section background-gray-lighter" data-offset="120">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-lg-12 text-center">
            <div class="caption font-purple text-center">
                <span class="caption-subject bold uppercase">Firma Kayıt Formu</span>
            </div>

    <!-- BEGIN SAMPLE FORM PORTLET-->
    <div class="portlet light">
        <div class="portlet-body form">
          {!! Form::open(array('id'=>'firma_kayit','url'=>'form' ,'name'=>'kayit','method' => 'POST','files'=>true, 'class'=>'form-horizontal'))!!}
            <div class="form-body">
              <div class="row">
                  <div class="col-md-6">
                    <h4 class="form-section">Firma Bilgileri</h4>
                    <!-- Firma Adı -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">Firma Adı</label>
                      <div class="col-md-8">
                        {!! Form::text('firma_adi', null,
                                      array('class'=>'form-control',
                                      'placeholder'=>'Firma adı',
                                      'data-validation'=>'length',
                                      'data-validation-length'=>'min1',
                                      'data-validation-error-msg'=>'Lütfen bu alanı doldurunuz!'
                                    ))
                        !!}
                        <span class="help-block" style="color:red"> {{ $errors->first('firma_adi') }}</span>
                      </div>
                    </div>
                    <!-- İletişim Adresi -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">İletişim Adresi</label>
                      <div class="col-md-8">
                        {!! Form::textarea('firma_adres', null,
                            array('id' => 'firma_adres',
                            'class'=>'form-control',
                            'rows'=>'2',
                            'placeholder'=>'İletişim Adresi',
                            'data-validation' => 'required',
                            'data-validation-error-msg' => 'Lutfen bu alanı doldurunuz'
                            ))
                        !!}
                        <span class="help-block" style="color:red"> {{ $errors->first('firma_adres') }}</span>
                      </div>
                    </div>
                    <!-- Şehir -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">İl</label>
                      <div class="col-md-8">
                        <select class="form-control" name="il_id" id="il_id"
                        data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!" value="{{1}}">
                          <option selected disabled>İl Seçiniz</option>
                          @foreach($iller_query as $il)
                            <option value="{{$il->id}}">{{$il->adi}}</option>
                          @endforeach
                        </select>
                        <span class="help-block" style="color:red"> {{ $errors->first('il_id') }}</span>
                      </div>
                    </div>
                    <!-- İlçe -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">İlçe</label>
                      <div class="col-md-8">
                        <select class="form-control"name="ilce_id" id="ilce_id" data-validation="required"
                        data-validation-error-msg="Lütfen bu alanı dolduurnuz!"> <!--value= {{ Request::old('ilce_id') }} -->
                        </select>
                        <span class="help-block" style="color:red"> {{ $errors->first('ilce_id') }}</span>
                      </div>
                    </div>
                    <!-- Semt -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">Semt</label>
                      <div class="col-md-8">
                        <select class="form-control" name="semt_id" id="semt_id"
                        data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                        </select>
                        <span class="help-block" style="color:red"> {{ $errors->first('semt_id') }}</span>
                      </div>
                    </div>
                    <!-- Telefon -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">Telefon</label>
                      <div class="col-md-8">
                        {!! Form::text('telefon', null,
                                      array('id' => 'telefon',
                                      'class'=>'form-control',
                                      'placeholder'=>'Telefon',
                                      'data-validation'=>'length',
                                      'data-validation-length'=>'min15',
                                      'data-validation-error-msg'=>'Lütfen bu alanı doldurunuz!')) !!}
                        <span class="help-block" style="color:red"> {{ $errors->first('telefon') }}</span>
                      </div>
                    </div>
                    <!-- Web Adresi -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">Web Adresi</label>
                      <div class="col-md-8">
                        {!! Form::text('telefon', null,
                                      array('id' => 'web',
                                      'class'=>'form-control',
                                      'placeholder'=>'www.firmam.com',
                                      'data-validation'=>'length',
                                      'data-validation-length'=>'min15',
                                      'data-validation-error-msg'=>'Lütfen bu alanı doldurunuz!')) !!}
                      </div>
                    </div>
                    <!-- Sektörler -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">Firma Sektörleri</label>
                      <div class="col-md-8">
                        <p id ='sektor_count' style='font-size:12px;color:#9055a2;font-weight: bold;'>Lütfen maksimum 5 sektör seçiniz!</p>
                        <select class="form-control deneme" name="sektor_id[]" id="custom-headers" multiple='multiple' value="{{1}}" data-validation = "required" data-validation-error-msg = "Lütfen Sektör Seçiniz">
                          @foreach($sektorler as $sektor)
                            <option  value="{{$sektor->id}}">{{$sektor->adi}}</option>
                          @endforeach
                        </select>
                      <span class="help-block" style="color:red"> {{ $errors->first('sektor_id') }}</span>
                      </div>
                    </div>
                  </div>
                  <!--/span-->
                  <div class="col-md-6">
                    <h4 class="form-section">Fatura Bilgileri</h4>
                    <!--div class="checkbox">
                      <label>
                        <input id="adres_kopyalayici" type="checkbox" name="adres_kopyalayici"> "Firma Adresi" ile "Fatura Adresi" aynı
                      </label>
                        <span class="help-block" style="color:red"> {{ $errors->first('adres_kopyalayici') }}</span>
                    </div-->
                    <!-- İletişim ve Fatura Adresleri Aynı-->
                    <div class="form-group">
                      <label class="col-md-3 control-label">Fatura ve İletişim adresi</label>
                      <div class="col-md-9">
                        <input id="adreslerAyni" type="checkbox" data-off-text="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FARKLI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" data-on-text="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AYNI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" checked="false" class="BSswitch">
                      </div>
                    </div>
                    <!-- Firma Ünvanı -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">Fatura Türü</label>
                      <div class="col-md-9 make-switch">
                        <input id="faturaTuru" name="fatura_tur" type="checkbox" data-off-text="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BİREYSEL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" data-on-text="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;KURUMSAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" checked="false" class="BSswitch">
                      </div>
                      <!--div class="col-md-5">
                        <div class="radio">
                          <label>
                            <input type="radio" name="fatura_tur" id="fatura_tur_kurumsal" value="kurumsal" checked> Kurumsal
                          </label>
                          <label>
                            <input type="radio" name="fatura_tur" id="fatura_tur_bireysel" value="bireysel"> Bireysel
                          </label>
                          <span class="help-block" style="color:red"> {{ $errors->first('fatura_tur') }}</span>
                        </div>
                      </div-->
                    </div>
                    <!-- Firma Ünvanı (Kurumsal)-->
                    <div class="form-group kurumsal">
                      <label class="col-md-3 control-label">Firma Ünvanı</label>
                      <div class="col-md-8">
                        <input type="text" class="form-control input" placeholder="Firma Ünvanı">
                      </div>
                    </div>
                    <!-- Ad Soyad (Bireysel) -->
                    <div class="form-group bireysel" style="display:none;">
                      <label class="col-md-3 control-label">Ad Soyad</label>
                      <div class="col-md-8">
                        {!! Form::text('ad_soyad', null,
                                        array('id' => 'ad_soyad',
                                        'class'=>'form-control',
                                        'placeholder'=>'Adınız ve Soyadınız',
                                        'data-validation' => 'required',
                                        'data-validation-depends-on' =>'fatura_tur',
                                        'data-validation-depends-on-value' => 'bireysel',
                                        'data-validation-error-msg' => 'Lutfen bu alani doldurunuz'
                        )) !!}
                      </div>
                    </div>
                    <!-- Fatura Adresi -->
                    <div class="form-group fatura_adres_group" style="display:none;">
                      <label class="col-md-3 control-label">Fatura Adresi</label>
                      <div class="col-md-8">
                        {!! Form::text('fatura_adres', null,
                                        array('id' => 'fatura_adres',
                                              'class'=>'form-control',
                                              'placeholder'=>'Fatura Adresi',
                                              'data-validation' => 'required',
                                              'data-validation-depends-on' =>'fatura_tur',
                                              'data-validation-error-msg' => 'Lutfen bu alani doldurunuz'
                        )) !!}
                      </div>
                    </div>
                    <!-- Fatura İli -->
                    <div class="form-group fatura_adres_group" style="display:none;">
                      <label class="col-md-3 control-label">İl</label>
                      <div class="col-md-8">
                        <select class="form-control" name="fatura_il_id" id="fatura_il_id"
                        data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"
                        data-validation-depends-on="adres_kopyalayici" data-validation-depends-on-value="off">
                        <option selected disabled>İl Seçiniz</option>
                        @foreach($iller_query as $il)
                          <option value="{{$il->id}}">{{$il->adi}}</option>
                        @endforeach
                      </select>
                      <span class="help-block" style="color:red"> {{ $errors->first('fatura_il_id') }}</span>
                      </div>
                    </div>
                    <!-- Fatura İlçesi -->
                    <div class="form-group fatura_adres_group" style="display:none;">
                      <label class="col-md-3 control-label">İlçe</label>
                      <div class="col-md-8">
                        <select class="form-control" name="fatura_ilce_id" id="fatura_ilce_id"
                        data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"
                        data-validation-depends-on="adres_kopyalayici" data-validation-depends-on-value="off">
                        </select>
                        <span class="help-block" style="color:red"> {{ $errors->first('fatura_ilce_id') }}</span>
                      </div>
                    </div>
                    <!-- Fatura Semti -->
                    <div class="form-group fatura_adres_group" style="display:none;">
                      <label class="col-md-3 control-label">Semt</label>
                      <div class="col-md-8">
                        <select class="form-control" name="fatura_semt_id" id="fatura_semt_id"
                        data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"
                        data-validation-depends-on="adres_kopyalayici" data-validation-depends-on-value="off">
                        </select>
                        <span class="help-block" style="color:red"> {{ $errors->first('fatura_semt_id') }}</span>
                      </div>
                    </div>
                    <!-- Vergi Dairesi -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">Vergi Dairesi</label>
                      <div class="col-md-8">
                        <select class="form-control" name="vergi_daire" id="vergi_daire"
                                data-validation = "required" data-validation-depends-on = "fatura_tur"
                                data-validation-depends-on-value = "kurumsal" data-validation-error-msg = "Lutfen Seciniz">
                        </select>
                        <span class="help-block" style="color:red"> {{ $errors->first('vergi_daire') }}</span>
                      </div>
                    </div>
                    <!-- Vergi No (Kurumsal)-->
                    <div class="form-group kurumsal">
                      <label class="col-md-3 control-label">Vergi No</label>
                      <div class="col-md-8">
                        {!! Form::text('vergi_no', null,
                                  array('id' => 'vergi_no',
                                        'class'=>'form-control',
                                        'placeholder'=>'Vergi No',
                                        'data-toggle' => 'tooltip',
                                        'data-validation' => 'number length',
                                        'data-validation-length' => '10',
                                        'data-validation-depends-on' =>'fatura_tur',
                                        'data-validation-depends-on-value' => 'kurumsal',
                                        'data-validation-error-msg' => 'Lutfen bu alani doldurunuz',
                                        'data-validation-error-msg-length' => 'Lutfen 10 haneli numara giriniz'
                        )) !!}
                      </div>
                    </div>
                    <!-- TC Kimlik (Bireysel)-->
                    <div class="form-group bireysel" style="display:none;">
                      <label class="col-md-3 control-label">TC Kimlik No</label>
                      <div class="col-md-8">
                        {!! Form::text('tc_kimlik', null,
                                        array('id' => 'tc_kimlik',
                                              'class'=>'form-control',
                                              'placeholder'=>'T.C Kimlik Numaraniz',
                                              'maxlength'=>'11',
                                              'data-validation' => 'tc_kimlik_dogrulama number length',
                                              'data-validation-length' => 'min11',
                                              'data-validation-depends-on' =>'fatura_tur',
                                              'data-validation-depends-on-value' => 'bireysel',
                                              'data-validation-error-msg-number' => 'Lutfen sayi giriniz',
                                              'data-validation-error-msg-length' => 'Lutfen 11 haneli sayi giriniz',
                        )) !!}
                      </div>
                    </div>
                  </div>
                  <!--/span-->
              </div>
              <!--/row-->

              <!--/row-->
              <div class="form-group">
                <h4 class="form-section">Kişisel Bilgiler</h4>
                <div class="col-md-6">
                  <!-- Kullanıcı Adı -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">Ad</label>
                    <div class="col-md-8">
                      {!! Form::text('adi', null,
                                    array('class'=>'form-control',
                                    'placeholder'=>'Adınız',
                                    'data-validation'=>'length',
                                    'data-validation-length'=>'min2',
                                    'data-validation-error-msg'=>'Lütfen bu alanı doldurunuz!')
                      ) !!}
                      <span class="help-block" style="color:red"> {{ $errors->first('adi') }}</span>
                      <span class="help-block" style="color:red"> {{ $errors->first('firma_adi') }}</span>
                    </div>
                  </div>
                  <!-- Kullanıcı Soyadı -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">Soyad</label>
                    <div class="col-md-8">
                      {!! Form::text('soyadi', null,
                                    array('class'=>'form-control',
                                    'placeholder'=>'Soyadınız',
                                    'data-validation'=>'length',
                                    'data-validation-length'=>'min2',
                                    'data-validation-error-msg'=>'Lütfen bu alanı doldurunuz!')
                      ) !!}
                      <span class="help-block" style="color:red"> {{ $errors->first('soyadi') }}</span>
                    </div>
                  </div>
                  <!-- Kullanıcı Ünvanı -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">Ünvan</label>
                    <div class="col-md-8">
                      {!! Form::text('unvan', null,
                                    array('class'=>'form-control',
                                    'placeholder'=>'Ünvanınız',
                                    'data-toggle' => 'tooltip',
                                    'data-validation'=>'length',
                                    'data-validation-length'=>'min2',
                                    'data-validation-error-msg'=>'LÜtfen bu alanı doldurunuz!')
                      ) !!}
                      <span class="help-block" style="color:red"> {{ $errors->first('unvan') }}</span>
                    </div>
                  </div>
                  <!-- Kullanıcı Telefonu -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">Telefon</label>
                    <div class="col-md-8">
                      {!! Form::text('telefonkisisel', null,
                                    array('id' => 'telefonkisisel',
                                    'class'=>'form-control',
                                    'placeholder'=>'Telefonunuz',
                                    'data-validation'=>'length',
                                    'data-validation-length'=>'3-17',
                                    'data-validation-error-msg'=>'Lütfen bu alanı doldurunuz!')
                      ) !!}
                      <span class="help-block" style="color:red"> {{ $errors->first('telefonkisisel') }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <!-- Kullanıcı Emailı -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">E-Posta</label>
                    <div class="col-md-8">
                      {!! Form::email('email_giris', null,
                                     array('id'=>'email_giris','class'=>'form-control email',
                                     'placeholder'=>'E-Postanız' ,
                                     'onFocusout'=>'email_girisControl()',
                                     'data-validation'=>'email' ,
                                     'data-validation-error-msg'=>'Lütfen bu alanı doldurunuz!')
                      ) !!}
                      <span class="help-block" id="email_error" style="color:red" onload="findPos()">{{ $errors->first('email_giris') }}</span>
                    </div>
                  </div>
                  <!-- Kullanıcı Pass -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">Şifre</label>
                    <div class="col-md-8">
                      <input type="password" class="form-control" placeholder="******" name="password" id="password" onkeyup="CheckPasswordStrength(this.value)"
                      data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"
                      data-toggle="tooltip" >
                      <span class="help-block" style="color:red"> {{ $errors->first('password') }}</span>
                    </div>
                    <span id="password_strength"></span>
                    <span id="passwordmsg"></span>
                  </div>
                  <!-- Kullanıcı PassTekrar -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">Şifre Onayla</label>
                    <div class="col-md-8">
                      <input type="password" class="form-control" placeholder="******" name="password_confirmation" id="password_confirmation" onkeyup="CheckPasswordStrength(this.value)"
                      data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"
                      data-toggle="tooltip">
                      <span class="help-block" style="color:red"> {{ $errors->first('password_confirmation') }}</span>
                      <span id="confirmMessage" class="confirmMessage"></span>
                    </div>
                  </div>
                  <!-- Gönder Butonu -->
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">Gönder</button>
                  </div>

                </div>


            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
</div>
</section>
</div>
<script src="{{asset('MetronicFiles/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('MetronicFiles/global/scripts/app.min.js')}}" type="text/javascript"></script>
<script src="{{asset('MetronicFiles/pages/scripts/form-input-mask.min.js')}}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="{{asset('js/jquery.multi-select.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('js/jquery.quicksearch.js')}}"></script>
<script src="{{asset('MetronicFiles/pages/scripts/components-bootstrap-switch.min.js')}}" type="text/javascript"></script>
<script>
/*
19.07.2017 Oguzhan
original_state_il   = fatura adresinin il kismini alan form elementinin klonunu tutar
original_state_ilce = fatura adresinin ilce kismini alan form elementinin klonunu tutar.
original_state_semt = fatura adresinin semt kismini alana form elemenetinin klonunu tutar.
*/
var original_state_il;
var original_state_ilce;
var original_state_semt;
$(document).ready(function(){
  $('#telefon').mask('(000) 000-00-00');//jQuery mask plug-in. sirket ve kisisel telefon form'larini maskeler.
  $('#telefonkisisel').mask('(000) 000-00-00');
  original_state_il= $("#fatura_il_id").clone(true);// Cagrilan elementin tam olarak orjinal halini klonlar.
  original_state_ilce = $("#fatura_ilce_id").clone(true);//True paramtresi klonlarken, elemente bagli evenleri de alir.
  original_state_semt = $("#fatura_semt_id").clone(true);


$("#password").tooltip({
  title: "En az 6 karakter uzunlugunda; sayi, harf veya ozel karakter kombinasyonu giriniz.",
  // place tooltip on the right edge
  placement: "right",
  offset: [-2, 10],
  effect: "fade",
  opacity: 0.7
});
$("#unvan").tooltip({
  title: "Sirkette ki pozisyonunuz",
  // place tooltip on the right edge
  placement: "right",
  offset: [-2, 10],
  effect: "fade",
  opacity: 0.7
});
$("#firma_unvan").tooltip({
  title: "Firmanizin adi",
  // place tooltip on the right edge
  placement: "right",
  offset: [-2, 10],
  effect: "fade",
  opacity: 0.7
});
$("#vergi_no").tooltip({
  title: "10 haneli sirket numaraniz.",
  // place tooltip on the right edge
  placement: "right",
  offset: [-2, 10],
  effect: "fade",
  opacity: 0.7
});
$("#vergi_no").tooltip({
  title: "10 haneli sirket numaraniz.",
  // place tooltip on the right edge
  placement: "right",
  offset: [-2, 10],
  effect: "fade",
  opacity: 0.7
});
$("#tc_kimlik").tooltip({
  title: "11 haneli T.C kimlik numaraniz.",
  // place tooltip on the right edge
  placement: "right",
  offset: [-2, 10],
  effect: "fade",
  opacity: 0.7
});


});
// READY PARANTHESIS
$('.BSswitch').bootstrapSwitch('state', true); //Init BSswitch

$('#adreslerAyni').on('switchChange.bootstrapSwitch', function (event, state) {
  if (state === true)
    $(".fatura_adres_group").hide();
  else
    $(".fatura_adres_group").show();
});

$('#faturaTuru').on('switchChange.bootstrapSwitch', function (event, state) {
  if(state === true){
    $('.bireysel').hide();
    $('.kurumsal').show();
  }
  else{
    $('.kurumsal').hide();
    $('.bireysel').show();
  }
  /*
  var form_kurumsal = document.getElementById('div_kurumsal');
  var form_bireysel = document.getElementById('div_bireysel');
  //Kurumsal form aktif degilse aktif eder.
  if(form_kurumsal.style.display === 'none'){
    form_bireysel.style.display = 'none';
    form_kurumsal.style.display = 'block';
  }
  //Bireysel form aktif degilse aktif eder.
  else{
    form_kurumsal.style.display = 'none';
    form_bireysel.style.display = 'block';
  }*/
});

$('#il_id').change(function (e) {
  var il_id = e.target.value;
  $.get("{{asset('ajax-subcat?il_id=')}}"+il_id, function (data) {
  beforeSend:( function(){
      $('.ajax-loader').css("visibility", "visible");
    });
    $('#ilce_id').empty();
    $('#ilce_id').append('<option value="" selected disabled>İlçe Seçiniz</option>');
    $.each(data, function (index, subcatObj) {
      $('#ilce_id').append('<option value="' + subcatObj.id + '">' + subcatObj.adi + '</option>');
    });
  }).done(function(data){
    $('.ajax-loader').css("visibility", "hidden");
  }).fail(function(){
    alert('İller Yüklenemiyor !!!  ');
    console.log("data:");
    console.log(data);
  });
});

$('#ilce_id').on('change', function (e) {
  var ilce_id = e.target.value;
  $.get("{{asset('ajax-subcatt?ilce_id=')}}"+ ilce_id, function (data) {
    beforeSend:( function(){
      $('.ajax-loader').css("visibility", "visible");
    });
    $('#semt_id').empty();
    $('#semt_id').append('<option value="" selected disabled>Semt Seçiniz</option>');
    $.each(data, function (index, subcatObj) {
      $('#semt_id').append('<option value="' + subcatObj.id + '">' + subcatObj.adi + '</option>');
    });
  }).done(function(data){
    $('.ajax-loader').css("visibility", "hidden");
  }).fail(function(){
    alert('İller Yüklenemiyor !!!  ');
  });
});

$('#fatura_il_id').on('change', function (e) {
  var il_id = e.target.value;
  $.get("{{asset('ajax-subcat?il_id=')}}"+il_id, function (data) {
    beforeSend:( function(){
      $('.ajax-loader').css("visibility", "visible");
    });
    $('#fatura_ilce_id').empty();
    $('#fatura_ilce_id').append('<option value="" selected disabled>İlçe Seçiniz</option>');
    $.each(data, function (index, subcatObj) {
      $('#fatura_ilce_id').append('<option value="' + subcatObj.id + '">' + subcatObj.adi + '</option>');
    });
  }).done(function(data){
    $('.ajax-loader').css("visibility", "hidden");
  }).fail(function(){
    alert('İller Yüklenemiyor !!!  ');
  });
  $.get("{{asset('vergi_daireleri?il_id=')}}"+il_id, function (data) {
    beforeSend:( function(){
      $('.ajax-loader').css("visibility", "visible");
    });
    $('#vergi_daire').empty();
    $('#vergi_daire').append('<option value="" selected disabled> Seçiniz </option>');
    $.each(data, function (index, subcatObj) {
      $('#vergi_daire').append('<option value="' + subcatObj.id + '">' + subcatObj.adi + '</option>');
    });
  }).done(function(data){
    $('.ajax-loader').css("visibility", "hidden");
  }).fail(function(){
    alert('Vergi dairesi Yüklenemiyor !!!  ');
  });
});

$('#fatura_ilce_id').on('change', function (e) {
  var ilce_id = e.target.value;
  $.get("{{asset('ajax-subcatt?ilce_id=')}}"+ ilce_id, function (data) {
    beforeSend:( function(){
      $('.ajax-loader').css("visibility", "visible");
    });
    $('#fatura_semt_id').empty();
    $('#fatura_semt_id').append('<option value="" selected disabled>Semt Seçiniz </option>');
    $.each(data, function (index, subcatObj) {
      $('#fatura_semt_id').append('<option value="' + subcatObj.id + '">' + subcatObj.adi + '</option>');
    });
  }).done(function(data){
    $('.ajax-loader').css("visibility", "hidden");
  }).fail(function(){
    alert('İller Yüklenemiyor !!!  ');
  });
});

$('#vergi_daire_il').on('change', function (e) {
  var vergi_daire_il = e.target.value;
  $.get("{{asset('vergi_daireleri?il_id=')}}"+vergi_daire_il, function (data) {
    beforeSend:( function(){
      $('.ajax-loader').css("visibility", "visible");
    });
    $('#vergi_daire').empty();
    $('#vergi_daire').append('<option value="" selected disabled> Seçiniz </option>');
    $.each(data, function (index, subcatObj) {
      $('#vergi_daire').append('<option value="' + subcatObj.id + '">' + subcatObj.adi + '</option>');
    });
  }).done(function(data){
    $('.ajax-loader').css("visibility", "hidden");
  }).fail(function(){
    alert('Vergi dairesi Yüklenemiyor !!!  ');
  });
});

/*
18-19.07.2017 Oguzhan
selection header'a id eklendi.
count_for_header degiskeni eklendi.
afterSelect ve afterDeselect fonksiyonlarinda duzenleme yapildi.
Duzenleme islevi:
Sektorler secilirken Header'da ki degiskeni 1'er 1'er azaltir.
Sektorlerin secimleri kaldirirken de ayni sekilde degiskeni artirir.
count_for_header = Kac tane sektor secme hakki oldugunu tutar.
*/
var count = 0;
var count_for_header = 5;


$('#custom-headers').multiSelect({
  selectableHeader: "</i><input type='text'  class='search-input col-sm-12 search_icon' autocomplete='off' placeholder='Sektör Seçiniz'></input>",
  selectionHeader: "<div class='custom-header'>Seçtiğiniz Sektörler</div>",
  afterInit: function(ms){
    var that = this,
    $selectableSearch = that.$selectableUl.prev(),
    $selectionSearch = that.$selectionUl.prev(),
    selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
    selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';
    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
    .on('keydown', function(e){
      if (e.which === 40){
        that.$selectableUl.focus();
        return false;
      }
    });
  },
  afterSelect: function(values){
    count = $(".ms-selection").find(".ms-selected").length;
    if(count>5){
      $('#custom-headers').multiSelect('deselect', values);
    }
    $("#sektor_count").text(" '"+(5-count)+"' sektör seçebilirsiniz");
    this.qs1.cache();
  },
  afterDeselect: function(values){
    count = $(".ms-selection").find(".ms-selected").length;

    if(count!=5){
      $("#sektor_count").text(" '"+(5-count)+"' sektör daha seçebilirsiniz");
    }
    if(count==0){
      $("#sektor_count").text("Lütfen maksimum 5 sektör seçiniz!");
    }
    this.qs1.cache();
  }
});



function CheckPasswordStrength(password) {
  var password_strength = document.getElementById("password_strength");
  //TextBox left blank.
  if (password.length == 0) {
    password_strength.innerHTML = "";
    return;
  }
  //Regular Expressions.
  var regex = new Array();
  regex.push("[A-Z]"); //Uppercase Alphabet.
  regex.push("[a-z]"); //Lowercase Alphabet.
  regex.push("[0-9]"); //Digit.
  regex.push("[$@$!%*#?&]"); //Special Character.
  var passed = 0;
  var color = "";
  var strength = "";
  //Validate for each Regular Expression.
  for (var i = 0; i < regex.length; i++) {
    if (new RegExp(regex[i]).test(password)) {
      passed++;
    }
  }
  //Validate for length of Password.
  if (passed > 6 && password.length > 12) {
    passed++;
  }
  //Display status.
  switch (passed) {
    case 0:
    case 1:
    strength = "Zayıf";
    color = "red";
    break;
    case 2:
    strength = "İyi";
    color = "darkorange";
    break;
    case 3:
    case 4:
    strength = "Güçlü";
    color = "green";
    break;
    case 5:
    strength = "Çok Güçlü";
    color = "darkgreen";
    break;
  }
  var  password_deneme=$('#password').val().length;
  if(password_deneme<6){
    strength = "Şifre en az 6 karakterden oluşmalıdır işiş";
    color = "red";
  }
  password_strength.innerHTML = strength;
  password_strength.style.color = color;
}
function checkPass()
{
  //Store the password field objects into variables ...
  var password = document.getElementById('password');
  var password_confirmation = document.getElementById('password_confirmation');
  //Store the Confimation Message Object ...
  var message = document.getElementById('confirmMessage');
  //Set the colors we will be using ...
  var goodColor = "#66cc66";
  var badColor = "#ff6666";
  //Compare the values in the password field
  //and the confirmation field
  if(password.value != '' && password.value == password_confirmation.value){//control of empty password value added -Oguzhan
    //The passwords match.
    //Set the color to the good color and inform
    //the user that they have entered the correct password
    password_confirmation.style.backgroundColor = goodColor;
    message.style.color = goodColor;
    message.innerHTML = "Şifre Eşleşti"
  }else if(password.value != ''){//control of empty password value added -Oguzhan
    //The passwords do not match.
    //Set the color to the bad color and
    //notify the user.
    password_confirmation.style.backgroundColor = badColor;
    message.style.color = badColor;
    message.innerHTML = "Şifre Eşleşmedi"
  }
}

$(".sozlesme_kapat").click(function (event){
  event.preventDefault();
  $("#sozlesme_modal").modal('hide');
});

$(".sozlesme_goster").click(function (event){
  event.preventDefault();
  $("#sozlesme_modal").modal('show');
});

/*
Oguzhan Ulucay 18/07/2017
T.C kimlik numarasi icin ozel validation.
T.C kimlik numaralarinin basinda sifir olamaz.
T.C kimlik numaralarinin sonunda tek sayi olamaz.
*/
$.formUtils.addValidator
({
  name : 'tc_kimlik_dogrulama',
  validatorFunction : function(value, $el, config, language, $form) {
    if(value.substr(0,1) == 0)
    return false;
    if(value.substr(10,1)%2 != 0)
    return false;
    else{
      return true;
    }
  },
  errorMessage : 'Lutfen T.C kimlik numaranizi giriniz',
  errorMessageKey: 'Lutfen gecerli T.C Kimlik No giriniz.'
});
$.validate({
  /*modules : 'location, date, security, file, logic',//18.7.17 Logic eklendi. -Oguzhan
  onModulesLoaded : function() {
  $('#country').suggestCountry();
}*/
});
$('#presentation').restrictLength( $('#pres-max-length') );

/*
21.07.2017 Oguzhan
Eklemeler:
Form data serialize edilmeden once maskelemeler kaldirilir daha sonra da
tekrar maskeleme yapilir.
*/


$("#firma_kayit").submit(function(e)
{
  var obj,curtop;
  var json;

  var postData, formURL;
  $('#telefon').unmask();//telefon verilerinin maskesini kaldirir.
  $('#telefonkisisel').unmask();
  postData = $(this).serialize();
  $('#telefon').mask('(000) 000-00-00');//telefon verisini tekrar maskeler
  $('#telefonkisisel').mask('(000) 000-00-00');
  formURL = $(this).attr('action');

  $.ajax(
    {
      beforeSend: function(){

        $('.ajax-loader').css("visibility", "visible");
      },
      url : formURL,
      type: "POST",
      data : postData,
      success:function(data, textStatus, jqXHR)
      {

        $('.ajax-loader').css("visibility", "hidden");
        if(data=="error"){
          $('#mesaj').bPopup({
            speed: 650,
            transition: 'slideIn',
            transitionClose: 'slideBack',
            autoClose: 5000
          });
          setTimeout(function(){ location.href="{{asset('firmaKayit')}}"}, 5000);
        }
        else{
          $('#kayit_msg').bPopup({
            speed: 650,
            transition: 'slideIn',
            transitionClose: 'slideBack',
            autoClose: 5000
          });
          setTimeout(function(){ location.href="{{asset('/')}}"}, 5000);
        }
        e.preventDefault();
      },
      error: function(jqXHR, textStatus, errorThrown)
      {
        console.log(textStatus + "," + errorThrown);
        location.reload();

        window.scroll(0,0);//Kullanıcıların hatasını görebilmesi için sayfa başına yeniliyor.
      }
    });
    e.preventDefault(); //STOP default action
  });

  /*
  Oguzhan Ulucay 13/07/2017
  Fatura bilgileri kayit formu icin script.
  Fonksiyon radio buttonlara tiklanildiginda cagrilir.
  Tiklanilan buttona gore bireysel yada kurumsal
  fatura formlarin display ozelliklerini kapayip acar.
  form_kurumsal = kurumsal fatura form div elementi.
  form_bireysel = bireysel fatura form div elementi.
  */

  /*
  25-26.07.2017 Oguzhan Ulucay
  Sirket adresini form'un altinda yer alan fatura adresini kopyalama scripti.
  Checkbox'a basilmasi hallinde aktif olup yukarida ki ve asagida ki formlarin
  bosluk veya doluluk durumlarini kontrol edip kopyalama islemini gerceklestirir.
  flag_first_adrs_filled = Sirket adresinin tum fieldlarinin dolulugunu tutar.
  flag_second_adrs_empty = Fatura adresinin tum fieldlarinin boslugunu tutar.
  flag_return_original   = Fatura adresinin tum fieldlarinin dolulugunu tutar.
  */

  /*
  Oguzhan Ulucay 18.07.2017
  Tooltips
  */

  var email;
  var email_giris;
  function emailControl(){
    email = $('#email').val();
    emailGet();
  }
  function email_girisControl(){
    email_giris = $('#email_giris').val();
    email_girisGet();
  }
  function email_girisGet(){
    $.ajax({
      type:"GET",
      url:"{{asset('email_girisControl')}}",
      data:{email_giris:email_giris},
      cache: false,
      success: function(data){
        console.log(data);
        if(data==1){
          $('#email2').bPopup({
            speed: 650,
            transition: 'slideIn',
            transitionClose: 'slideBack',
            autoClose: 5000
          });
          $('#email_giris').val("");
        }
      }
    });
  }
  function emailGet(){
    $.ajax({
      type:"GET",
      url:"{{asset('emailControl')}}",
      data:{email:email},
      cache: false,
      success: function(data){
        console.log(data);
        if(data==1){
          $('#email1').bPopup({
            speed: 650,
            transition: 'slideIn',
            transitionClose: 'slideBack',
            autoClose: 5000
          });
          $('#email').val("");
        }
      }
    });
  }
  </script>


@endsection
