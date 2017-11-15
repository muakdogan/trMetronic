<?php
    use App\Adres;
    use App\Il;
    use App\Ilce;
    use App\IletisimBilgisi;
    use App\Semt;
?>
@extends('layouts.appUser')

@section('head')
    <style>
        .puanlama {
            background: #dddddd;
            width: 49px;
            height:59px;
            border-radius: 3px;
            position: relative;
            margin: auto;
            margin-left:8px;
            text-align: center;
            color: white;
            display:inline-block;

        }
        point {
            display: block;
            font-size: 26px;
            letter-spacing: -1px;
            margin-top: 0.1em;
            margin-bottom: 1em;
            margin-left: 0;
            margin-right: 0;
            font-weight: bold;

        }
    </style>
    <link href="{{asset('MetronicFiles/pages/css/profile.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')


    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script src="{{asset('js/jquery.multi-select.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('js/jquery.quicksearch.js')}}"></script>
    <script src="{{asset('js/multiple-select.js')}}"></script>
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

                        <!-- SIDEBAR USER TITLE -->
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name"> {{$firma->adi}} </div>
                        </div>
                        <!-- END SIDEBAR USER TITLE -->

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <h4 class="profile-desc-title theme-font" style="text-align: center;">Sektörler</h4>
                                <ul>
                                    @foreach($firmaSektorleri as $firmaSektor)
                                        <li style="border-bottom:1px solid #f0f4f7">{{$firmaSektor->adi}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-6 col-sm-6">

                                <div class="caption caption-md">
                                    <h4 class="profile-desc-title theme-font" style="text-align: center;">Profil Doluluk</h4>
                                </div>
                                <div class="easy-pie-chart">
                                    <div class="number transactions" data-percent="{{$firma->doluluk_orani}}">
                                        %<span>{{$firma->doluluk_orani}}</span></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="profile-usermenu">
                            <div   class="row" align="center">
                                <div class=" puanlama " >
                                    <span  class="test" data-toggle="tooltip" data-placement="bottom" title="Ürün/Hizmet Kalitesi" style="font-size:10px;letter-spacing: 1px;">Kalite</span><point class="point">{{number_format($firma->kalite_puan_ort,1)}}</point>
                                </div>
                                <div class=" puanlama " >
                                    <span class="test" data-toggle="tooltip" data-placement="bottom" title="Ürün Teslimatı" style="font-size:10px;letter-spacing: 1px;">Teslimat</span><point class="point">{{number_format($firma->teslimat_puan_ort,1)}}</point>
                                </div>
                                <div class="puanlama " >
                                    <span class="test" data-toggle="tooltip" data-placement="bottom" title="Teknik ve Yönetsel Yeterlilik" style="font-size:10px;letter-spacing: 1px;">Teknik</span><point class="point">{{number_format($firma->teknik_puan_ort,1)}}</point>
                                </div>
                                <div class=" puanlama  " >
                                    <span  class="test" data-toggle="tooltip" data-placement="bottom" title="İletişim ve Esneklik" style="font-size:10px;letter-spacing: 1px;">Esneklik</span><point class="point">{{number_format($firma->esneklik_puan_ort,1)}}</point>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PROFIL -->
                    <!-- BEGIN TANITIM -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="fa fa-pencil theme-font"></i>
                                <span class="caption-subject theme-font bold uppercase">Tanıtım Yazısı</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            @if($firma->tanitim_yazisi=="")
                                <span class="profile-desc-text">Henüz tanıtım yazısı eklenmemiş.</span>
                            @else
                                <span class="profile-desc-text">{{$firma->tanitim_yazisi}}</span>
                            @endif
                        </div>
                    </div>
                    <!-- END TANITIM -->
                    <!-- BEGIN MALI BILGILER -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-calculator theme-font"></i>
                                <span class="caption-subject theme-font bold uppercase">Mali Bilgiler</span>
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
                    </div>
                    <!-- END MALIBILGILER -->
                    <!-- BEGIN TICARI BILGILER -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-share theme-font"></i>
                                <span class="caption-subject theme-font bold uppercase">Ticari Bilgiler</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            @if(!$firma->ticari_bilgiler)
                                <span class="profile-desc-text">Henüz ticari bilgiler eklenmemiş.</span>
                            @else
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
                                            @foreach($firma->uretilen_markalar as $marka)
                                                {{$marka->adi}}
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Firmanın Sattığı Markalar</strong></td>
                                        <td>:
                                            @foreach($firma->firma_satilan_markalar as $satMarka)
                                                {{$satMarka->satilan_marka_adi}}
                                            @endforeach
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- END TICARI BILGILER -->
                </div>
                <div class="col-md-6">
                    <!-- BEGIN ILETISIM BILGILERI -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="fa fa-phone theme-font"></i>
                                <span class="caption-subject theme-font bold uppercase">İletişim Bilgileri</span>
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
                    </div>
                    <!-- END ILETISIM BILGILERI -->
                    <!-- BEGIN FIRMA BROSURU -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-picture theme-font"></i>
                                <span class="caption-subject theme-font bold uppercase">Firma Broşürü</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="portlet-body">
                                @if(!count($firma->firma_brosurler))
                                    <span class="profile-desc-text"> Henüz broşür eklenmemiş. </span>
                                @else
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-light">
                                            <tr>
                                                <th>Broşür Adı:</th>
                                                <th>Broşür Pdf:</th>
                                            </tr>
                                            @foreach($firma->firma_brosurler as $firmaBrosur)
                                                <tr>
                                                    <td>
                                                        {{$firmaBrosur->adi}}
                                                    </td>
                                                    <td>
                                                        <a  data-toggle="tooltip" title="PDF'i görüntülemek için tıklayınız!" target="_blank" href="{{ asset('brosur/'.$firmaBrosur->yolu) }}"><img src="{{asset('images/see.png')}}">{{$firmaBrosur->yolu}}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- END FIRMA BROSURU -->
                    <!-- BEGIN IDARI BILGILER -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-directions theme-font"></i>
                                <span class="caption-subject theme-font bold uppercase">İdari Bilgiler</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            @if($firma->firma_calisma_bilgileri==null)
                                <span class="profile-desc-text">Henüz idari bilgiler eklenmemiş.</span>
                            @else
                                <div class="table-scrollable table-scrollable-borderless">
                                    <table class="table table-light">
                                        <tr>
                                            <td><strong>Çalışma Günleri</strong></td>
                                            <td>:
                                                {{$firma->firma_calisma_bilgileri->calisma_gunleri->adi}}
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
                                                <?php
                                                $calisan_profili = $firma->getCalisanProfil();
                                                ?>
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
                    </div>
                    <!-- END IDARI BILGILER -->
                    <!-- BEGIN KALITE BELGELERI -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-graph theme-font"></i>
                                <span class="caption-subject theme-font bold uppercase">Kalite Belgeleri</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            @if(!count($firma->kalite_belgeleri))
                                <span class="profile-desc-text">Henüz kalite belgesi eklenmemiş.</span>
                            @else
                                <div class="table-scrollable table-scrollable-borderless">
                                    <table class="table table-light">
                                        <tr>
                                            <th>Kalite Belgesi:</th>
                                            <th>Belge NO:</th>
                                        </tr>
                                        @foreach($firma->kalite_belgeleri as $kalite_belgesi)
                                            <tr>
                                                <td id="kalite_id_td">
                                                    {{$kalite_belgesi->adi}}
                                                </td>
                                                <td>
                                                    {{$kalite_belgesi->pivot->belge_no}}
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
                                                            {!! Form::submit('Kaydet', array('url'=>'firmaProfili/kaliteGuncelle/'.$firma->id,'style'=>'float:right','class'=>'btn purple')) !!}

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
                    </div>
                    <!-- END KALITE BELGELERI -->
                    <!-- BEGIN REFERANSLAR -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-like theme-font"></i>
                                <span class="caption-subject theme-font bold uppercase">Referanslar</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            @if(!count($firma->firma_referanslar))
                                <span class="profile-desc-text">Henüz referans eklenmemiş.</span>
                            @else
                                @foreach($firma->firma_referanslar as $firmaReferans)
                                <!-- BEGIN Tekil Referans-->
                                    <div class="portlet box purple">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="icon-like"></i>
                                                {{$firmaReferans->adi}}
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
                                            </table>
                                        </div>
                                    </div>
                                    <!-- END Tekil Referans-->
                                @endforeach
                            @endif

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





































    <div class="row">
        <div   class="col-sm-3">
            <br>
            <br>
            <div class="row" align="center">
                <img src="{{asset('uploads')}}/{{$firma->logo}}" alt="HTML5 Icon" style="width: 128px;height:128px">
            </div>
            <br>
        </div>
        <div  id="exTab2"  class="col-sm-9">
            <ul class="nav nav-tabs">
                <li class="active"><a  href="#1" data-toggle="tab"> <strong>{{$firma->adi}}</strong> Firma Profili</a>
                </li>
                <li><a href="#2" data-toggle="tab">Onaylı Tedarikciler &nbsp; <span class="w3-badge w3-right w3-margin-right">{{$firma->onayliTedarikciler->count()}}</span></a>
                </li>
                <li><a href="#3" data-toggle="tab">Yorumlar &nbsp;
                        <?php $toplamYorum = $firma->yorumlar->count(); ?>
                        @if($toplamYorum==0)
                            <span class="w3-badge w3-right w3-margin-right">0</span>
                        @else
                            <span class="w3-badge w3-right w3-margin-right">{{$toplamYorum}}</span>
                        @endif
                    </a>
                </li>
            </ul>
            <div class="tab-content ">
                <div class="tab-pane active" id="1">
                    <br>
                    <div  class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div style="padding: 0px;" class="panel-body">
                                <h5 ><img src="{{asset('images/phone.png')}}">&nbsp;<strong>İletişim Bilgileri</strong></h5>
                                <table class="table" >
                                    <thead id="tasks-list" name="tasks-list">
                                    <tr>
                                        <td><strong>Adres</strong></td>
                                        <td><strong>:</strong>  {{$firma->adresler[0]->adres}}</td>

                                    </tr>
                                    <tr>
                                        <td width="25%"><strong>İli</strong></td>
                                        <td width="75%"><strong>:</strong>  {{$firma->adresler[0]->iller->adi}}</td>

                                    </tr>
                                    <tr>
                                        <td><strong>İlçesi</strong></td>
                                        <td><strong>:</strong>  {{$firma->adresler[0]->ilceler->adi}}</td>

                                    </tr>
                                    <tr>
                                        <td><strong>Semt</strong></td>
                                        <td><strong>:</strong>  {{$firma->adresler[0]->semtler->adi}}</td>

                                    </tr>
                                    <tr>
                                        <td><strong>Telefon</strong></td>
                                        <td><strong>:</strong>  {{$firma->iletisim_bilgileri->telefon}}</td>

                                    </tr>
                                    <tr>
                                        <td><strong>Fax</strong></td>
                                        <td><strong>:</strong>  {{$firma->iletisim_bilgileri->fax}}</td>

                                    </tr>
                                    <tr>
                                        <td><strong>Web Sayfası</strong></td>
                                        <td><strong>:</strong>  {{$firma->iletisim_bilgileri->web_sayfasi}}</td>

                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        @if($firma->tanitim_yazisi=="")
                        @else
                            <div class="panel panel-default">
                                <div style="padding: 0px;" class="panel-body">
                                    <h5><img src="{{asset('images/yazi.png')}}">&nbsp;<strong>Firma Tanıtım Yazısı</strong></h5>
                                    <table class="table" >
                                        <thead id="tasks-list" name="tasks-list">
                                        <tr id="firma{{$firma->id}}">
                                        <tr>
                                            <td width="25%"><strong>Tanıtım Yazısı</strong></td>
                                            <td width="75%"><strong>:</strong>
                                                <?php echo $firma->tanitim_yazisi; ?>
                                            </td>
                                        </tr>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <div class="panel panel-default">
                            <div style="padding: 0px;" class="panel-body">
                                <h5> <img src="{{asset('images/tl.png')}}">&nbsp;<strong>Ticari Bilgiler</strong></h5>
                                @if (!$firma->ticari_bilgiler)
                                @else
                                    <table class="table" >
                                        <thead id="tasks-list" name="tasks-list">
                                        <tr>
                                            <td width="25%"><strong>Ticaret Sicil No</strong></td>
                                            <td width="75%"><strong>:</strong>  {{$firma->ticari_bilgiler->tic_sicil_no}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Ticaret Odası</strong></td>
                                            <td><strong>:</strong>  {{$firma->ticari_bilgiler->ticaret_odalari->adi}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Üst Sektör</strong></td>
                                            <td><strong>:</strong> {{$firma->getUstSektor()}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Faliyet Sektör</strong></td>
                                            <td><strong>:</strong>@foreach($firma->sektorler as $sektor)
                                                    {{$sektor->adi}}
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Firma Departmanları</strong></td>
                                            <td><strong>:</strong>@foreach($firma->departmanlar as $departman)
                                                    {{$departman->adi}}
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kuruluş Tarihi</strong></td>
                                            @if($firma->kurulus_tarihi=="0000-00-00")
                                                <td><strong>:</strong> </td>
                                            @else
                                                <td><strong>:</strong> {{$firma->kurulus_tarihi}}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td><strong>Firma Faaliyet Türü</strong></td>
                                            <td><strong>:</strong>
                                                @foreach($firma->faaliyetler as $faaliyet)
                                                    {{$faaliyet->adi}}
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Firmanın Ürettiği Markalar</strong></td>
                                            <td><strong>:</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Firmanın Sattığı Markalar</strong></td>
                                            <td id="sattıgı_id_td"><strong>:</strong>
                                                @if(count($firma->firma_satilan_markalar) > 1)

                                                @endif
                                            </td>
                                        </tr>
                                        </thead>
                                    </table>
                                @endif
                            </div>
                        </div>

                        @if(!$firma->kalite_belgeleri)
                        @else
                            <div class="panel panel-default">
                                <div style="padding: 0px;" class="panel-body">
                                    <h5><img src="{{asset('images/kalite.png')}}">&nbsp;<strong>Kalite Belgeleri</strong></h5>

                                    <div class="panel-footer">
                                        <table class="table" >
                                            <thead id="tasks-list" name="tasks-list">
                                            <th>Kalite Belgesi:</th>
                                            <th>Belge NO:</th>

                                            @foreach($firma->kalite_belgeleri as $kalite_belgesi)
                                                <tr>
                                                    <td>
                                                        {{$kalite_belgesi->adi}}
                                                    </td>
                                                    <td>
                                                        {{$kalite_belgesi->pivot->belge_no}}
                                                    </td>

                                                </tr>
                                            @endforeach
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(!$firma->firma_referanslar)
                        @else
                            <div class="panel panel-default">
                                <div  style="padding: 0px;" class="panel-body">
                                    <h5><img src="{{asset('images/kalite.png')}}">&nbsp;<strong>Referanslar</strong></h5>

                                    <div class="panel-footer ">

                                        <table class="table" >
                                            <thead id="tasks-list" name="tasks-list">
                                            <tr id="firma{{$firma->id}}">
                                            <tr>
                                                <th>Firma Adı:</th>
                                                <th>Yapılan İşin Adı:</th>
                                                <th>İşin Türü:</th>
                                                <th>Çalişma Süresi:</th>
                                                <th>Yetkili Kişi Adı:</th>
                                                <th>Yetkili Kişi Email Adresi:</th>
                                                <th>Yetkili Kişi Telefon:</th>
                                                <th>Referans Türü:</th>
                                                <th>İş Yılı:</th>
                                                <th></th>
                                            </tr>
                                            @foreach($firma->firma_referanslar as $firmaReferans)
                                                <tr>
                                                    <td>
                                                        {{$firmaReferans->adi}}
                                                    </td>
                                                    <td>
                                                        {{$firmaReferans->is_adi}}
                                                    </td>
                                                    <td>
                                                        {{$firmaReferans->is_turu}}
                                                    </td>
                                                    <td>
                                                        {{$firmaReferans->calisma_suresi}}
                                                    </td>
                                                    <td>
                                                        {{$firmaReferans->yetkili_adi}}
                                                    </td>
                                                    <td>
                                                        {{$firmaReferans->yetkili_email}}
                                                    </td>
                                                    <td>
                                                        {{$firmaReferans->yetkili_telefon}}
                                                    </td>
                                                    <td>
                                                        {{$firmaReferans->ref_turu}}
                                                    </td>
                                                    <td>
                                                        @if($firmaReferans->is_yili=="0000-00-00")

                                                        @else
                                                            {{$firmaReferans->is_yili}}
                                                        @endif
                                                    </td>

                                                    <input type="hidden" name="ref_id"  id="ref_id" value="{{$firmaReferans->id}}">
                                                </tr>
                                            @endforeach

                                            </thead>
                                        </table>

                                        <input type="hidden" name="add"  id="add" value="add">
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(!$firma->firma_brosurler)

                        @else
                            <div class="panel panel-default">

                                <div style="padding: 0px;" class="panel-body">
                                    <h5><img src="{{asset('images/brosur.png')}}">&nbsp;<strong>Firma Broşürü</strong></h5>
                                    <table class="table" >
                                        <thead id="tasks-list" name="tasks-list">
                                        <th>Broşür Adı:</th>
                                        <th>Broşür Pdf:</th>

                                        @foreach($firma->firma_brosurler as $firmaBrosur)
                                            <tr>
                                                <td>
                                                    {{$firmaBrosur->adi}}
                                                </td>
                                                <td>
                                                    <a href="{{ asset('brosur/'.$firmaBrosur->yolu) }}">{{$firmaBrosur->yolu}}</a>
                                                </td>
                                                <td>

                                                    <input type="hidden" name="brosur_id"  id="brosur_id" value="{{$firmaBrosur->id}}">
                                            </tr>
                                        @endforeach
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        @endif

                        @if(!$firma->firma_calisma_bilgileri)

                        @else
                            <div class="panel panel-default">
                                <div style="padding: 0px;" class="panel-body">
                                    <h5><img src="{{asset('images/calisan.png')}}">&nbsp;<strong>Firma Çalışan Bilgileri</strong></h5>

                                    <table class="table" >
                                        <thead id="tasks-list" name="tasks-list">
                                        <tr id="firma{{$firma->id}}">
                                        <tr>
                                            <td width="25%"><strong>Çalışma Günleri</strong></td>
                                            <td width="75%"><strong>:</strong>  {{$firma->firma_calisma_bilgileri->calisma_gunleri->adi}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Çalışma Saatleri</strong></td>
                                            <td><strong>:</strong>  {{$firma->firma_calisma_bilgileri->calisma_saatleri}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Çalışan Profili</strong></td>
                                            <td><strong>:</strong>  {{$firma->firma_calisma_bilgileri->calisan_profili}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Çalışan Sayısı</strong></td>
                                            <td><strong>:</strong>  {{$firma->firma_calisma_bilgileri->calisan_sayisi}}</td>
                                        </tr>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        @endif
                        @if($firma->bilgilendirme_tercihi==null)
                        @else
                            <div class="panel panel-default">

                                <div  style="padding: 0px;" class="panel-body">
                                    <h5><strong><img src="{{asset('images/bilgilendirme.png')}}">&nbsp;Bilgilendirme Tercihi</strong></h5>

                                    <table class="table" >
                                        <thead id="tasks-list" name="tasks-list">
                                        <tr id="firma{{$firma->id}}">
                                        <tr>
                                            <td width="25%"><strong>Bilgilendirme Tercihi</strong></td>
                                            <td width="75%"><strong>:</strong>  {{$firma->bilgilendirme_tercihi}}</td>
                                        </tr>
                                        </tr>
                                        </thead>
                                    </table>

                                </div>
                            </div>
                        @endif
                    </div>

                </div>
                <div class="tab-pane" id="2">
                    <br>
                    @foreach($firma->onayliTedarikciler as $onayli)
                        <a href="{{url('firmaDetay/'.$onayli->id)}}" ><p>{{$onayli->adi}}</p></a>
                    @endforeach
                </div>
                <div class="tab-pane" id="3">
                    <br>
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div style="background-color:#ddd;border-color: #ddd" class="panel-heading">
                                <strong>Firmaya Yapılan Yorumlar &nbsp;
                                    @if($toplamYorum==0)

                                        (Henüz bu firma için yorum yapılmamıştır)
                                    @else
                                     ({{$toplamYorum}})
                                    @endif

                                </strong>
                            </div>
                            @foreach($yorumlar as $yorum)

                                <div style="border: 1px solid #ddd;" class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="col-sm-12" >
                                                <img src="{{asset('uploads')}}/{{$yorum->logo}}" alt="HTML5 Icon" style="width:50px;height:50px;">
                                                <strong>{{$yorum->adi}}</strong>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div  style="font-size:10px"class="col-sm-3">Kalite:{{$yorum->kriter1}}</div>
                                            <div style="font-size:10px" class="col-sm-3">Teslimat:{{$yorum->kriter2}}</div>
                                            <div style="font-size:10px" class="col-sm-3">Teknik:{{$yorum->kriter3}}</div>
                                            <div style="font-size:10px" class="col-sm-3">Esneklik:{{$yorum->kriter4}}</div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div style="float:right" class="col-sm-6" >{{$yorum->tarih}}</div>
                                        </div>
                                    </div>
                                    <div  style="text-align:center;"class="row">{{$yorum->yorum}}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
        });

        $(".puanlama").each(function(){
            
            var puan = $(this).children().next().text();
            if(puan > 0 && puan < 3){
                $(this).css("background", "#e65100");
            }
            else if (puan >= 3 && puan <= 5){
                $(this).css("background", "#e54100");
            }
            else if (puan > 5 && puan <= 6){
                $(this).css("background", "#f46f02");
            }
            else if (puan > 5 && puan <= 6){
                $(this).css("background", "#f46f02");
            }
            else if (puan > 6 && puan <= 7){
                $(this).css("background", "#ffba04");
            }
            else if (puan > 7 && puan <= 8){
                $(this).css("background", "#d6d036");
            }
            else if (puan > 8 && puan <= 9){
                $(this).css("background", "#a5c530");
            }
            else if (puan > 9 && puan <= 10){
                $(this).css("background", "#45c538");
            }
        });
    </script>
@endsection