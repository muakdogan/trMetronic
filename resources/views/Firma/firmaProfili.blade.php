<?php use Barryvdh\Debugbar\Facade as Debugbar; ?>
@extends('layouts.appUser')

@section('baslik')Firma Profilim @endsection

@section('aciklama')Bu sayfayı sadece firma sahipleri görüntüleyebilir!@endsection

@section('head')
<script src="//cdn.ckeditor.com/4.5.10/basic/ckeditor.js"></script>
<link href="{{asset('css/multi-select.css')}}" media="screen" rel="stylesheet" type="text/css"></link>
<link href="{{asset('css/multiple-select.css')}}" rel="stylesheet"/>
<style>
    .wrapper {
        padding: 25px;
    }
    .image-wrapper {
        padding: 5px;
    }
    .image-wrapper img {
        max-width:200px;
        height:200px;
    }
    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 18px;
        margin-top: 8px;
    }
    .switch input {display:none;}
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 20px;
        left: 0px;
        bottom: 2px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }
    input:checked + .slider {
        background-color: #2196F3;
    }
    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }
    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }
    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }
    .slider.round:before {
        border-radius: 50%;
    }
    .test + .tooltip > .tooltip-inner {
        background-color: #73AD21;
        color: #FFFFFF;
        border: 1px solid green;
        padding: 10px;
        font-size: 12px;
    }
    .test + .tooltip.bottom > .tooltip-arrow {
        border-bottom: 5px solid green;
    }
