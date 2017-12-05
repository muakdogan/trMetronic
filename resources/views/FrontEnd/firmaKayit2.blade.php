@extends('layouts.fe.feMaster')

<!--heade eklemeler-->
@section('head')
  <!-- BEGIN GLOBAL MANDATORY STYLES -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
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
    <section id="biz" class="section background-gray-lighter">
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

                    <!-- İletişim ve Fatura Adresleri Aynı-->
                    <div class="form-group">
                      <label class="col-md-3 control-label">Fatura ve İletişim adresi</label>
                      <div class="col-md-8 make-switch switch-small">
                        <input id="TheCheckBox" type="checkbox" data-off-text="False" data-on-text="True" checked="false" class="BSswitch">
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
<script src="{{asset('js/bootstrap.min.js')}}"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js" type="text/javascript"></script>

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

});
$('.BSswitch').bootstrapSwitch('state', true);
// READY PARANTHESIS

</script>


@endsection
