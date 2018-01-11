<?php
    use Carbon\Carbon;
    use Barryvdh\Debugbar\Facade as Debugbar;
    $dt = Carbon::today();
    $time = Carbon::parse($dt);
    $dt = $time->format('Y-m-d');
?>
@extends('layouts.appUser')

@section('baslik') İlanlarım @endsection

@section('aciklama')

@endsection

@section('head')
    <link href="{{asset('MetronicFiles/global/plugins/bootstrap-table/bootstrap-table.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('MetronicFiles/global/plugins/ion.rangeslider/css/ion.rangeSlider.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('MetronicFiles/global/plugins/ion.rangeslider/css/ion.rangeSlider.skinSimple.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset('js/wNumb.js')}}"></script>

    <style>
        .ajax-loader {
            visibility: hidden;
            background-color: rgba(255,255,255,0.7);
            position: absolute;
            z-index: +100 !important;
            width: 100%;
            height:100%;
        }

        .ajax-loader img {
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }


        label{
            display: inline-block;
            font-size: 12px;
        }
        textarea,input[type=text],input[type=datetime-local],input[type=time],select,label1
        {
            color: #000;
            outline: 0;
            resize: none;
            margin: 0;
            margin-top: 1em;
            padding: .5em;
            width:100%;
            background:#fff;
            box-shadow:inset 0 2px 2px rgb(119, 119, 119);
        }
        input[type=text]:focus,input[type=datetime-local]:focus,input[type=time]:focus {
            background-color: #ddd;
        }
        input[type=submit]
        {
            border:none;
            background: #FAFEFF;
            padding: .5em 1em;
            margin-top: 1em;
            color:#4478a0;
        }
        input[type=submit]:active
        {
            background: #E1E5E5;
        }
        input:-moz-placeholder, textarea:-moz-placeholder {
            color: #555;
        }
        input:-ms-input-placeholder, textarea:-ms-input-placeholder {
            color: #555;
        }
        input::-webkit-input-placeholder, textarea::-webkit-input-placeholder {
            color:#555;
        }
        .blink_text {

            animation:2s blinker linear infinite;
            -webkit-animation:2s blinker linear infinite;
            -moz-animation:2s blinker linear infinite;
        }

        @-moz-keyframes blinker {
            0% { opacity: 1.0; }
            50% { opacity: 0.0; }
            100% { opacity: 1.0; }
        }

        @-webkit-keyframes blinker {
            0% { opacity: 1.0; }
            50% { opacity: 0.0; }
            100% { opacity: 1.0; }
        }

        @keyframes blinker {
            0% { opacity: 1.0; }
            50% { opacity: 0.0; }
            100% { opacity: 1.0; }
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
        @keyframes fontbulger {
            0%, 100% {
                font-size: 10px;
            }
            50% {
                font-size: 12px;
            }
        }
        #box {
            animation: fontbulger 2s infinite;
            font-weight: bold;
        }
        #box {
            animation: fontbulger 2s infinite;
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-9">
            {{--aktif ilanlar başlangıcı--}}
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-paper-plane theme-font"></i>
                        <span class="caption-subject theme-font bold uppercase">Aktif İlanlarım &nbsp;({{$aktif_ilanlar->count()}} İlan)</span>
                    </div>
                </div>
                <div class="portlet-body">
                @if($aktif_ilanlar->count()!=0)
                    <table id="table-pagination" data-toggle="table" data-pagination="true" data-search="true" class="table table-light">
                        <thead>
                        <tr>
                            <th data-field="ilan" data-align="center" data-sortable="true">İlan Adı</th>
                            <th data-field="tarih" data-align="center" data-sortable="true">Kapanma Tarihi</th>
                            <th data-field="teklifVerenler" data-align="center" data-sortable="true">Teklif Veren Sayısı</th>
                            <th data-field="goruntule" data-align="center">Görüntüle</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($aktif_ilanlar as $aktif_ilan)
                            @if($aktif_ilan->kapanma_tarihi < $dt)
                            <tr class="danger">
                            @else
                            <tr class="active">
                            @endif
                                <td><a href="{{ URL::to('teklifGor', array($firma->id,$aktif_ilan->id), false) }}" class="btn">{{$aktif_ilan->adi}}</a></td>
                                <td>{{date('d-m-Y', strtotime($aktif_ilan->kapanma_tarihi))}}</td>
                                <td>{{$aktif_ilan->teklifler->count() == 0 ? 0 : $aktif_ilan->teklifler[0]->firma_sayisi}}</td>
                                <td>
                                    <a href="{{URL::to('teklifGor', array($firma->id,$aktif_ilan->id), false)}}" class="btn btn-circle bold btn-icon-only purple">
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                        <tfoot>
                        <tr>
                            <td colspan="4">
                                <div class="col-md-6">
                                    <div style="width: 20px;height: 20px;background-color: #eef1f5;float: left;"></div> <div style="float: left; margin:1px;margin-left: 10px">Yayında İlan</div>
                                </div>
                                <div class="col-md-6">
                                    <div style="width: 20px;height: 20px;background-color: #fbe1e3;float: left;"></div> <div style="float: left; margin:1px;margin-left: 10px">Süresi Dolmuş İlan</div>
                                </div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                @else

                    <p style="text-align:center">Henüz Aktif İlanınız Bulunmamaktadır.</p>

                @endif
                </div>
            </div>

            {{--puan ver yorum yap ilanlar başlangıcı--}}
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-paper-plane theme-font"></i>
                        <span class="caption-subject theme-font bold uppercase">Puan Ver Yorum Yap &nbsp;({{$yorumPuanIlanlar->count()}} İlan)</span>
                    </div>
                </div>
                <div class="portlet-body">
                @if($yorumPuanIlanlar->count()!=0)
                    <table id="table-pagination" data-toggle="table" data-pagination="true" data-search="true" class="table table-light">
                        <thead>
                        <tr>
                            <th data-field="ilan" data-align="center" data-sortable="true">İlan Adı</th>
                            <th data-field="tarih" data-align="center" data-sortable="true">İş Başlama Tarihi</th>
                            <th data-field="kazananFirma" data-sortable="true">Kazanan Firma</th>
                            <th data-field="teklif" data-align="center" data-sortable="true">Teklif</th>
                            <th data-field="puanYorum">Puan / Yorum</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($yorumPuanIlanlar as $yorumPuanIlan)
                            <?php
                                if($yorumPuanIlan->sozlesme_turu==1){
                                    $kazanan=$yorumPuanIlan->goturu_bedel_kazananlar[0];
                                }
                                else{
                                    $kazanan=$yorumPuanIlan->kismi_kapali_kazananlar[0];
                                }
                                $puan = $puanControl->puanGetir($kazanan->kazanan_firma_id,$yorumPuanIlan->id);
                            ?>
                            @if(!$puan)
                                <tr class="active">
                            @else
                                <tr class="danger">
                            @endif
                                <td><a href="{{ URL::to('teklifGor', array($yorumPuanIlan->firma_id,$yorumPuanIlan->id), false) }}" class="btn">{{$yorumPuanIlan->adi}}</a></td>
                                <td>{{date('d-m-Y', strtotime($yorumPuanIlan->is_baslama_tarihi))}}</td>

                                <td><a href="{{ URL::to('firmaDetay', array($kazanan->kazanan_firma_id), false) }}" class="btn">{{$kazanan->firma->adi}}</a></td>
                                <td>{{number_format($kazanan->kazanan_fiyat, 2, ',', '.')}}{{$yorumPuanIlan->para_birimleri->para_birimi()}}</td>
                                <td>
                                    <a href="javascript:;" class="btn btn-circle bold purple btn_yorum_puan" value="{{$yorumPuanIlan->id}}">
                                        @if(!$puan)
                                            <i class="icon-bubbles"></i> puan ver!
                                        @else
                                            <i class="icon-bubbles"></i> görüntüle
                                        @endif
                                    </a>
                                </td>
                                <div id="modal_yorum_puan_{{$yorumPuanIlan->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="ajax-loader" id="loader-puan-ver">
                                            <img src="{{asset('images/slack_load.gif')}}"/>
                                        </div>

                                    @if(!$puan)
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title" id="myModalLabel"><img src="{{asset('images/arrow.png')}}">&nbsp;<strong>Puan Ver Yorum Yap!</strong></h4>
                                        </div>
                                        {!! Form::open(array('url'=> URL::to('yorumPuan', array($yorumPuanIlan->id,$kazanan->kazanan_firma_id), false),'method'=>'POST','class'=>'form_yorum_puan')) !!}
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-12"><strong>{{$yorumPuanIlan->adi}} ilanı için {{$kazanan->firma->adi}} firmasına puan veriliyor.</strong></div>
                                            </div>
                                            <div class="row" style="margin-top: 10px">
                                                <div class="col-lg-3">
                                                    <label name="kriter1" style="height: 30px">Ürün/hizmet kalitesi</label>
                                                    <input type="text" class="puan_aralik" name="puan1" value="5" />
                                                </div>
                                                <div class="col-lg-3">
                                                    <label name="kriter2" style="height: 30px">Teslimat</label>
                                                    <input type="text" class="puan_aralik" name="puan2" value="5" />
                                                </div>
                                                <div class="col-lg-3">
                                                    <label name="kriter3" style="height: 30px">Teknik ve Yönetsel Yeterlilik</label>
                                                    <input type="text" class="puan_aralik" name="puan3" value="5" />
                                                </div>
                                                <div class="col-lg-3">
                                                    <label name="kriter4" style="height: 30px">İletişim ve Esneklik</label>
                                                    <input type="text" class="puan_aralik" name="puan4" value="5" />
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 10px">
                                                <div class="col-lg-12">
                                                    Yorum Yap:
                                                    <textarea name="yorum" placeholder="Yorum" cols="30" rows="5" wrap="soft" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            {!! Form::submit('Kaydet', array('style'=>'float:right','class'=>'btn purple')) !!}
                                        </div>
                                        {!! Form::close() !!}
                                    @else
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title" id="myModalLabel"><img src="{{asset('images/arrow.png')}}">&nbsp;<strong>Puan ve Yorum Görüntüle</strong></h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-12"><strong>{{$yorumPuanIlan->adi}} ilanı için {{$kazanan->firma->adi}} firmasına verilen puan grüntüleniyor.</strong></div>
                                            </div>
                                            <div class="row" style="margin-top: 10px">
                                                <div class="col-lg-3">
                                                    <label name="kriter1" style="height: 30px">Ürün/hizmet kalitesi</label>
                                                    <input type="text" class="disable_puan_aralik" name="puan1" value="{{$puan->kriter1}}" />
                                                </div>
                                                <div class="col-lg-3">
                                                    <label name="kriter2" style="height: 30px">Teslimat</label>
                                                    <input type="text" class="disable_puan_aralik" name="puan2" value="{{$puan->kriter2}}" />
                                                </div>
                                                <div class="col-lg-3">
                                                    <label name="kriter3" style="height: 30px">Teknik ve Yönetsel Yeterlilik</label>
                                                    <input type="text" class="disable_puan_aralik" name="puan3" value="{{$puan->kriter3}}" />
                                                </div>
                                                <div class="col-lg-3">
                                                    <label name="kriter4" style="height: 30px">İletişim ve Esneklik </label>
                                                    <input type="text" class="disable_puan_aralik" name="puan4" value="{{$puan->kriter4}}" />
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 10px">
                                                <div class="col-lg-12">
                                                    Yorum:
                                                    <textarea name="yorum" placeholder="Yorum" cols="30" rows="5" wrap="soft" disabled> {{$puan->yorum->yorum}}</textarea>
                                                </div>
                                            </div>
                                    @endif
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">
                                <div class="col-md-6">
                                    <div style="width: 20px;height: 20px;background-color: #eef1f5;float: left;"></div> <div style="float: left; margin:1px;margin-left: 10px">Henüz Puan Verilmemiş İlan</div>
                                </div>
                                <div class="col-md-6">
                                    <div style="width: 20px;height: 20px;background-color: #fbe1e3;float: left;"></div> <div style="float: left; margin:1px;margin-left: 10px">Puan Verilmiş İlan</div>
                                </div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                @else
                    <p style="text-align:center">Henüz Puan Yapılacak İlanınız Bulunmamaktadır.</p>
                @endif
                </div>
            </div>

            {{--pasif ilanlar başlangıcı--}}
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-paper-plane theme-font"></i>
                        <span class="caption-subject theme-font bold uppercase">Pasif İlanlarım &nbsp;({{$pasif_ilanlar->count()}} İlan)</span>
                    </div>
                </div>
                <div class="portlet-body">
                    @if($pasif_ilanlar->count()!=0)
                    <table id="table-pagination" data-toggle="table" data-pagination="true" data-search="true" class="table table-light">
                        <thead>
                        <tr>
                            <th data-field="ilan" data-align="center" data-sortable="true">İlan Adı</th>
                            <th data-field="tarih" data-align="center" data-sortable="true">Kapanma Tarihi</th>
                            <th data-field="teklifVerenler" data-align="center" data-sortable="true">Teklif Veren Sayısı</th>
                            <th data-field="goruntule" data-align="center">Görüntüle</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pasif_ilanlar as $pasif_ilan)
                            @if($pasif_ilan->kapanma_tarihi < $dt)
                                <tr class="danger">
                            @else
                                <tr class="warning">
                            @endif
                                <td>{{$pasif_ilan->adi}}</td>
                                <td>{{date('d-m-Y', strtotime($pasif_ilan->kapanma_tarihi))}}</td>
                                <td>{{$pasif_ilan->teklifler->count() == 0 ? 0 : $pasif_ilan->teklifler[0]->firma_sayisi}}</td>
                                <td>
                                    <a href="{{URL::to('teklifGor', array($firma->id,$pasif_ilan->id), false)}}" class="btn btn-circle bold btn-icon-only purple">
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4">
                                <div class="col-md-6">
                                    <div style="width: 20px;height: 20px;background-color: #f9e491;float: left;"></div> <div style="float: left; margin:1px;margin-left: 10px">Pasif İlan</div>
                                </div>
                                <div class="col-md-6">
                                    <div style="width: 20px;height: 20px;background-color: #fbe1e3;float: left;"></div> <div style="float: left; margin:1px;margin-left: 10px">Süresi Dolmuş İlan</div>
                                </div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                    @else
                        <p style="text-align:center">Henüz Pasif İlanınız Bulunmamaktadır.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">

            <!-- BEGIN WIDGET THUMB -->
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 " align="center">
                <a href="{{asset('ilanOlustur/'.$firma->id)}}" class="btn btn-circle purple">Yeni İlan Oluştur <i class="icon-plus"></i></a>
            </div>
            <!-- END WIDGET THUMB -->
            <div class="portlet box purple mt-element-ribbon">
                <div class="ribbon ribbon-vertical-right ribbon-shadow ribbon-color-danger">
                    <div class="ribbon-sub ribbon-bookmark"></div>
                    <i class="icon-trophy"></i>
                </div>
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-fire"></i>
                        Kazananı Belirle
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable table-scrollable-borderless" style="max-height: 500px;overflow-y: scroll;">
                        <table class="table table-light">
                            <tbody>
                                @foreach($aktif_ilanlar as $aktif_ilan)
                                    @if($aktif_ilan->kapanma_tarihi < $dt)
                                        <tr>
                                            <td><a href="{{ URL::to('teklifGor', array($firma->id,$aktif_ilan->id), false) }}" class="btn"><i class="icon-paper-plane theme-font"></i> {{$aktif_ilan->adi}}</a></td>
                                        </tr>
                                    @endif
                                @endforeach

                                <tr>
                                    <td>
                                        <span style="font-size: small">Bu ilanların henüz kazananını belirlemediniz. Belirlemek istiyorsanız ilanı görüntüleyip Rekabet sekmesine gidebilirsiniz!</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- BEGIN WIDGET THUMB -->
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                <h4 class="widget-thumb-heading">Toplam İlanlarım</h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-red-pink icon-paper-plane "></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="{{$aktif_ilanlar->count() + $sonuc_ilanlar->count() + $pasif_ilanlar->count()}}">{{$aktif_ilanlar->count() + $sonuc_ilanlar->count() + $pasif_ilanlar->count()}}</span>
                    </div>
                </div>
            </div>
            <!-- END WIDGET THUMB -->

            <!-- BEGIN WIDGET THUMB -->
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                <h4 class="widget-thumb-heading">Aktif İlanlarım</h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-yellow icon-paper-plane"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="{{$aktif_ilanlar->count()}}">{{$aktif_ilanlar->count()}}</span>
                    </div>
                </div>
            </div>
            <!-- END WIDGET THUMB -->

            <!-- BEGIN WIDGET THUMB -->
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                <h4 class="widget-thumb-heading">Sonuçlanmış İlanlarım</h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-green icon-paper-plane"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="{{$sonuc_ilanlar->count()}}">{{$sonuc_ilanlar->count()}}</span>
                    </div>
                </div>
            </div>
            <!-- END WIDGET THUMB -->
        </div>
    </div>