</style>
<link href="{{asset('MetronicFiles/pages/css/profile.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script src="{{asset('js/jquery.multi-select.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('js/jquery.quicksearch.js')}}"></script>
    <script src="{{asset('js/multiple-select.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="col-md-6">
                    <!-- BEGIN PROFIL -->
                    <div class="portlet light profile-sidebar-portlet ">
                        <!-- SIDEBAR USERPIC -->
                        <div class="profile-userpic">
                            @if($firma->logo != "")
                                <img id="logo1" src="{{asset('uploads')}}/{{$firma->logo}}" alt="Firma Logo" class="img-responsive">
                            @else
                                <img id="logo1" src="{{asset('uploads/logo/defaultFirmaLogo.png')}}" alt="Firma Logo" class="img-responsive">
                            @endif
                        </div>
                        <!-- END SIDEBAR USERPIC -->

                        <!-- SIDEBAR BUTTONS -->
                        <div class="profile-userbuttons">
                            <button id="btn-add-image" value="{{$firma->id}}" type="button" class="btn btn-circle red btn-sm">Düzenle</button>
                        </div>
                        <!-- END SIDEBAR BUTTONS -->

                        <div class="modal fade" id="myModal-image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Firma Logonu Güncelle</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="span7 offset1">
                                            {!! Form::open(array('url'=>'firmaProfili/uploadImage/'.$firma->id,'method'=>'POST', 'files'=>true)) !!}
                                            <div class="control-group">
                                                <div class="controls">
                                                    <div class="container-fuild">
                                                        <div class="row">
                                                            <div class="col-sm-4" >
                                                                <div class="secure"><strong>Mevcut Logonuz</strong></div>
                                                                <br>
                                                                <div style="width:128px;height:128px;"class="image-wrapper">
                                                                    @if($firma->logo != "")
                                                                        <img src="{{asset('uploads')}}/{{$firma->logo}}" alt="Firma Logo" style="width:128px;height:128px;">
                                                                    @else
                                                                        <img src="{{asset('uploads/logo/defaultFirmaLogo.png')}}" alt="Firma Logo" style="width:128px;height:128px;">
                                                                        Henüz Logonuz Yok!
                                                                    @endif

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-8" >
                                                                <div class="secure"><strong>Logonuzu Değiştirin</strong></div>
                                                                <div class="wrapper">
                                                                    {!! Form::file('logo', ['id' => 'addImage']) !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <p class="errors">{!!$errors->first('image')!!}</p>
                                                        @if(Session::has('error'))
                                                            <p class="errors">{!! Session::get('error') !!}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div id="success">
                                                </div>
                                                {!! Form::submit('Logo Yükle', array('url'=>'firmaProfili/uploadImage'.$firma->id,'style'=>'float:right','class'=>'btn btn-danger')) !!}
                                                {!! Form::close() !!}
                                                @if($firma->logo != "")
                                                    {{ Form::open(array('url'=>'firmaProfili/deleteImage/'.$firma->id,'method' => 'DELETE', 'files'=>true)) }}
                                                    {{ Form::hidden('id', $firma->logo) }}
                                                    {{ Form::submit('Logo Sil', ['style'=>'float:right' ,'class' => 'btn btn-danger']) }}
                                                    {{ Form::close() }}
                                                @endif
                                                <br>
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SIDEBAR USER TITLE -->
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name"> {{$firma->adi}} </div>
                        </div>
                        <!-- END SIDEBAR USER TITLE -->

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <h4 class="profile-desc-title" style="text-align: center;">Sektörler</h4>
                                <ul>
                                    @foreach($firmaSektorleri as $firmaSektor)
                                        <li style="border-bottom:1px solid #f0f4f7">{{$firmaSektor->adi}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-6 col-sm-6">

                                <div class="caption caption-md">
                                    <h4 class="profile-desc-title" style="text-align: center;">Profil Doluluk</h4>
                                </div>
                                <div class="easy-pie-chart">
                                    <div class="number transactions" data-percent="{{$firma->doluluk_orani}}">
                                        %<span>{{$firma->doluluk_orani}}</span></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="profile-usermenu">
                        </div>
                    </div>
                    <!-- END PROFIL -->
                    <!-- BEGIN TANITIM -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="fa fa-pencil theme-font"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Tanıtım Yazısı</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <label id="btn-add-tanitimyazisi" class="btn btn-transparent grey-salsa btn-circle btn-sm active">
                                        <input type="radio" name="options" class="toggle" id="option1">Düzenle</label>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            @if($firma->tanitim_yazisi=="")
                                <span class="profile-desc-text">Henüz tanıtım yazısı eklenmemiş.</span>
                            @else
                                <span class="profile-desc-text">{{$firma->tanitim_yazisi}}</span>
                            @endif
                        </div>
                        <div class="modal fade" id="myModal-tanitimyazisi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title" id="myModalLabel"><img src="{{asset('images/arrow.png')}}">&nbsp;<strong>Firma Tanıtım Yazısı</strong></h4>
                                    </div>
                                    {!! Form::open(array('id'=>'tanitim_kayit','url'=>'firmaProfili/tanitim/'.$firma->id,'method'=>'POST', 'files'=>true)) !!}
                                    <div class="modal-body">
                                        <textarea id="tanitim_yazisi" name="tanitim_yazisi" rows="5" class="form-control ckeditor"  placeholder="{{$firma->tanitim_yazisi}}" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">{{$firma->tanitim_yazisi}}</textarea>
                                    </div>
                                    <div class="modal-footer">
                                        {!! Form::submit('Kaydet', array('url'=>'firmaProfili/tanitim/'.$firma->id,'style'=>'float:right','class'=>'btn btn-danger')) !!}
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END TANITIM -->
                    <!-- BEGIN MALI BILGILER -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-calculator theme-font"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Mali Bilgiler</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <label id="btn-add-malibilgiler" onclick="populateMaliDD()" class="btn btn-transparent grey-salsa btn-circle btn-sm active">
                                        <input type="radio" name="options" class="toggle" id="option1">Düzenle</label>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <?php
                            if (!$firma->mali_bilgiler) {
                                $mali_bilgi = "boş";
                                $checkboxCiro = 1;
                                $checkboxSermaye =1;
                                $firma->mali_bilgiler = new App\MaliBilgi();
                            }
                            else{
                                $mali_bilgi="dolu";
                                $checkboxCiro=$firma->mali_bilgiler->ciro_goster;
                                $checkboxSermaye=$firma->mali_bilgiler->sermaye_goster;
                            }
                            ?>

                            @if($firma->mali_bilgiler->firma_id==0)
                                <span class="profile-desc-text">Henüz mali bilgiler eklenmemiş.</span>
                            @else
                            <div class="table-scrollable table-scrollable-borderless">
                                <table class="table table-light">
                                    <tr>
                                        <td><strong>Firma Ünvanı</strong></td>
                                        <td>:
                                            {{$firma->mali_bilgiler->unvani}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Şirket Türü</strong></td>
                                        <td>
                                        @foreach($sirketTurleri as $sirket)
                                            @if($sirket->id == $firma->sirket_turu)
                                                : {{$sirket->adi}}
                                            @endif
                                        @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Fatura Adresi</strong></td>
                                        <td>:
                                            {{$firmaFatura->adres}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>İli</strong></td>
                                        <td>:
                                            {{$firmaFatura->iller->adi}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>İlçesi</strong></td>
                                        <td>:
                                            {{$firmaFatura->ilceler->adi}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Vergi Dairesi</strong></td>
                                        <td>:
                                            {{$firma->mali_bilgiler->vergi_daireleri->adi}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Vergi Numarası</strong></td>
                                        <td>:
                                            {{$firma->mali_bilgiler->vergi_numarasi}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Yıllık Cirosu</strong></td>
                                        <td>:
                                            {{$firma->mali_bilgiler->yillik_cirosu}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Sermayesi</strong></td>
                                        <td>:
                                            {{$firma->mali_bilgiler->sermayesi}}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            @endif
                        </div>
                        <div class="modal fade" id="myModal-malibilgiler" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title" id="myModalLabel"><img src="{{asset('images/arrow.png')}}">&nbsp;<strong>Mali Bilgiler</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(array('id'=>'mali_kayit','url'=>'firmaProfili/malibilgi/'.$firma->id,'class'=>'form-horizontal','method'=>'POST', 'files'=>true)) !!}
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-3 control-label">Fatura Adresi</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="fatura_adresi" name="fatura_adresi" placeholder="Fatura Adresi" value="{{$firmaFatura->adres}}" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                            </div>
                                        </div>
                                        <div class="form-group error">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputTask" class="col-sm-3 control-label">İl</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <select class="form-control il_id"  name="mali_il_id" id="mali_il_id" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                                    <option selected disabled>Seçiniz</option>
                                                    @foreach($iller as $il)
                                                        <option  value="{{$il->id}}" >{{$il->adi}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group error">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputTask" class="col-sm-3 control-label">İlçe</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <select class="form-control" name="mali_ilce_id" id="mali_ilce_id" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                                    <option selected disabled>Seçiniz</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-3 control-label">Firma Ünvanı</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="unvani" name="unvani" placeholder="Firma Ünvanı" value="{{$firma->mali_bilgiler->unvani}}" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-3 control-label">Şirket Türü</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <select class="form-control" name="sirket_turu" id="sirket_turu" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                                    <option selected disabled>Seçiniz</option>
                                                    @foreach($sirketTurleri as $tur)
                                                        <option  value="{{$tur->id}}" >{{$tur->adi}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-3 control-label">Vergi Dairesi</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <select class="form-control" name="vergi_dairesi_id" id="vergi_dairesi_id" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                                    <option selected disabled>Seçiniz</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputTask" class="col-sm-3 control-label">Vergi Numarası</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="vergi_numarasi" name="vergi_numarasi" placeholder="Vergi Numarası" value="{{$firma->mali_bilgiler->vergi_numarasi}}" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-3 control-label">Yıllık Ciro</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <select class="form-control" name="yillik_cirosu" id="yillik_cirosu" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                                    <option selected disabled>Seçiniz</option>
                                                    <option  value="0-300.000" >0-300.000</option>
                                                    <option  value="300.001-1.000.000" >300.001-1.000.000</option>
                                                    <option  value="1.000.001-8.000.000" >1.000.001-8.000.000</option>
                                                    <option  value="8.000.001-40.000.000" >8.000.001-40.000.000</option>
                                                    <option  value="40.000.000 ve üzeri" >40.000.000 ve üzeri</option>
                                                </select>
                                                <label>Gösterme</label>
                                                <label class="switch" style="margin-bottom: -5px;">
                                                    <input type="checkbox" id="ciro_goster" name="ciro_goster" value="1" checked>
                                                    <div class="slider round"></div>
                                                </label>
                                                <label>Göster</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-3 control-label">Sermayesi</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="sermayesi" name="sermayesi" placeholder="Sermayesi" value="{{$firma->mali_bilgiler->sermayesi}}" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
                                                <label>Gösterme</label>
                                                <label class="switch" style="margin-bottom: -5px;">
                                                    <input type="checkbox" id="sermaye_goster" name="sermaye_goster" value="1" checked>
                                                    <div class="slider round"></div>
                                                </label>
                                                <label>Göster</label>
                                            </div>
                                        </div>
                                        {!! Form::submit('Kaydet', array('url'=>'firmaProfili/malibilgi/'.$firma->id,'style'=>'float:right','class'=>'btn btn-danger')) !!}
                                        <br>
                                        <br>
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- END MALIBILGILER -->
                    <!-- BEGIN TICARI BILGILER -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-share theme-font"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Ticari Bilgiler</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <label id="btn-add-ticaribilgiler" onclick="populateTicaretDD()"  class="btn btn-transparent grey-salsa btn-circle btn-sm active">
                                        <input type="radio" name="options" class="toggle" id="option1">Düzenle</label>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable table-scrollable-borderless">
                                <table class="table table-light">
                                    <tr>
                                        <td><strong>Ticaret Sicil No</strong></td>
                                        <td>:
                                            {{$firma->ticari_bilgiler->tic_sicil_no}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Ticaret Odası</strong></td>
                                        <td>:
                                            {{$firma->ticari_bilgiler->ticaret_odalari->adi}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Faaliyet Türü</strong></td>
                                        <td>:
                                            @foreach($firma->faaliyetler as $faaliyet)
                                                {{$faaliyet->adi}}
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Üst Sektör</strong></td>
                                        <td>:
                                            {{$firma->getUstSektor()}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Faaliyet Gösterilen Sektörler</strong></td>
                                        <td>:
                                            @foreach($firma->sektorler as $sektor)
                                                {{$sektor->adi}}
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kuruluş Tarihi</strong></td>
                                        <td>:
                                            @if($firma->kurulus_tarihi != null)
                                                {{$firma->kurulus_tarihi}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Firmanın Ürettiği Markalar</strong></td>
                                        <td>:
                                            @foreach($uretilenMarka as $marka)
                                                {{$marka->adi}}
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Firmanın Sattığı Markalar</strong></td>
                                        <td>:
                                            @if(count($satilanMarka) > 1)
                                                @foreach($satilanMarka as $satMarka)
                                                    {{$satMarka->satilan_marka_adi}}
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="modal fade" id="myModal-ticaribilgiler" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title" id="myModalLabel"><img src="{{asset('images/arrow.png')}}">&nbsp;<strong>Ticari Bilgiler</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(array('id'=>'ticari_kayit','url'=>'firmaProfili/ticaribilgi/'.$firma->id,'class'=>'form-horizontal','method'=>'POST', 'files'=>true)) !!}
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-4 control-label">Ticaret Sicil NO</label>
                                            <label for="inputTask" style="text-align: left"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="ticaret_sicil_no" name="ticaret_sicil_no" placeholder="Ticaret Sicil No" value="{{$firma->ticari_bilgiler->tic_sicil_no}}" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-4 control-label">Ticaret Odası</label>
                                            <label for="inputTask" style="text-align: left"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="ticaret_odasi" id="ticaret_odasi" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                                    <option selected disabled>Seçiniz</option>
                                                    @foreach($ticaretodasi as $ticaret)
                                                        <option  value="{{$ticaret->id}}" >{{$ticaret->adi}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-4 control-label">Faaliyet Türü</label>
                                            <label for="inputTask" style="text-align: left"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-6">
                                                @foreach($faaliyetler as $faaliyet)
                                                    <input type="checkbox" class="firma_faaliyet_turu" id="firma_faaliyet_turu" name="firma_faaliyet_turu[]" value="{{$faaliyet->id}}"  data-validation="checkbox_group" data-validation-qty="min1" data-validation-error-msg="En az bir tanesini seçiniz!">{{$faaliyet->adi}}
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-4 control-label">Üst Sektör</label>
                                            <label for="inputTask" style="text-align: left"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="ust_sektor" id="ust_sektor" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                                    <option selected disabled>Seçiniz</option>
                                                    <option  value="1" >Sanayi</option>
                                                    <option  value="2" >Tarım</option>
                                                    <option  value="3" >Hizmet</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-4 control-label">Faaliyet Gösterilen Sektörler</label>
                                            <label for="inputTask" style="text-align: left"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-6">
                                                <select class="form-control deneme"   name="faaliyet_sektorleri[]" id="custom-headers" multiple='multiple' >
                                                    <?php $sektorler=DB::table('sektorler')->orderBy('adi','ASC')->get();  ?>
                                                    @foreach($ustsektor as $sektor)
                                                        <option  value="{{$sektor->id}}" >{{$sektor->adi}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-4 control-label">Kuruluş Tarihi</label>
                                            <label for="inputTask" style="text-align: left"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control date" id="kurulus_tarihi" name="kurulus_tarihi" placeholder="Kuruluş Tarihi" value="{{$firma->kurulus_tarihi}}" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                            </div>
                                        </div>
                                        <div class="form-group" id="uretilenDiv">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-4 control-label">Üretilen Markalar</label>
                                            <label for="inputTask" style="text-align: left"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-6">
                                                <div class="input_fields_wrap">
                                                    <button  class="add_field_button btn btn-danger">Ekle</button>
                                                    @foreach($uretilenMarka as $markas)
                                                        <div><input type="text" id="firmanin_urettigi_markalar" name="firmanin_urettigi_markalar[]"  value="{{$markas->adi}}" data-validation-error-msg="Lütfen bu alanı doldurunuz!"><a href="#" class="remove_field">Sil</a></div>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="sattigiDiv">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-4 control-label">Firmanın Sattığı Markalari</label>
                                            <label for="inputTask" style="text-align: left"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-6">
                                                <div class="input_fields_sattigi_wrap">
                                                    <button  class="add_field_sattigi_button btn btn-danger">Ekle</button>
                                                    @foreach($satilanMarka as $markaSatilan)
                                                        <div><input type="text" id="firmanin_sattigi_markalar"  name="firmanin_sattigi_markalar[]" value="{{$markaSatilan->adi}}" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!" ><a href="#" class="remove_field">Sil</a></div>
                                                        <?php Debugbar::info($markaSatilan); ?>
                                                    @endforeach
                                                    <div><input type="text" id="firmanin_sattigi_markalar"  name="firmanin_sattigi_markalar[]" value="" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!" ><a href="#" class="remove_field">Sil</a></div>
                                                </div>
                                            </div>
                                        </div>
                                        {!! Form::submit('Kaydet', array('url'=>'firmaProfili/ticaribilgi/'.$firma->id,'style'=>'float:right','class'=>'btn btn-danger')) !!}
                                        <br>
                                        <br>
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- END TICARI BILGILER -->
                    <!-- BEGIN BILGILENDIRME TERCIHI -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-info theme-font"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Bilgilendirme Tercihi</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <label id="btn-add-bilgilendirmetercihi" class="btn btn-transparent grey-salsa btn-circle btn-sm active">
                                        <input type="radio" name="options" class="toggle" id="option1">Düzenle</label>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <span class="profile-desc-text">
                                <input type="checkbox" class="bilgilendirmeOnTaraf"  id="bilgilendirme_tercihi" name="bilgilendirme_tercihi[]" value="Sms" disabled/> Sms <br>
                                <input type="checkbox" class="bilgilendirmeOnTaraf" id="bilgilendirme_tercihi" name="bilgilendirme_tercihi[]" value="Mail" disabled/> Mail <br>
                                <input type="checkbox" class="bilgilendirmeOnTaraf" id="bilgilendirme_tercihi" name="bilgilendirme_tercihi[]" value="Telefon" disabled/> Telefon <br>
                                <input type="checkbox" class="bilgilendirmeOnTaraf" id="bilgilendirme_tercihi" name="bilgilendirme_tercihi[]" value="Bilgilendirme İstemiyorum" disabled/> Bilgilendirme İstemiyorum
                            </span>
                        </div>
                        <div class="modal fade" id="myModal-bilgilendirmetercihi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title" id="myModalLabel"><img src="{{asset('images/arrow.png')}}">&nbsp;<strong>Bilgilendirilme Tercihi</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(array('id'=>'bilgilendirme_kayit','url'=>'firmaProfili/bilgilendirmeTercihi/'.$firma->id,'class'=>'form-horizontal','method'=>'POST', 'files'=>true)) !!}

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-4 control-label">Bilgilendirilme Tercihi</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                @if($firma->sms)
                                                    <input type="checkbox" class="bilgilendirme"  id="bilgilendirme_tercihi" name="bilgilendirme_tercihi[]" data-validation="checkbox_group" value="Sms" data-validation-qty="min1" data-validation-error-msg="Lütfen bu alanı doldurunuz!" checked/>Sms <br>
                                                @else
                                                    <input type="checkbox" class="bilgilendirme"  id="bilgilendirme_tercihi" name="bilgilendirme_tercihi[]" data-validation="checkbox_group" value="Sms" data-validation-qty="min1" data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>Sms <br>
                                                @endif
                                                @if($firma->mail)
                                                    <input type="checkbox" class="bilgilendirme" id="bilgilendirme_tercihi" name="bilgilendirme_tercihi[]" data-validation="checkbox_group" value="Mail" data-validation-qty="min1" data-validation-error-msg="Lütfen bu alanı doldurunuz!" checked/>Mail <br>
                                                @else
                                                    <input type="checkbox" class="bilgilendirme" id="bilgilendirme_tercihi" name="bilgilendirme_tercihi[]" data-validation="checkbox_group" value="Mail" data-validation-qty="min1" data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>Mail <br>
                                                @endif
                                                @if($firma->telefon)
                                                    <input type="checkbox" class="bilgilendirme" id="bilgilendirme_tercihi" name="bilgilendirme_tercihi[]" data-validation="checkbox_group" value="Telefon" data-validation-qty="min1" data-validation-error-msg="Lütfen bu alanı doldurunuz!" checked/>Telefon <br>
                                                @else
                                                    <input type="checkbox" class="bilgilendirme" id="bilgilendirme_tercihi" name="bilgilendirme_tercihi[]" data-validation="checkbox_group" value="Telefon" data-validation-qty="min1" data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>Telefon <br>
                                                @endif
                                                @if(!$firma->sms && !$firma->mail && !$firma->telefon)
                                                    <input type="checkbox" class="bilgilendirme" id="bilgilendirme_tercihi" name="bilgilendirme_tercihi[]" data-validation="checkbox_group" value="Bilgilendirme İstemiyorum" data-validation-qty="min1" data-validation-error-msg="Lütfen bu alanı doldurunuz!" checked/>Bilgilendirme İstemiyorum
                                                @else
                                                    <input type="checkbox" class="bilgilendirme" id="bilgilendirme_tercihi" name="bilgilendirme_tercihi[]" data-validation="checkbox_group" value="Bilgilendirme İstemiyorum" data-validation-qty="min1" data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>Bilgilendirme İstemiyorum
                                                @endif
                                            </div>
                                        </div>
                                        {!! Form::submit('Kaydet', array('url'=>'firmaProfili/bilgilendirmeTercihi/'.$firma->id,'style'=>'float:right','class'=>'btn btn-danger')) !!}
                                        <br>
                                        <br>
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- END BILGILENDIRME TERCIHI -->
                </div>
                <div class="col-md-6">
                    <!-- BEGIN ILETISIM BILGILERI -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="fa fa-phone theme-font"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">İletişim Bilgileri</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <label id="btn-add" onclick="populateDD()" class="btn btn-transparent grey-salsa btn-circle btn-sm active">
                                        <input type="radio" name="options" class="toggle" id="option1">Düzenle</label>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable table-scrollable-borderless">
                                <table class="table table-light">
                                    <tr>
                                        <td><strong>Adres</strong></td>
                                        <td>:
                                            {{$firmaAdres->adres}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>İl</strong></td>
                                        <td>:
                                            {{$firmaAdres->iller->adi}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>İlçe</strong></td>
                                        <td>:
                                            {{$firmaAdres->ilceler->adi}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Semt</strong></td>
                                        <td>:
                                            {{$firmaAdres->semtler->adi}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Telefon</strong></td>
                                        <td>:
                                            {{$firma->iletisim_bilgileri->telefon}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Fax</strong></td>
                                        <td>:
                                            {{$firma->iletisim_bilgileri->fax}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Web Sitesi</strong></td>
                                        <td>:
                                            {{$firma->iletisim_bilgileri->web_sayfasi}}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title" id="myModalLabel"><img src="{{asset('images/arrow.png')}}">&nbsp;<strong>İletişim Bilgileri</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(array('id'=>'iletisim_kayit','url'=>'firmaProfili/iletisimAdd/'.$firma->id, 'class' => 'form-horizontal', 'method' => 'POST')) !!}

                                        <div class="form-group error">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputTask" class="col-sm-3 control-label">Şehir</label>
                                            <label for="inputTask" style="text-align: left"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <select class="form-control il_id" name="il_id" id="il_id" data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                                    <option selected disabled>Seçiniz</option>
                                                    @foreach($iller as $il)
                                                        <option  value="{{$il->id}}" >{{$il->adi}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group error">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputTask" class="col-sm-3 control-label">İlçe</label>
                                            <label for="inputTask" style="text-align: left" class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <select class="form-control" name="ilce_id" id="ilce_id" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                                    <option selected disabled>Seçiniz</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group error">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputTask" class="col-sm-3 control-label">Semt</label>
                                            <label for="inputTask" style="text-align: left" class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <select class="form-control" name="semt_id" id="semt_id" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                                    <option selected disabled>Seçiniz</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-3 control-label">Adres</label>
                                            <label for="inputTask"style="text-align: left" class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="adres" name="adres" placeholder="Adres" value="{{$firmaAdres->adres}}" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-3 control-label">Telefon</label>
                                            <label for="inputTask" style="text-align: left" class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="telefon" name="telefon" placeholder="Telefon" value="{{$firma->iletisim_bilgileri->telefon}}" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-3 control-label">Fax</label>
                                            <label for="inputTask" style="text-align: left" class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="fax" name="fax" placeholder="Fax" value="{{$firma->iletisim_bilgileri->fax}}" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-3 control-label">Web Sayfası</label>
                                            <label for="inputTask" style="text-align: left" class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="web_sayfasi" name="web_sayfasi" placeholder="Web Sayfası" value="{{$firma->iletisim_bilgileri->web_sayfasi}}" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                            </div>
                                        </div>
                                        {!! Form::submit('Kaydet', array('url'=>'firmaProfili/iletisimAdd/'.$firma->id,'style'=>'float:right','class'=>'btn btn-danger')) !!}
                                        <br>
                                        <br>
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" id="iletisimbilgisi_id" name="iletisimbilgisi_id" value="{{$firma->iletisim_bilgileri->id}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END ILETISIM BILGILERI -->
                    <!-- BEGIN FIRMA BROSURU -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-picture theme-font"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Firma Broşürü</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <label id="btn-add-firmabrosurEkle" class="btn btn-transparent grey-salsa btn-circle btn-sm active">
                                        <input type="radio" name="options" class="toggle" id="option1">Ekle</label>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="portlet-body">
                                @if($brosur==null)
                                    <span class="profile-desc-text"> Henüz broşür eklenmemiş. </span>
                                @else
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-light">
                                        <tr>
                                        <th>Broşür Adı:</th>
                                        <th>Broşür Pdf:</th>
                                            <th></th>
                                        </tr>
                                        @foreach($firma->firma_brosurler as $firmaBrosur)
                                            <tr>
                                                <td>
                                                    {{$firmaBrosur->adi}}
                                                </td>
                                                <td>
                                                    <a  data-toggle="tooltip" title="PDF'i görüntülemek için tıklayınız!" target="_blank" href="{{ asset('brosur/'.$firmaBrosur->yolu) }}"><img src="{{asset('images/see.png')}}">{{$firmaBrosur->yolu}}</a>
                                                </td>
                                                <td>
                                                    <button value="{{$firmaBrosur->id}}" class="btn btn-default btn-xs open-modal-brosurGuncelle" >Düzenle</button>
                                                    <div class="modal fade" id="myModal-firmabrosurGuncelle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                    <h4 class="modal-title" id="myModalLabel"><img src="{{asset('images/arrow.png')}}">&nbsp;<strong>Firma Broşürü</strong></h4>
                                                                </div>
                                                                {!! Form::open(array('id'=>'brosur_up_kayit','url'=>'firmaProfili/firmaBrosurGuncelle/'.$firmaBrosur->id,'class'=>'form-horizontal','method'=>'POST', 'files'=>true)) !!}
                                                                <div class="modal-body">
                                                                    Broşür Adı:
                                                                    <input type="text" class="form-control" name="brosur_adi" value="{{$firmaBrosur->adi}}" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                                                    <input type="hidden" name="brosur_id" value="{{$firmaBrosur->id}}">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    {!! Form::submit('Kaydet', array('url'=>'firmaProfili/firmaBrosurGuncelle/'.$firmaBrosur->id,'style'=>'float:right','class'=>'btn btn-danger')) !!}
                                                                </div>
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{ Form::open(array('url'=>'firmaProfili/brosurSil/'.$firmaBrosur->id,'method' => 'DELETE', 'files'=>true)) }}
                                                    <input type="hidden" name="firma_id"  id="firma_id" value="{{$firma->id}}">
                                                    {{ Form::submit('Sil', ['class' => 'btn btn-default btn-xs']) }}
                                                    {{ Form::close() }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal fade" id="myModal-firmabrosurEkle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title" id="myModalLabel"><img src="{{asset('images/arrow.png')}}">&nbsp;<strong>Firma Broşürü</strong></h4>
                                    </div>
                                    {!! Form::open(array('id'=>'brosur_kayit','url'=>'firmaProfili/firmaBrosur/'.$firma->id,'class'=>'form-horizontal','method'=>'POST', 'files'=>true)) !!}
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-3 control-label">Broşür Adı</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control " id="brosur_adi" name="brosur_adi" placeholder="Broşür Adi" value="" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-3 control-label">Broşür Dosyası</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <div class="control-group">
                                                    <div class="controls">
                                                        {!! Form::file('yolu',array('data-validation'=>'required', 'data-validation-error-msg'=>'Lütfen bu alanı doldurunuz!')) !!}
                                                        <p class="errors">{!!$errors->first('image')!!}</p>
                                                        @if(Session::has('error'))
                                                            <p class="errors">{!! Session::get('error') !!}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div id="success">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        {!! Form::submit('Kaydet', array('url'=>'firmaProfili/firmaBrosur/'.$firma->id,'style'=>'float:right','class'=>'btn btn-danger')) !!}
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- END FIRMA BROSURU -->
                    <!-- BEGIN IDARI BILGILER -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-directions theme-font"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">İdari Bilgiler</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <label id="btn-add-firmacalisanbilgileri" class="btn btn-transparent grey-salsa btn-circle btn-sm active">
                                        <input type="radio" name="options" class="toggle" id="option1">Düzenle</label>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            @if($calisan==null)
                                <span class="profile-desc-text">Henüz idari bilgiler eklenmemiş.</span>
                            @else
                            <div class="table-scrollable table-scrollable-borderless">
                                <table class="table table-light">
                                    <tr>
                                        <td><strong>Çalışma Günleri</strong></td>
                                        <td>:
                                            {{$calismaGunu}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Çalışma Saatleri</strong></td>
                                        <td>:
                                            {{$firma->firma_calisma_bilgileri->calisma_saatleri}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Çalışan Profili</strong></td>
                                        <td>:
                                            <?php $calisan_profili = $firma->getCalisanProfil(); ?>
                                            {{$calisan_profili}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Çalışan Sayısı</strong></td>
                                        <td>:
                                            {{$firma->firma_calisma_bilgileri->calisan_sayisi}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Firma Departmanları</strong></td>
                                        <td>:
                                            @foreach($firma->departmanlar as $departman)
                                                {{$departman->adi}}
                                            @endforeach
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            @endif
                        </div>

                        <div class="modal fade" id="myModal-firmacalisanbilgileri" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title" id="myModalLabel"><img src="{{asset('images/arrow.png')}}">&nbsp;<strong>İdari Bilgiler</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(array('id'=>'calisma_kayit','url'=>'firmaProfili/firmaCalisan/'.$firma->id,'class'=>'form-horizontal','method'=>'POST', 'files'=>true)) !!}

                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-3 control-label">Çalışma Günleri</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <select class="form-control" name="calisma_gunleri" id="calisma_gunleri" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                                    <option selected disabled>Seçiniz</option>
                                                    @foreach($calisma_günleri as $günleri)
                                                        <option  value="{{$günleri->id}}">{{$günleri->adi}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-3 control-label">Çalışma Saatleri</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control " id="calisma_saatleri" name="calisma_saatleri" placeholder="Çalışma Saatleri" value="{{$firma->firma_calisma_bilgileri->calisma_saatleri}}" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-3 control-label">Çalışan Profili</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                @if($calisan_profili == 'Beyaz Yaka')
                                                    <input type="checkbox" class="firma_calisan " name="firma_calisma_profili[]" value="1" data-validation="checkbox_group"  data-validation-error-msg="Lütfen birini seçiniz!"  data-validation-qty="min1"/>Mavi Yaka
                                                    <input type="checkbox" class="firma_calisan "  name="firma_calisma_profili[]" value="2" data-validation="checkbox_group" data-validation-error-msg="Lütfen birini seçiniz!"  data-validation-qty="min1" checked/>Beyaz Yaka
                                                @elseif($calisan_profili == 'Mavi Yaka')
                                                    <input type="checkbox" class="firma_calisan " name="firma_calisma_profili[]" value="1" data-validation="checkbox_group"  data-validation-error-msg="Lütfen birini seçiniz!"  data-validation-qty="min1" checked/>Mavi Yaka
                                                    <input type="checkbox" class="firma_calisan "  name="firma_calisma_profili[]" value="2" data-validation="checkbox_group" data-validation-error-msg="Lütfen birini seçiniz!"  data-validation-qty="min1"/>Beyaz Yaka
                                                @else
                                                    <input type="checkbox" class="firma_calisan " name="firma_calisma_profili[]" value="1" data-validation="checkbox_group"  data-validation-error-msg="Lütfen birini seçiniz!"  data-validation-qty="min1" checked/>Mavi Yaka
                                                    <input type="checkbox" class="firma_calisan "  name="firma_calisma_profili[]" value="2" data-validation="checkbox_group" data-validation-error-msg="Lütfen birini seçiniz!"  data-validation-qty="min1" checked/>Beyaz Yaka
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-3 control-label">Çalışan Sayısı</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control " id="calisma_sayisi" name="calisma_sayisi" placeholder="Çalışan Sayısı" value="{{$firma->firma_calisma_bilgileri->calisan_sayisi}}" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-3 control-label">Firma Departmanları</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-6">
                                                <select id="firma_departmanlari"   name="firma_departmanları[]" multiple="multiple">
                                                    @foreach($departmanlar as $departman)
                                                        <option data-toggle="tooltip" data-placement="bottom" title="{{$departman->adi}}" value="{{$departman->id}}">{{$departman->adi}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {!! Form::submit('Kaydet', array('url'=>'firmaProfili/firmaCalisan/'.$firma->id,'style'=>'float:right','class'=>'btn btn-danger')) !!}
                                        <br>
                                        <br>
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- END IDARI BILGILER -->
                    <!-- BEGIN KALITE BELGELERI -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-graph theme-font"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Kalite Belgeleri</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <label id="btn-add-kalite" class="btn btn-transparent grey-salsa btn-circle btn-sm active">
                                        <input type="radio" name="options" class="toggle" id="option1">Ekle</label>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            @if($kaliteBelge==null)
                                <span class="profile-desc-text">Henüz kalite belgesi eklenmemiş.</span>
                            @else
                                <div class="table-scrollable table-scrollable-borderless">
                                    <table class="table table-light">
                                        <tr>
                                            <th>Kalite Belgesi:</th>
                                            <th>Belge NO:</th>
                                            <th></th>
                                        </tr>
                                        @foreach($firma->kalite_belgeleri as $kalite_belgesi)
                                            <tr>
                                                <td id="kalite_id_td">
                                                    {{$kalite_belgesi->adi}}
                                                </td>
                                                <td>
                                                    {{$kalite_belgesi->pivot->belge_no}}
                                                </td>
                                                <td>
                                                    <button name="open-modal-kaliteGuncelle" value="{{$kalite_belgesi->id}}" class="btn btn-default btn-xs open-modal-kaliteGuncelle">Düzenle</button>

                                                    {{ Form::open(array('url'=>'firmaProfili/kaliteSil/'.$kalite_belgesi->id,'method' => 'DELETE')) }}
                                                    <input type="hidden" name="firma_id"  id="firma_id" value="{{$firma->id}}">
                                                    <input type="hidden" name="belge_no" value="{{$kalite_belgesi->pivot->belge_no}}">
                                                    {{ Form::submit('Sil', ['class' => 'btn btn-default btn-xs']) }}
                                                    {{ Form::close() }}
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="myModal-kaliteGuncelle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                            <h4 class="modal-title" id="myModalLabel"><img src="{{asset('images/arrow.png')}}">&nbsp;<strong>Kalite Belgeleri</strong> </h4>
                                                        </div>
                                                        {!! Form::open(array('id'=>'kalite_up_kayit','url'=>'firmaProfili/kaliteGuncelle/'.$firma->id,'class'=>'form-horizontal','method'=>'POST', 'files'=>true)) !!}
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="inputTask" class="col-sm-1 control-label"></label>
                                                                <label for="inputEmail3" class="col-sm-3 control-label">Kalite Belgesi</label>
                                                                <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                                                <div class="col-sm-7">
                                                                    <select class="form-control" name="kalite_belgeleri" id="kalite_belgeleri" required>
                                                                        <option selected disabled>Seçiniz</option>
                                                                        @foreach($kalite_belgeleri as $kalite)
                                                                            <option  value="{{$kalite->id}}">{{$kalite->adi}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="inputTask" class="col-sm-1 control-label"></label>
                                                                <label for="inputEmail3" class="col-sm-3 control-label">Belge No</label>
                                                                <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                                                <div class="col-sm-7">
                                                                    <input type="text" class="form-control " id="belge_no" name="belge_no" placeholder="Belge No" value="{{$kalite_belgesi->pivot->belge_no}}" required/>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <br>
                                                            <input type="hidden" name="kalite_id"  id="kalite_id" value="{{$kalite_belgesi->id}}">
                                                            <input type="hidden" name="firma_id" value="{{$firma->id}}">
                                                            <input type="hidden" name="eski_belge_no" value="{{$kalite_belgesi->pivot->belge_no}}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            {!! Form::submit('Kaydet', array('url'=>'firmaProfili/kaliteGuncelle/'.$firma->id,'style'=>'float:right','class'=>'btn btn-danger')) !!}

                                                        </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </table>
                                </div>
                            @endif
                        </div>
                        <div class="modal fade" id="myModal-kalite" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title" id="myModalLabel"><img src="{{asset('images/arrow.png')}}">&nbsp;<strong>Kalite Belgeleri</strong> </h4>
                                    </div>
                                    {!! Form::open(array('id'=>'kalite_add_kayit','url'=>'firmaProfili/kalite/'.$firma->id,'class'=>'form-horizontal','method'=>'POST', 'files'=>true)) !!}
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-3 control-label">Kalite Belgesi</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <select class="form-control" name="kalite_belgeleri" id="kalite_belgeleri" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                                    <option selected disabled>Seçiniz</option>
                                                    @foreach($kalite_belgeleri as $kalite)
                                                        <option  value="{{$kalite->id}}">{{$kalite->adi}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTask" class="col-sm-1 control-label"></label>
                                            <label for="inputEmail3" class="col-sm-3 control-label">Belge No</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control " id="belge_no" name="belge_no" placeholder="Belge No" value="" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        {!! Form::submit('Kaydet', array('url'=>'firmaProfili/kalite/'.$firma->id,'style'=>'float:right','class'=>'btn btn-danger')) !!}
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END KALITE BELGELERI -->
                    <!-- BEGIN REFERANSLAR -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-like theme-font"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Referanslar</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <label id="btn-add-referanslar" class="btn btn-transparent grey-salsa btn-circle btn-sm active">
                                        <input type="radio" name="options" class="toggle" id="option1">Ekle</label>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                        @if($referans==null)
                            <span class="profile-desc-text">Henüz referans eklenmemiş.</span>
                        @else
                        @foreach($firmaReferanslar as $firmaReferans)
                                <!-- BEGIN Tekil Referans-->
                                <div class="portlet light bg-inverse">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-like theme-font"></i>
                                            <span class="caption-subject font-blue-madison uppercase"> {{$firmaReferans->adi}} </span>
                                        </div>
                                        <div class="tools">
                                            Detaylar <a href="javascript:;" class="expand" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body portlet-collapsed">
                                        <table class="table table-light">
                                            <tr>
                                                <td><strong>Firma Adı</strong></td>
                                                <td>:
                                                    {{$firmaReferans->adi}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Yapılan İşin Adı</strong></td>
                                                <td>:
                                                    {{$firmaReferans->is_adi}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>İşin Türü</strong></td>
                                                <td>:
                                                    {{$firmaReferans->is_turu}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Çalişma Süresi</strong></td>
                                                <td>:
                                                    {{$firmaReferans->calisma_suresi}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Yetkili Kişi Adı</strong></td>
                                                <td>:
                                                    {{$firmaReferans->yetkili_adi}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Yetkili Kişi Email Adresi</strong></td>
                                                <td>:
                                                    {{$firmaReferans->yetkili_email}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Yetkili Kişi Telefon</strong></td>
                                                <td>:
                                                    {{$firmaReferans->yetkili_telefon}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Referans Türü</strong></td>
                                                <td>:
                                                    {{$firmaReferans->ref_turu}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>İşin Yılı</strong></td>
                                                <td>:
                                                    @if($firmaReferans->is_yili != "0000-00-00")
                                                        {{$firmaReferans->is_yili}}
                                                    @endif
                                                </td>
                                            </tr>
                                            <td></td>
                                            <td><button name="open-modal-gecmis"  value="{{$firmaReferans->id}}" class="btn btn-default btn-xs open-modal-gecmis" >Düzenle</button>
                                                {{ Form::open(array('url'=>'firmaProfili/referansSil/'.$firmaReferans->id,'method' => 'DELETE', 'files'=>true))}}
                                                <input type="hidden" name="firma_id"  id="firma_id" value="{{$firma->id}}">
                                                {{ Form::submit('Sil', ['class' => 'btn btn-default btn-xs'])}}
                                                {{ Form::close()}}
                                            </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal fade" id="myModal-referanslarGecmis" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title" id="myModalLabel"><img src="{{asset('images/arrow.png')}}">&nbsp;<strong>Referanslar</strong> </h4>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open(array('id'=>'ref_up_kayit','url'=>'firmaProfili/referansUpdate/'. $firmaReferans->id,'class'=>'form-horizontal','method'=>'POST', 'files'=>true)) !!}

                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Referans Türü</label>
                                                        <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control" name="ref_turu" id="ref_turu" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                                                <option selected disabled value="Seçiniz">Seçiniz</option>
                                                                <option   value="Geçmiş">Geçmiş</option>
                                                                <option  value="Şuan">Şuan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputTask" class="col-sm-1 control-label"></label>
                                                        <label for="inputEmail3" class="col-sm-3 control-label">Firma Adı</label>
                                                        <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control " id="ref_firma_adi" name="ref_firma_adi" placeholder="Firma Adı" value="" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputTask" class="col-sm-1 control-label"></label>
                                                        <label for="inputEmail3" class="col-sm-3 control-label">Yapılan İşin Adı</label>
                                                        <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control " id="yapilan_isin_adi" name="yapılan_isin_adi" placeholder="Yapılan İşin Adı" value="" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputTask" class="col-sm-1 control-label"></label>
                                                        <label for="inputEmail3" class="col-sm-3 control-label">İşin Türü</label>
                                                        <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                                        <div class="col-sm-7">
                                                            <select class="form-control" name="isin_turu" id="isin_turu" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                                                <option selected disabled value="Seçiniz">Seçiniz</option>
                                                                <option   value="Mal Satışı">Mal Satışı</option>
                                                                <option  value="Hizmet Satışı">Hizmet Satışı</option>
                                                                <option  value="Yapım İşi">Yapım İşi</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputTask" class="col-sm-1 control-label"></label>
                                                        <label for="inputEmail3" class="col-sm-3 control-label">İşin Yılı</label>
                                                        <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control " id="is_yili" name="is_yili" placeholder="İş Yılı" value="" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputTask" class="col-sm-1 control-label"></label>
                                                        <label for="inputEmail3" class="col-sm-3 control-label">Çalışma Süresi</label>
                                                        <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control " id="calısma_suresi" name="calısma_suresi" placeholder="Çalışma Süresi" value="" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputTask" class="col-sm-1 control-label"></label>
                                                        <label for="inputEmail3" class="col-sm-3 control-label">Yetkili Kişi Adı</label>
                                                        <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control " id="yetkili_kisi_adi" name="yetkili_kisi_adi" placeholder="Yetkili Kişi Adı" value="" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputTask" class="col-sm-1 control-label"></label>
                                                        <label for="inputEmail3" class="col-sm-3 control-label">Y.K Email Adresi</label>
                                                        <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                                        <div class="col-sm-7">
                                                            <input type="email" class="form-control " id="yetkili_kisi_email" name="yetkili_kisi_email" placeholder="Yetkili Kişi Email Adresi" value="" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputTask" class="col-sm-1 control-label"></label>
                                                        <label for="inputEmail3" class="col-sm-3 control-label">Y.K Telefon</label>
                                                        <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control " id="yetkili_kisi_telefon" name="yetkili_kisi_telefon" placeholder="Yetkili Kişi Telefon" value="" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="ref_id"  id="ref_id" value="{{$firmaReferans->id}}">

                                                    {!! Form::submit('Kaydet', array('url'=>'firmaProfili/referansUpdate/'. $firmaReferans->id,'style'=>'float:right','class'=>'btn btn-danger')) !!}
                                                    <br>
                                                    <br>
                                                    {!! Form::close() !!}
                                                </div>
                                                <div class="modal-footer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Tekil Referans-->
                        @endforeach
                        @endif

                        </div>
                        <div class="modal fade" id="myModal-referanslar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title" id="myModalLabel"><img src="{{asset('images/arrow.png')}}">&nbsp;<strong>Referanslar</strong> </h4>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(array('id'=>'ref_add_kayit','url'=>'firmaProfili/referans/'.$firma->id,'class'=>'form-horizontal','method'=>'POST', 'files'=>true)) !!}

                                        <div class="form-group">

                                            <label for="inputTask" class="col-sm-4 control-label">Referans Türü</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <select class="form-control" name="ref_turu" id="ref_turu" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                                    <option selected disabled value="Seçiniz">Seçiniz</option>
                                                    <option   value="Geçmiş">Geçmiş</option>
                                                    <option  value="Şuan">Şuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <label for="inputTask" class="col-sm-4 control-label">Firma Adı</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control " id="ref_firma_adi" name="ref_firma_adi" placeholder="Firma Adı" value="" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <label for="inputEmail3" class="col-sm-4 control-label">Yapım İşi Adı</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control " id="yapilan_isin_adi" name="yapılan_isin_adi" placeholder="Yapılan İşin Adı" value="" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <label for="inputEmail3" class="col-sm-4 control-label">İşin Türü</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <select class="form-control" name="isin_turu" id="isin_turu" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                                    <option selected disabled value="Seçiniz">Seçiniz</option>
                                                    <option   value="Mal Satışı">Mal Satışı</option>
                                                    <option  value="Hizmet Satışı">Hizmet Satışı</option>
                                                    <option  value="Yapım İşi">Yapım İşi</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <label for="inputEmail3" class="col-sm-4 control-label">İş Yılı</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control " id="is_yili" name="is_yili" placeholder="İş Yılı" value="" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-4 control-label">Çalışma Süresi</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control " id="calısma_suresi" name="calısma_suresi" placeholder="Çalışma Süresi" value="" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-4 control-label">Yetkili Kişi Adı</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control " id="yetkili_kisi_adi" name="yetkili_kisi_adi" placeholder="Yetkili Kişi Adı" value="" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-4 control-label">Yetkili Kişi Email Adresi</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <input type="email" class="form-control " id="yetkili_kisi_email" name="yetkili_kisi_email" placeholder="Yetkili Kişi Email Adresi" value="" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-4 control-label">Yetkili Kişi Telefon</label>
                                            <label for="inputTask" style="text-align: right"class="col-sm-1 control-label">:</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control " id="yetkili_kisi_telefon" name="yetkili_kisi_telefon" placeholder="Yetkili Kişi Telefon" value="" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!"/>
                                            </div>
                                        </div>

                                        {!! Form::submit('Kaydet', array('url'=>'firmaProfili/referans/'.$firma->id,'style'=>'float:right','class'=>'btn btn-danger')) !!}
                                        <br>
                                        <br>

                                        {!! Form::close() !!}
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END REFERANSLAR -->
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>

   <script src="{{asset('js/selectDD.js')}}"></script>
   <script src="{{asset('js/jquery.bpopup-0.11.0.min.js')}}"></script>
<script>
    $("#firma_departmanlari").multipleSelect({
            width: 260,
            multiple: true,
            multipleWidth: 100
    });
    var count = 0;
    $('#custom-headers').multiSelect({
        selectableHeader: "</i><input type='text'  class='search-input col-sm-12 search_icon' autocomplete='off' placeholder='Sektör Seçiniz'></input>",
        selectionHeader: "<p style='font-size:12px;color:red'>Max 5 sektör</p>",
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
          count++;
          if(count>5){
              $('#custom-headers').multiSelect('deselect', values);
          }
          this.qs1.cache();
          this.qs2.cache();
        },
        afterDeselect: function(){
          count--;
          this.qs1.cache();
          this.qs2.cache();
        }
    });
    /////////////Bilgilendirme Checkbox buton kontrolü
    $('.bilgilendirme').click(function(){
        jQuery('.bilgilendirme').each(function(){
            $(this).attr("disabled",false);
        });
        jQuery('.bilgilendirme:checked').each(function(){
            if($(this).val() == "Bilgilendirme İstemiyorum"){
                jQuery('.bilgilendirme').each(function(){
                    if($(this).val() != "Bilgilendirme İstemiyorum"){
                        $(this).prop("checked",false);
                        $(this).attr("disabled",true);
                    }
                });
            }
        });
    });
    var kontrol=0;
    jQuery('.bilgilendirmeOnTaraf').each(function(){
        if($(this).val() == "Sms"){
            if("{{$firma->sms}}" == "1"){
                $(this).prop("checked",true);
                kontrol=1;
            }
            else{
                $(this).prop("checked",false);
            }
        }
        else if($(this).val() == "Mail"){
            if("{{$firma->mail}}" == "1"){
                $(this).prop("checked",true);
                kontrol=1;
            }
            else{
                $(this).prop("checked",false);
            }
        }
        else if($(this).val() == "Telefon"){
            if("{{$firma->telefon}}" == "1"){
                $(this).prop("checked",true);
                kontrol=1;
            }
            else{
                $(this).prop("checked",false);
            }
        }
        else{
            if(kontrol == 0){
                $(this).prop("checked",true);
            }
        }
    });
  $.validate({
    modules : 'location, date, security, file',
    onModulesLoaded : function() {
      $('#country').suggestCountry();
    }
  });
  jQuery('.firma_faaliyet_turu').each(function(){
      <?php foreach ($firma->faaliyetler as $flyt){ ?>
              var falyAdi = "{{$flyt->id}}";
          if($(this).val() == falyAdi){
              $(this).prop("checked",true);
            }
      <?php } ?>
   });
  $('.firma_faaliyet_turu').click(function(){ ///////////faaliyet turu /////////////////
        var sonSecilen;
        var count=0;
        jQuery('.firma_faaliyet_turu:checked').each(function(){
            sonSecilen = $(this).val();
            count++;
        });
        if(count == 1){
            if(sonSecilen == 1){
                $('#sattigiDiv').hide();
            }
            else{
                $('#uretilenDiv').hide();
            }
        }else{
            $('#sattigiDiv').show();
            $('#uretilenDiv').show();
        }
    });
  $('#presentation').restrictLength( $('#pres-max-length') );
    $(document).ready(function() {
        CKEDITOR.config.autoParagraph = false;
         /*$.fn.datepicker.dates['tr'] = {
            days: ["Pazar", "Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi", "Pazar"],
            daysShort: ["Pz", "Pzt", "Sal", "Çrş", "Prş", "Cu", "Cts", "Pz"],
            daysMin: ["Pz", "Pzt", "Sa", "Çr", "Pr", "Cu", "Ct", "Pz"],
            months: ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
            monthsShort: ["Oca", "Şub", "Mar", "Nis", "May", "Haz", "Tem", "Ağu", "Eyl", "Eki", "Kas", "Ara"],
            today: "Bugün"
	        };
        $('.datepicker').datepicker({
            language: 'tr'
        });
        var date_input=$('input[class="form-control date"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'yyyy',
            language:"tr",
            viewMode:"years",
            minViewMode:"years",
            container: container,
            weekStart:1,
            todayHighlight: true,
            autoclose: true
        });
*/
        $("#calisma_gunleri").val({{$firma->firma_calisma_bilgileri->calisma_gunleri_id}});
        $("#ust_sektor").val({{$firma->ticari_bilgiler->ust_sektor}});
        $('[data-toggle="tooltip"]').tooltip();
        var arrayDepartman = new Array();
        <?php foreach($firma->departmanlar as $departman){ ?>
             arrayDepartman.push({{$departman->id}});
        <?php } ?>
        $("#firma_departmanlari").multipleSelect("setSelects", arrayDepartman);
        var max_fields      = 10; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div><input type="text" name="firmanin_urettigi_markalar[]"/><a href="#" class="remove_field">Sil</a></div>'); //add input box
            }
        });
        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').remove(); x--;
        });
        var s=1;
        var wrapper_sattigi         = $(".input_fields_sattigi_wrap"); //Fields wrapper
        var add_button_sattigi      = $(".add_field_sattigi_button"); //Add button ID
        $(add_button_sattigi).click(function(e){ //on add input button click
            e.preventDefault();
            if(s < max_fields){ //max input box allowed
                s++; //text box increment
                $(wrapper_sattigi).append('<div><input type="text" name="firmanin_sattigi_markalar[]"/><a href="#" class="remove_field">Sil</a></div>'); //add input box
            }
        });
        $(wrapper_sattigi).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').remove(); x--;
        });
        $('.il_id').on('change', function (e) {
            var il_id = e.target.value;
            GetIlce(il_id,e.target.id);
            GetVergi(il_id);
            //popDropDown('ilce_id', 'ajax-subcat?il_id=', il_id);
            //$("#semt_id")[0].selectedIndex=0;
        });
        $('#ilce_id').on('change', function (e) {
            var ilce_id = e.target.value;
            GetSemt(ilce_id);
            //popDropDown('semt_id', 'ajax-subcatt?ilce_id=', ilce_id);
        });
        dolulukForm();
    });
    function GetIlce(il_id,Id) {
        if (il_id > 0) {
            if(Id == "il_id"){
                $("#ilce_id").get(0).options.length = 0;
                $("#ilce_id").get(0).options[0] = new Option("Yükleniyor", "-1");
            }
            else{
                $("#mali_ilce_id").get(0).options.length = 0;
                $("#mali_ilce_id").get(0).options[0] = new Option("Yükleniyor", "-1");
            }
            $.ajax({
                type: "GET",
                url: "{{asset('ajax-subcat')}}",
                data:{il_id:il_id},
                contentType: "application/json; charset=utf-8",
                success: function(msg) {
                    if(Id == "il_id"){
                        $("#ilce_id").get(0).options.length = 0;
                        $("#ilce_id").get(0).options[0] = new Option("Seçiniz", "-1");
                    }else{
                        $("#mali_ilce_id").get(0).options.length = 0;
                        $("#mali_ilce_id").get(0).options[0] = new Option("Seçiniz", "-1");
                    }
                    $.each(msg, function(index, ilce) {
                        if(Id == "il_id"){
                            $("#ilce_id").get(0).options[$("#ilce_id").get(0).options.length] = new Option(ilce.adi, ilce.id);
                        }
                        else{
                            $("#mali_ilce_id").get(0).options[$("#mali_ilce_id").get(0).options.length] = new Option(ilce.adi, ilce.id);
                        }
                    });
                },
                async: false,
                error: function() {
                    if(Id == "il_id"){
                        $("#ilce_id").get(0).options.length = 0;
                    }
                    else{
                        $("#mali_ilce_id").get(0).options.length = 0;
                    }
                    alert("İlçeler yükelenemedi!!!");
                }
            });
        }
        else {
            if(Id == "il_id"){
                $("#ilce_id").get(0).options.length = 0;
            }
            else{
                $("#mali_ilce_id").get(0).options.length = 0;
            }
        }
    }
    function GetSemt(ilce_id) {
        if (ilce_id > 0) {
            $("#semt_id").get(0).options.length = 0;
            $("#semt_id").get(0).options[0] = new Option("Yükleniyor", "-1");
            $.ajax({
                type: "GET",
                url: "{{asset('ajax-subcatt?ilce_id=')}}"+ilce_id,
                contentType: "application/json; charset=utf-8",
                success: function(msg) {
                    $("#semt_id").get(0).options.length = 0;
                    $("#semt_id").get(0).options[0] = new Option("Seçiniz", "-1");
                    $.each(msg, function(index, semt) {
                        $("#semt_id").get(0).options[$("#semt_id").get(0).options.length] = new Option(semt.adi, semt.id);
                    });
                },
                async: false,
                error: function() {
                    $("#semt_id").get(0).options.length = 0;
                    alert("Semtler yükelenemedi!!!");
                }
            });
        }
        else {
            $("#semt_id").get(0).options.length = 0;
        }
    }
    function GetTicaret(il_id) {
        if (il_id > 0) {
            $("#ticaret_odasi").get(0).options.length = 0;
            $("#ticaret_odasi").get(0).options[0] = new Option("Yükleniyor", "-1");
            $.ajax({
                type: "GET",
                url: "{{asset('ticaret_odalari')}}",
                data:{il_id:il_id},
                contentType: "application/json; charset=utf-8",
                success: function(msg) {
                    $("#ticaret_odasi").get(0).options.length = 0;
                    $("#ticaret_odasi").get(0).options[0] = new Option("Seçiniz", "-1");
                    $.each(msg, function(index, ticaret) {
                        $("#ticaret_odasi").get(0).options[$("#ticaret_odasi").get(0).options.length] = new Option(ticaret.adi, ticaret.id);
                    });
                },
                async: false,
                error: function() {
                    $("#ticaret_odasi").get(0).options.length = 0;
                    alert("Vergi Daireleri yükelenemedi!!!");
                }
            });
        }
        else {
            $("#ticaret_odasi").get(0).options.length = 0;
        }
    }
    function GetVergi(il_id) {
        if (il_id > 0) {
            $("#vergi_dairesi_id").get(0).options.length = 0;
            $("#vergi_dairesi_id").get(0).options[0] = new Option("Yükleniyor", "-1");
            $.ajax({
                type: "GET",
                url: "{{asset('vergi_daireleri')}}",
                data:{il_id:il_id},
                contentType: "application/json; charset=utf-8",
                success: function(msg) {
                    $("#vergi_dairesi_id").get(0).options.length = 0;
                    $("#vergi_dairesi_id").get(0).options[0] = new Option("Seçiniz", "-1");
                    $.each(msg, function(index, vergi) {
                        $("#vergi_dairesi_id").get(0).options[$("#vergi_dairesi_id").get(0).options.length] = new Option(vergi.adi, vergi.id);
                    });
                },
                async: false,
                error: function() {
                    $("#vergi_dairesi_id").get(0).options.length = 0;
                    alert("Vergi Daireleri yükelenemedi!!!");
                }
            });
        }
        else {
            $("#vergi_dairesi_id").get(0).options.length = 0;
        }
    }
    function populateDD(){
        GetIlce({{$firmaAdres->iller->id}},"il_id");
        GetSemt({{$firmaAdres->ilceler->id}});
        $("#il_id ").val({{$firmaAdres->iller->id}}).trigger("event");
        console.log($("#ilce_id").val({{$firmaAdres->ilceler->id}}));
        $("#semt_id").val({{$firmaAdres->semtler->id}});
    }
    function populateTicaretDD(){
        GetTicaret({{$firmaFatura->iller->id}});
        $("#ticaret_odasi").val({{$firma->ticari_bilgiler->tic_oda_id}});
    }
    function populateMaliDD(){
        var firmaFatura_il_id = "{{$firmaFatura->iller->id}}";
        GetIlce(firmaFatura_il_id,"mali_il_id");
        GetVergi(firmaFatura_il_id);
        $("#mali_il_id").val({{$firmaFatura->iller->id}});
        $("#mali_ilce_id").val({{$firmaFatura->ilceler->id}});
        $("#sirket_turu").val({{$firma->sirket_turu}});
        $("#yillik_cirosu").val("{{$firma->mali_bilgiler->yillik_cirosu}}");
        $("#vergi_dairesi_id").val({{$firma->mali_bilgiler->vergi_dairesi_id}});

        if("{{$firma->mali_bilgiler->ciro_goster}}" == "1"){
            $("#ciro_goster").prop('checked',true);
        }
        else{
            $("#ciro_goster").prop('checked',false);
        }

        if("{{$firma->mali_bilgiler->sermaye_goster}}" == "1"){
            $("#sermaye_goster").prop('checked',true);
        }
        else{
            $("#sermaye_goster").prop('checked',false);
        }
    }

    $('#addImage').on('change', function(evt) {
    var selectedImage = evt.currentTarget.files[0];
    var imageWrapper = document.querySelector('.image-wrapper');
    var theImage = document.createElement('img');
    imageWrapper.innerHTML = '';
    var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
    if (regex.test(selectedImage.name.toLowerCase())) {
      if (typeof(FileReader) != 'undefined') {
        var reader = new FileReader();
        reader.onload = function(e) {
            theImage.id = 'new-selected-image';
            theImage.src = e.target.result;
            imageWrapper.appendChild(theImage);
          }
          //
        reader.readAsDataURL(selectedImage);
      } else {
        //-- Let the user knwo they cannot peform this as browser out of date
        console.log('browser support issue');
      }
    } else {
      //-- no image so let the user knwo we need one...
      $(this).prop('value', null);
      console.log('please select and image file');
    }
  });
    var total_row=44;
    var dolu_row=0;
    var total_yuzde=0;
function dolulukForm(){
    var logo1 = document.getElementById("logo1").src;
    var ticaret_sicil_no=$('#ticaret_sicil_no').val();
    var ticaret_odasi= $('#odasi_id_td').text();
    var ust_sektor= $('#ust_id_td').text();
    var faaliyet_sektorleri=$('#dfaaliyet_id_td').text();
    var firma_departmanlari=$('#departman_id_td').text();
    var kurulus_tarihi=$('#kurulus_tarihi').val();
    var firma_faaliyet_turu=$('#faaliyet_id_td').text();
    var firmanin_urettigi_markalar=$('#urettigi_id_td').text();
    var firmanin_sattigi_markalar=$('#sattıgı_id_td').text();
    var kalite_belgeleri=$('#kalite_id_td').text();
    var belge_no=$('#belge_no').val();
    var ref_turu= $('#ref_turu_id_td').text();
    var ref_firma_adi=$('#ref_firma_adi').val();
    var yapilan_isin_adi=$('#yapilan_isin_adi').val();
    var isin_turu= $('#is_turu_id_td').text();
    var is_yili=$('#is_yili').val();
    var calisma_suresi=$('#calısma_suresi').val();
    var yetkili_kisi_adi=$('#yetkili_kisi_adi').val();
    var yetkili_kisi_email=$('#yetkili_kisi_email').val();
    var yetkili_kisi_telefon=$('#yetkili_kisi_telefon').val();
    var brosur_adi=$('#brosur_adi').val();
    var calisma_gunleri= $('#calisma_id_td').text();
    var calisma_saatleri=$('#calisma_saatleri').val();
    var calisma_profili=$('#profil_id_td').text();
    var calisma_sayisi=$('#calisma_sayisi').val();
    var bilgilendirme_tercihi='dolu';
    if(logo1 != null ){
         dolu_row++
    }
    if("{{$firmaAdres->iller->adi}}" != "" && "{{$firmaAdres->iller->adi}}" != "Seçiniz"){
        dolu_row++
    }
    if("{{$firmaAdres->ilceler->adi}}" != "" && "{{$firmaAdres->ilceler->adi}}" !="Seçiniz"){
         dolu_row++
    }
    if("{{$firmaAdres->semtler->adi}}" != "" && "{{$firmaAdres->semtler->adi}}" !="Seçiniz"){
        dolu_row++
    }
    if("{{$firmaAdres->adres}}" != ""){
        dolu_row++
    }
    if("{{$firma->iletisim_bilgileri->telefon}}" != ""){
         dolu_row++
    }
    if("{{$firma->iletisim_bilgileri->fax}}" != ""){
         dolu_row++
    }
    if("{{$firma->iletisim_bilgileri->web_sayfasi}}" != ""){
         dolu_row++
    }
    if("{{$firma->tanitim_yazisi}}" != ""){
         dolu_row++
    }
    if("{{$firmaFatura->iller->adi}}" != "" && "{{$firmaFatura->iller->adi}}" != "Seçiniz"){
         dolu_row++
    }
    if("{{$firmaFatura->ilceler->adi}}" != "" && "{{$firmaFatura->ilceler->adi}}" != "Seçiniz"){
         dolu_row++
    }
    if("{{$firma->mali_bilgiler->unvani}}" != ""){
         dolu_row++
    }
    if("{{$sirket->adi}}" != "" && "{{$sirket->adi}}" !="Seçiniz"){
         dolu_row++
    }
    if("{{$firma->mali_bilgiler->vergi_daireleri->adi}}" != "" && "{{$firma->mali_bilgiler->vergi_daireleri->adi}}" !="Seçiniz"){
         dolu_row++
    }
    if("{{$firma->mali_bilgiler->vergi_numarasi}}" != ""){
         dolu_row++
    }
    if("{{$firma->mali_bilgiler->yillik_cirosu}}" != ""){
         dolu_row++
    }
    if("{{$firma->mali_bilgiler->sermayesi}}" != ""){
         dolu_row++
    }
    if(ticaret_sicil_no != ""){
         dolu_row++
    }
    if(ticaret_odasi != "" && ticaret_odasi!="Seçiniz"){
         dolu_row++
    }
    if(ust_sektor != "" && ust_sektor!="Seçiniz"){
         dolu_row++
    }
    if(faaliyet_sektorleri != ""){
         dolu_row++
    }
    if(firma_departmanlari != ""){
         dolu_row++
    }
    if(kurulus_tarihi != ""){
         dolu_row++
    }
    if(firma_faaliyet_turu != ""){
         dolu_row++
    }
    if(firmanin_urettigi_markalar != ""){
         dolu_row++
    }
    if(firmanin_sattigi_markalar != ""){
         dolu_row++
    }
    if(kalite_belgeleri != "" && kalite_belgeleri!="Seçiniz"){
         dolu_row++
    }
    if(belge_no != ""){
         dolu_row++
    }
    if(ref_turu != ""  && ref_turu!="Seçiniz"){
         dolu_row++
    }
    if(ref_firma_adi != ""){
         dolu_row++
    }
    if(yapilan_isin_adi != ""){
         dolu_row++
    }
    if(isin_turu != ""  && isin_turu!="Seçiniz"){
         dolu_row++
    }
    if(is_yili != ""){
         dolu_row++
    }
    if(calisma_suresi != ""){
         dolu_row++
    }
    if(yetkili_kisi_adi != ""){
         dolu_row++
    }
    if(yetkili_kisi_email != ""){
         dolu_row++
    }
    if(yetkili_kisi_telefon != ""){
         dolu_row++
    }
    if(brosur_adi != ""){
         dolu_row++
    }
    if(calisma_gunleri != ""  && calisma_gunleri!="Seçiniz"){
         dolu_row++
    }
    if(calisma_saatleri != ""){
         dolu_row++
    }
    if(calisma_profili != ""){
         dolu_row++
    }
    if(calisma_sayisi != ""){
         dolu_row++
    }
    if(bilgilendirme_tercihi != ""){
         dolu_row++
    }
   var total_dolu_row=dolu_row;
   var hesaplama=(total_dolu_row/total_row)*100;
   total_yuzde=hesaplama.toFixed(0);


   //funcDolulukKayıt()
}
   function funcDolulukKayıt(){
    $.ajax({
        type:"POST",
        url: "{{asset('doluluk_orani')}}"+"/"+"{{$firma->id}}",
        data:{doluluk_orani:total_yuzde},
        cache: false,
        success: function(data){
           console.log(data);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Status: " + textStatus); alert("Error: " + errorThrown);
        }
    });
   }
////transection controollerinde çıkan sistemsel hatanın ekrana bastırılması.
var firma_id='{{$firma->id}}';

$("#iletisim_kayit").submit(function(e) {
    var postData = $(this).serialize();
    var formURL = $(this).attr('action');
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
                setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 5000);
            }
            else{
                 setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 1000);
            }
                e.preventDefault();
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            alert(textStatus + "," + errorThrown);
        }
    });
    e.preventDefault();
});

 $("#mali_kayit").submit(function(e) {
    var postData = $(this).serialize();
    var formURL = $(this).attr('action');

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
                setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 5000);
            }
            else{
                 setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 1000);
            }
                e.preventDefault();
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            alert(textStatus + "," + errorThrown);
        }
    });
    e.preventDefault();
 });

$("#ticari_kayit").submit(function(e) {
    var postData = $(this).serialize();
    alert(postData);
    /*var formURL = $(this).attr('action');
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
                setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 5000);
            }
            else{
                 setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 1000);
            }
                e.preventDefault();
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            alert(textStatus + "," + errorThrown);
        }

    });
    e.preventDefault();*/
});

  $("#kalite_add_kayit").submit(function(e)
   {
       var postData = $(this).serialize();
            var formURL = $(this).attr('action');
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
                        setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 5000);
                    }
                    else{
                         setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 1000);
                    }
                        e.preventDefault();
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    alert(textStatus + "," + errorThrown);
                }
            });
            e.preventDefault();
    });
  $("#kalite_up_kayit").submit(function(e)
   {
       var postData = $(this).serialize();
            var formURL = $(this).attr('action');
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
                        setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 5000);
                    }
                    else{
                         setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 1000);
                    }
                        e.preventDefault();
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    alert(textStatus + "," + errorThrown);
                }
            });
            e.preventDefault();
    });
  $("#ref_up_kayit").submit(function(e)
   {
       var postData = $(this).serialize();
            var formURL = $(this).attr('action');
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
                        setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 5000);
                    }
                    else{
                         setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 1000);
                    }
                        e.preventDefault();
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    alert(textStatus + "," + errorThrown);
                }
            });
            e.preventDefault();
    });
  $("#ref_add_kayit").submit(function(e)
   {
       var postData = $(this).serialize();
            var formURL = $(this).attr('action');
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
                        setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 5000);
                    }
                    else{
                         setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 1000);
                    }
                        e.preventDefault();
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    alert(textStatus + "," + errorThrown);
                }
            });
            e.preventDefault();
    });

 $("#brosur_kayit").submit(function(e) {
    var postData = new FormData($(this)[0]);
    var formURL = $(this).attr('action');
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
                setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 5000);
            }
            else{
                setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 1000);
            }
            e.preventDefault();
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            alert(textStatus + "," + errorThrown);
        }
    });
    e.preventDefault();
});

  $("#brosur_up_kayit").submit(function(e)
   {
       var postData = $(this).serialize();
       var formURL = $(this).attr('action');
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
                        setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 5000);
                    }
                    else{
                         setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 1000);
                    }
                        e.preventDefault();
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    alert(textStatus + "," + errorThrown);
                }
            });
            e.preventDefault();
    });

   $("#calisma_kayit").submit(function(e)
   {
       var postData = $(this).serialize();
            var formURL = $(this).attr('action');
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
                        setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 5000);
                    }
                    else{
                         setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 1000);
                    }
                        e.preventDefault();
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    alert(textStatus + "," + errorThrown);
                }
            });
            e.preventDefault();
    });

