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
    <link href="{{asset('MetronicFiles/global/plugins/ion.rangeslider/css/ion.rangeSlider.skinFlat.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset('js/wNumb.js')}}"></script>

    <style>

        .dialog {
            position: relative;
            text-align: center;
            background: #fff;
            margin: 13px 0 4px 4px;
            display: inline-block;
        }
        .dialog:after,
        .dialog:before {
            bottom: 100%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }
        .dialog:after {
            border-color: rgba(255, 255, 255, 0);
            border-bottom-color: #5C9CCE;
            border-width: 15px;
            left: 50%;
            margin-left: -15px;
        }
        .dialog:before {
            border-color: rgba(170, 170, 170, 0);
            border-width: 16px;
            left: 50%;
            margin-left: -16px;
        }
        .dialog .title {
            font-weight: bold;
            text-align: center;
            border: 1px solid #eeeeee;
            border-radius: 8px;
            border-width: 0px 0px 1px 0px;
            margin-left: 0;
            margin-right: 0;
            margin-bottom: 4px;
            margin-top: 8px;
            padding: 8px 16px;
            background: #fff;
            font-size: 16px;
            line-height:2em;
        }
        .dialog .title:first-child {
            margin-top: -4px;
        }
        form
        {
            padding:16px;
            padding-top: 0;
        }
        label1{
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
                    </table>
                @else

                    <p style="text-align:center">Henüz Aktif İlanınız Bulunmamaktadır.</p>

                @endif
                </div>
            </div>

            <?php
            $i=0;
            $kullanici_id=Auth::user()->id;
            $firma_id = session()->get('firma_id');
            $j=1;
            ?>
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-paper-plane theme-font"></i>
                        <span class="caption-subject theme-font bold uppercase">Sonuçlanmış İlanlarım &nbsp;({{$sonuc_ilanlar->count()}} İlan)</span>
                    </div>
                </div>
                <div class="portlet-body">

                @if($sonuc_ilanlar->count() != 0)
                    <table id="table-pagination" data-toggle="table" data-pagination="true" data-search="true" class="table table-light">
                        <thead>
                        <tr>
                            <th data-field="ilan" data-align="center" data-sortable="true">İlan Adı</th>
                            <th data-field="tarih" data-align="center" data-sortable="true">Sonuclanma Tarihi</th>
                            <th data-field="teklifVerenler" data-align="center" data-sortable="true">Teklif Veren Sayısı</th>
                            <th data-field="kazananFiyat" data-align="center" data-sortable="true">Kazanan Fiyat</th>
                            <th data-field="kazananFirma" data-align="center" data-sortable="true">Kazanan Firma</th>
                            <th data-field="goruntule" data-align="center">Görüntüle</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sonuc_ilanlar as $ilan)
                            <tr>
                                <td><a href="{{ URL::to('teklifGor', array($firma->id,$ilan->id), false) }}">{{$ilan->adi}}</a></td>
                            @if($ilan->kismi_fiyat == 1 ) <!--Kismi Açık -->
                                <td>{{$ilan->kismi_acik_kazananlar->count() == 0 ? "" : $ilan->kismi_acik_kazananlar->last()->sonuclanma_tarihi}}</td>
                            @else<!--Kismi Kapali -->
                                <td>{{$ilan->kismi_kapali_kazananlar->count() == 0 ? "" : $ilan->kismi_kapali_kazananlar->last()->sonuclanma_tarihi}}</td>
                                @endif
                                <td>{{$ilan->teklifler->count() == 0 ? 0 : $ilan->teklifler[0]->firma_sayisi}}</td>

                                @if($ilan->kismi_fiyat == 1 )
                                    <td><strong> {{$ilan->kazanan_acik_toplam}}</strong> &#8378;</td>
                                    <td>Optimum Fiyat</td>
                                @else
                                    <td><strong> {{$ilan->kismi_kapali_kazananlar->count() == 0 ? "" : $ilan->kismi_kapali_kazananlar[0]->kazanan_fiyat}}</strong> &#8378;</td>
                                    <td>{{$ilan->kismi_kapali_kazananlar->count() == 0 ? "" : $ilan->kismi_kapali_kazananlar[0]->firma->adi}}</td>
                                @endif
                                <td>
                                    @if($ilan->kismi_fiyat == 1)
                                        <a href="{{ URL::to('teklifGor', array($firma->id,$ilan->id), false) }}"><button style="float:right;padding: 4px 12px;font-size:12px" type="button" class="btn btn-info add">İlanı Gör</button></a>
                                    @else
                                        <button style="float:right;padding: 4px 12px;font-size:12px" type="button" class="btn btn-info add btn-yorumYap" id="{{$i}}">Puan Ver/Yorum Yap</button>
                                    @endif
                                <div class="modal fade" id="modalForm{{$i}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div style="background-color: #fcf8e3;" class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                <h4 style="font-size:14px" class="modal-title" id="myModalLabel"><img src="{{asset('images/arrow.png')}}">&nbsp;<strong>Puanla/Yorum Yap</strong></h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="dialog" id="dialog{{$i++}}" style="display:none">
                                                    <?php $isDisabled = $ilan->puanlamalar->count() == 0 || $ilan->yorumlar->count() == 0 ? "" : "disabled"; ?>
                                                    {!! Form::open(array('url'=>'yorumPuan/'.$firma->id.'/'.$ilan->kismi_kapali_kazananlar->first()->kazanan_firma_id.'/'.$ilan->id.'/'.$kullanici_id,'method'=>'POST', 'files'=>true)) !!}
                                                    <div class="row col-lg-12">
                                                        <div class="col-lg-3">
                                                            <label1 name="kriter1">Ürün/hizmet kalitesi</label1>
                                                            <div id="puanlama">
                                                                <div class="sliders" id="k{{$i}}" {{$isDisabled}}></div>
                                                                <input type="hidden" id="puan1" name="puan1" value="{{$ilan->puanlamalar[0] ? $ilan->puanlamalar[0]->kriter1 : 5}}" {{$isDisabled}}/>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3" style="border-color:#ddd">
                                                            <label1 name="kriter2"><br>Teslimat</label1>
                                                            <div id="puanlama">
                                                                <div class="sliders" id="k{{$i+1}}" {{$isDisabled}}></div>
                                                                <input type="hidden" id="puan2" name="puan2" value="{{$ilan->puanlamalar[0] ? $ilan->puanlamalar[0]->kriter2 : 5}}" {{$isDisabled}}/>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <label1 name="kriter3">Teknik ve Yönetsel Yeterlilik</label1>
                                                            <div id="puanlama">
                                                                <div class="sliders" id="k{{$i+2}}" {{$isDisabled}}></div>
                                                                <input type="hidden" id="puan3" name="puan3" value="{{$ilan->puanlamalar[0] ? $ilan->puanlamalar[0]->kriter3 : 5}}" {{$isDisabled}}/>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <label1 name="kriter4">İletişim ve Esneklik</label1>
                                                            <div id="puanlama">
                                                                <div class="sliders" id="k{{$i+3}}" {{$isDisabled}}></div>
                                                                <input type="hidden" id="puan4" name="puan4" value="{{$ilan->puanlamalar[0] ? $ilan->puanlamalar[0]->kriter4 : 5}}" {{$isDisabled}}/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php $i=$i+3; ?>
                                                    <textarea name="yorum" placeholder="Yorum" cols="30" rows="5" wrap="soft" {{$isDisabled}}>{{$ilan->yorumlar[0] ? $ilan->yorumlar[0]->yorum : ""}}</textarea>
                                                    <input type="submit" value="Ok" {{$isDisabled}}/>
                                                    {{ Form::close() }}
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else

                        <p style="text-align:center">Henüz Sonuçlanmış İlanınız Bulunmamaktadır.</p>

                    @endif
                </div>
            </div>

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
                    <div class="table-scrollable table-scrollable-borderless">
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
<script>
    $(document).on('click', '.btn-yorumYap', function(){
        var j = $(this).attr('id');

        if ($(this).hasClass('active')){
            $('#dialog'+j).fadeOut(200);
            $(this).removeClass('active');
        } else {
            $('#modalForm'+j).modal('show');
            $('#dialog'+j).delay(300).fadeIn(200);
            $(this).addClass('active');
        }
    });