@endsection

@section('sayfaSonu')
    <script src="{{asset('MetronicFiles/global/plugins/ion.rangeslider/js/ion.rangeSlider.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/global/plugins/bootstrap-table/bootstrap-table.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/pages/scripts/table-bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/global/plugins/counterup/jquery.waypoints.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/global/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready( function() {
            $(".puan_aralik").ionRangeSlider({
                min: 0,
                max: 10,
                onChange: function (data) {
                    var slider=data.slider[0].getElementsByTagName("span");
                    var value=data.from;
                    if(value <= 4){
                        slider[11].style.background = "#e65100";
                        slider[12].style.background = "#e65100";
                    }
                    else if(value === 5){
                        slider[11].style.background = "";
                        slider[12].style.background = "";
                    }
                    else if(value === 6){
                        slider[11].style.background = "#f46f02";
                        slider[12].style.background = "#f46f02";
                    }
                    else if(value === 7){
                        slider[11].style.background = "#ffba04";
                        slider[12].style.background = "#ffba04";
                    }
                    else if(value === 8){
                        slider[11].style.background = "#d6d036";
                        slider[12].style.background = "#d6d036";
                    }
                    else if(value === 9){
                        slider[11].style.background = "#a5c530";
                        slider[12].style.background = "#a5c530";
                    }
                    else if(value === 10){
                        slider[11].style.background = "#45c538";
                        slider[12].style.background = "#45c538";
                    }
                }
            });
            $(".disable_puan_aralik").ionRangeSlider({
                min: 0,
                max: 10,
                disable: true
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
        $(document).on('click', '.btn_yorum_puan', function(){
            $('#modal_yorum_puan_'+$(this).attr("value")).modal('show');
        });
        $(document).on('submit', '.form_yorum_puan', function(e){
            $('.ajax-loader').css("visibility", "visible");
            var postData = $(this).serialize();
            var formURL = $(this).attr('action');
            $.ajax(
                {
                    url : formURL,
                    type: "POST",
                    data : postData,
                    success:function(data, textStatus, jqXHR)
                    {
                        location.href="{{asset('ilanlarim/'.session()->get('firma_id'))}}";
                        e.preventDefault();
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        $('.ajax-loader').css("visibility", "hidden");
                        alert(textStatus + "," + errorThrown);
                    }
                });
            e.preventDefault();
        });
    </script>
@endsection