$("#bilgilendirme_kayit").submit(function(e) {
    var postData = $(this).serialize();
    var formURL = $(this).attr('action');
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
                setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 5000);
            }
            else{
                 setTimeout(function(){ location.href="{{asset('firmaProfili')}}"}, 1000);
            }
                e.preventDefault();
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            alert(textStatus + "," + errorThrown);
        }
    });
    e.preventDefault();
});

//TANITIM YAZISI SHOW JS
$('#btn-add-tanitimyazisi').click(function(){
    $('#myModal-tanitimyazisi').modal('show');
});

//PROFIL FOTO SHOW JS
$('#btn-add-image').click(function(){
    $('#myModal-image').modal('show');
});

//MALI BILGILER SHOW JS
$('#btn-add-malibilgiler').click(function(){
    $('#myModal-malibilgiler').modal('show');
});

//BILGILENDIRME TERCIHI SHOW JS
$('#btn-add-bilgilendirmetercihi').click(function(){
    $('#myModal-bilgilendirmetercihi').modal('show');
});

//TICARI BILGILER SHOW JS
$('#btn-add-ticaribilgiler').click(function(){
    $('#myModal-ticaribilgiler').modal('show');
});

//FIRMA BROSUR SHOW JS
$('#btn-add-firmabrosurEkle').click(function(){
    $('#myModal-firmabrosurEkle').modal('show');
});