$(document).ready( function() {
    $('[data-toggle="tooltip"]').tooltip();

    function closeMenu(){
      $('.dialog').fadeOut(200);
      $('.add').removeClass('active');
    }

    $(document.body).click( function(e) {
         closeMenu();
    });

    $(".dialog").click( function(e) {
        e.stopPropagation();
    });
    var sliders = document.getElementsByClassName('sliders');
    var connect = document.getElementsByClassName('noUi-connect');
    var tooltip = document.getElementsByClassName('noUi-tooltip');
    var value = document.getElementsByClassName('value');
    for ( var i = 0; i < sliders.length; i++ ) {
        noUiSlider.create(sliders[i], {
                start: $(".sliders").eq(i).siblings("input").attr("value"),
                step:1,
                connect: [true, false],
                range: {
                        'min':[1],
                        'max':[10]
                },
                format: wNumb({
                    decimals:0
                }),
                tooltips:true

        });
        var deneme;
        sliders[i].noUiSlider.on('slide', function( values, handle ,e){
            var idCount=$(this.target.id).selector;
            idCount=idCount.substring(1);
            console.log($(this));
            deneme = values[handle];
            deneme = parseInt(deneme);
            if(idCount % 5 === 1){
                $("#puan1").val(deneme);
            }
            else if(idCount % 5 === 2){
                $("#puan2").val(deneme);
            }
            else if(idCount % 5 === 3){
                $("#puan3").val(deneme);
            }
            else if(idCount % 5 === 4){
                $("#puan4").val(deneme);
            }
            idCount = parseInt(idCount)-1;
            if(deneme <= 4){
                connect[idCount].style.backgroundColor = "#e65100";
                tooltip[idCount].style.backgroundColor = "#e65100";
                tooltip[idCount].style.border = "1px solid #e65100";
            }
            else if(deneme === 5){
                connect[idCount].style.backgroundColor = "#e54100";
                tooltip[idCount].style.backgroundColor = "#e54100";
                tooltip[idCount].style.backgroundColor = "#e54100";
            }
            else if(deneme === 6){
                connect[idCount].style.backgroundColor = "#f46f02";
                tooltip[idCount].style.backgroundColor = "#f46f02";
                tooltip[idCount].style.border = "1px solid #f46f02";
            }
            else if(deneme === 7){
                connect[idCount].style.backgroundColor = "#ffba04";
                tooltip[idCount].style.backgroundColor = "#ffba04";
                tooltip[idCount].style.border = "1px solid #ffba04";
            }
            else if(deneme === 8){
                connect[idCount].style.backgroundColor = "#d6d036";
                tooltip[idCount].style.backgroundColor = "#d6d036";
                tooltip[idCount].style.border = "1px solid #d6d036";
            }
            else if(deneme === 9){
                connect[idCount].style.backgroundColor = "#a5c530";
                tooltip[idCount].style.backgroundColor = "#a5c530";
                tooltip[idCount].style.border = "1px solid #a5c530";
            }
            else if(deneme === 10){
                connect[idCount].style.backgroundColor = "#45c538";
                tooltip[idCount].style.backgroundColor = "#45c538";
                tooltip[idCount].style.border = "1px solid #45c538";
            }
        });
    }
});
</script>
@endsection


@section('sayfaSonu')
    <script src="{{asset('MetronicFiles/global/plugins/ion.rangeslider/js/ion.rangeSlider.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/global/plugins/bootstrap-table/bootstrap-table.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/pages/scripts/table-bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/global/plugins/counterup/jquery.waypoints.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/global/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
@endsection