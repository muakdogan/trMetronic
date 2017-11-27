@extends('layouts.fe.feMaster')
<!--heade eklemeler-->
@section('head')
  <!-- BEGIN GLOBAL MANDATORY STYLES -->
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
  <link href="{{asset('MetronicFiles/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('MetronicFiles/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
  <!--link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" /-->
  <link href="{{asset('MetronicFiles/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
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
    <div class="row">
      <div class="col-md-12">
    <!-- BEGIN SAMPLE FORM PORTLET-->
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-purple">
                <span class="caption-subject bold uppercase"> Firma Kayıt Formu </span>
            </div>
        </div>
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
                        <div class="input-group">
                          <span class="input-group-addon input-circle-left">
                            <i class="fa fa-briefcase"></i>
                          </span>
                          <input type="text" class="form-control input-circle-right" placeholder="Firma Adı">
                        </div>
                      </div>
                    </div>
                    <!-- Sektörler -->
                    <!--
                    <div class="form-group">
                      <label class="col-md-3 control-label">Sektörler</label>
                      <div class="col-md-8">
                        <select class="form-control deneme" name="sektor_id[]" id="custom-headers" multiple="multiple" value="{{1}}">
                          @foreach ($sektorler as $sektor)
                            <option value="{{$sektor->id}}">{{$sektor->adi}}</option>
                          @endforeach
                      </div>
                    </div>-->
                    <!-- Telefon -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">Telefon</label>
                      <div class="col-md-8">

                          <input type="text" class="form-control" id="mask_phone">
                          <span class="help-block"> (999) 999-9999 </span>

                      </div>
                    </div>
                    <!-- Web Adresi -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">Web Adresi</label>
                      <div class="col-md-8">
                        <div class="input-group">
                          <span class="input-group-addon input-circle-left">
                            <i class="fa fa-desktop"></i>
                          </span>
                          <input type="text" class="form-control input-circle-right" placeholder="www.firmam.com">
                        </div>
                      </div>
                    </div>
                    <!-- Şehir -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">Şehir</label>
                      <div class="col-md-8">
                        <input type="text" class="form-control input-circle" placeholder="Enter text">
                      </div>
                    </div>
                    <!-- İlçe -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">İlçe</label>
                      <div class="col-md-8">
                        <input type="text" class="form-control input-circle" placeholder="Enter text">
                      </div>
                    </div>
                    <!-- Semt -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">Semt</label>
                      <div class="col-md-8">
                        <input type="text" class="form-control input-circle" placeholder="Enter text">
                      </div>
                    </div>
                    <!-- İletişim Adresi -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">İletişim Adresi</label>
                      <div class="col-md-8">
                        <div class="input-group">
                          <span class="input-group-addon input-circle-left">
                            <i class="fa fa-envelope-o"></i>
                          </span>
                          <input type="text" class="form-control input-circle-right" placeholder="İletişim Adresi">
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--/span-->
                  <div class="col-md-6">
                    <h4 class="form-section">Fatura Bilgileri</h4>
                    <!-- Firma Ünvanı -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">Firma Ünvanı</label>
                      <div class="col-md-8">
                        <div class="input-group">
                          <span class="input-group-addon input-circle-left">
                            <i class="fa fa-newspaper-o"></i>
                          </span>
                          <input type="text" class="form-control input-circle-right" placeholder="Firma Ünvanı">
                        </div>
                      </div>
                    </div>
                    <!-- Fatura Adresi -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">Fatura Adresi</label>
                      <div class="col-md-8">
                        <div class="input-group">
                          <span class="input-group-addon input-circle-left">
                            <i class="fa fa-envelope-o"></i>
                          </span>
                          <input type="text" class="form-control input-circle-right" placeholder="Fatura Adresi">
                        </div>
                      </div>
                    </div>
                    <!-- İl -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">İl</label>
                      <div class="col-md-8">
                        <input type="text" class="form-control input-circle" placeholder="Enter text">
                      </div>
                    </div>
                    <!-- İlçe -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">İlçe</label>
                      <div class="col-md-8">
                        <input type="text" class="form-control input-circle" placeholder="Enter text">
                      </div>
                    </div>
                    <!-- Semt -->
                    <div class="form-group">
                      <label class="col-md-3 control-label">Semt</label>
                      <div class="col-md-8">
                        <input type="text" class="form-control input-circle" placeholder="Enter text">
                      </div>
                    </div>
                  </div>
                  </div>
                  <!--/span-->
              </div>
              <!--/row-->

              <!--/row-->
              <div class="form-group">
                <label>Firma Adı</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-briefcase" aria-hidden="true"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Firma Adı">
                  </div>
              </div>
              <div class="form-group">
                  <label>Circle Input</label>
                  <div class="input-group">
                      <span class="input-group-addon input-circle-left">
                          <i class="fa fa-envelope"></i>
                      </span>
                      {!! Form::text('firma_adi', null,
                                    array('class'=>'form-control',
                                    'placeholder'=>'Firma adı',
                                    'data-validation'=>'length',
                                    'data-validation-length'=>'min1',
                                    'data-validation-error-msg'=>'Lütfen bu alanı doldurunuz!')) !!}
                      <span class="help-block" style="color:red"> {{ $errors->first('firma_adi') }}</span>
                      <!--input type="text" class="form-control input-circle-right" placeholder="Email Address"-->
                  </div>
              </div>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
</div>
<script src="{{asset('MetronicFiles/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('MetronicFiles/global/scripts/app.min.js')}}" type="text/javascript"></script>
<script src="{{asset('MetronicFiles/pages/scripts/form-input-mask.min.js')}}" type="text/javascript"></script>
  @endsection