//MALI BILGILER SHOW JS
$('#btn-add-malibilgiler').click(function(){
    $('#myModal-malibilgiler').modal('show');
});

//REFERANSLAR SHOW JS
$('#btn-add-referanslar').click(function(){
    $('#myModal-referanslar').modal('show');
});

//KALITE SHOW JS
$('#btn-add-kalite').click(function(){
    $('#btn-save-kalite').val("add");
    $('#myModal-kalite').modal('show');
});

$('.open-modal-kaliteGuncelle').click(function(){
    $('#myModal-kaliteGuncelle').modal('show');
    $('#kalite_belgeleri').val($(this).val());
});

//FIRMA CALISANLARI SHOW JS
$('#btn-add-firmacalisanbilgileri').click(function(){
    $('#myModal-firmacalisanbilgileri').modal('show');
});

$('.open-modal-brosurGuncelle').click(function(){
    $('#myModal-firmabrosurGuncelle').modal('show');
});

// REFERANS GECMIS JS
var url = "{{asset('firma')}}";
$('.open-modal-gecmis').click(function(){
    var ref_id = $(this).val();
    $.get(url + '/'  + ref_id, function (data) {
        $('#ref_id').val(data.id);
        $('#ref_turu').val(data.ref_turu);
        $('#ref_firma_adi').val(data.adi);
        $('#yapilan_isin_adi').val(data.is_adi);
        $('#isin_turu').val(data.is_turu);
        $('#is_yili').val(data.is_yili);
        $('#calısma_suresi').val(data.calisma_suresi);
        $('#yetkili_kisi_adi').val(data.yetkili_adi);
        $('#yetkili_kisi_email').val(data.yetkili_email);
        $('#yetkili_kisi_telefon').val(data.yetkili_telefon);
        $('#myModal-referanslarGecmis').modal('show');
    })
});

    //AJAX CRUD JS

    var url = "{{asset('firma')}}";

    //display modal form for task editing
    $('.open-modal').click(function(){
        var iletisimbilgisi_id = $(this).val();

        $.get(url + '/' + iletisimbilgisi_id, function (data) {
            //success data
            console.log(data);
            $('#il_id').val(data.il_id);
            $('#ilce_id').val(data.ilce_id);
            $('#semt_id').val(data.semt_id);
            $('#adres').val(data.adres);
            $('#telefon').val(data.telefon);
            $('#fax').val(data.fax);
            $('#web_sayfası').val(data.web_sayfası);
            $('#btn-save').val("update");
            $('#myModal').modal('show');

        })
    });
    //display modal form for task editing


    //display modal form for creating new task
    $('#btn-add').click(function(){
        $('#myModal').modal('show');
    });

    //delete task and remove it from list
    $('.delete-task').click(function(){
        var commucation_id = $(this).val();

        $.ajax({

            type: "DELETE",
            url: url + '/' + commucation_id,
            success: function (data) {
                console.log(data);

                $("#task" + commucation_id).remove(); //task yerine ne yazmam lazım ?? o task html adı???
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    //create new task / update existing task
    $("#btn-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

            }
        });

        e.preventDefault();

        var formData = {
            il_id: $('#il_id').val(),
            ilce_id: $('#ilce_id').val(),
            semt_id: $('#semt_id').val(),
            adres: $('#adres').val(),
            telefon: $('#telefon').val(),
            fax: $('#fax').val(),
            web_sayfası: $('#web_sayfası').val(),
        }

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();

        var type = "POST"; //for creating new resource
        var commucation_id = $('#commucation_id').val();
        var my_url = url;


        if (state == "update"){
            type = "PUT"; //for updating existing resource
            my_url += '/' + commucation_id;
        }

        console.log(formData);

        $.ajax({

            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);


                $('#frmTasks').trigger("reset");

                $('#myModal').modal('hide')
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

</script>
@endsection
@section('sayfaSonu')
    <script src="{{asset('MetronicFiles/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/pages/scripts/dashboard.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/pages/scripts/profile.min.js')}}" type="text/javascript"></script>
@endsection
