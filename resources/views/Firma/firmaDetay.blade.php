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
            background: #1a001a;
            width: 50px;
            height:55px;
            position: relative;
            margin: 4px;
            text-align: center;
            color: white;
            display:inline-block;
        }
        point {
            display: block;
            font-size: 20px;
            letter-spacing: -1px;
            font-weight: bold;
        }
    </style>
    <link href="{{asset('MetronicFiles/pages/css/profile-2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('baslik')
    Firma Profili
@endsection
@section('content')


    <div class="row">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="col-md-12">
            <div class="profile">
                <div class="tabbable-line tabbable-full-width">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_1_1" data-toggle="tab"> Profil </a>
                        </li>
                        <li>
                            <a href="#tab_1_3" data-toggle="tab"> Onaylı Tedarikçiler </a>
                        </li>
                        <li>
                            <a href="#tab_1_6" data-toggle="tab"> Yorumlar &nbsp;
                                <?php $toplamYorum = $firma->yorumlar->count(); ?>
                                @if($toplamYorum==0)
                                    <span>0</span>
                                @else
                                    <span>{{$toplamYorum}}</span>
                                @endif</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1">
                            <div class="row">
                                <div class="col-md-3" style="text-align: center;">
                                    <ul class="list-unstyled profile-nav">
                                        <li>
                                            @if($firma->logo != "")
                                                <img src="{{asset('uploads')}}/{{$firma->logo}}" alt="Firma Logo" width="100%" class="img-responsive pic-bordered">
                                            @else
                                                <img src="{{asset('uploads/logo/defaultFirmaLogo.png')}}" alt="Firma Logo" width="100%" class="img-responsive pic-bordered"/>
                                            @endif
                                        </li>
                                    </ul>
                                    @if(session()->get('firma_id')!=$firma->id)
                                        @if(!$onaylimi)
                                            <button id="btn-tedEkle" value="{{$firma->id}}" type="button" class="btn btn-circle red"><i class="fa fa-star-half-o"></i> Onaylı Tedarikçilerime Ekle</button>
                                            <button id="btn-tedCikar" value="{{$firma->id}}" type="button" class="btn btn-circle red" style="display: none;"><i class="fa fa-star"></i> Onaylı Tedarikçilerimden Çıkar</button>
                                        @else

                                            <button id="btn-tedEkle" value="{{$firma->id}}" type="button" class="btn btn-circle red" style="display: none;"><i class="fa fa-star-half-o"></i> Onaylı Tedarikçilerime Ekle</button>
                                            <button id="btn-tedCikar" value="{{$firma->id}}" type="button" class="btn btn-circle red"><i class="fa fa-star"></i> Onaylı Tedarikçilerimden Çıkar</button>
                                        @endif
                                    @else
                                         <a href="{{asset('firmaProfili')}}" class="btn btn-circle red"><i class="fa fa-wrench"></i> Profilimi Düzenle</a>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-8 profile-info">
                                            <h1 class="theme-font sbold uppercase">{{$firma->adi}}</h1>

                                            <p> Adres: {{$firmaAdres->adres}} <br />
                                                {{$firmaAdres->semtler->adi}} / {{$firmaAdres->ilceler->adi}} / {{$firmaAdres->iller->adi}}
                                            </p>
                                            <ul class="list-inline">
                                                <li>
                                                    <i class="fa fa-globe"></i> Web: {{$firma->iletisim_bilgileri->web_sayfasi}} </li>
                                                <li>
                                                <li>
                                                    <i class="fa fa-phone"></i> Telefon: {{$firma->iletisim_bilgileri->telefon}} </li>
                                                <li>
                                                <li>
                                                    <i class="fa fa-fax"></i> Fax: {{$firma->iletisim_bilgileri->fax}} </li>
                                                <li>
                                            </ul>
                                        </div>
                                        <!--end col-md-8-->
                                        <div class="col-md-4">
                                            <div class="portlet sale-summary">
                                                <div class="portlet-title">
                                                    <div class="caption font-red sbold"> FİRMA DERECELERİ </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="puanlama">
                                                        <span data-toggle="tooltip" data-placement="bottom" title="Ürün/Hizmet Kalitesi" style="font-size:10px;letter-spacing: 1px;">Kalite</span><point class="point">{{number_format($firma->kalite_puan_ort,1)}}</point>
                                                    </div>
                                                    <div class="puanlama">
                                                        <span data-toggle="tooltip" data-placement="bottom" title="Ürün Teslimatı" style="font-size:10px;letter-spacing: 1px;">Teslimat</span><point class="point">{{number_format($firma->teslimat_puan_ort,1)}}</point>
                                                    </div>
                                                    <div class="puanlama">
                                                        <span data-toggle="tooltip" data-placement="bottom" title="Teknik ve Yönetsel Yeterlilik" style="font-size:10px;letter-spacing: 1px;">Teknik</span><point class="point">{{number_format($firma->teknik_puan_ort,1)}}</point>
                                                    </div>
                                                    <div class="puanlama">
                                                        <span data-toggle="tooltip" data-placement="bottom" title="İletişim ve Esneklik" style="font-size:10px;letter-spacing: 1px;">Esneklik</span><point class="point">{{number_format($firma->esneklik_puan_ort,1)}}</point>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="portlet sale-summary">
                                                <div class="portlet-title">
                                                    <div class="caption font-red sbold"> SEKTÖRLER </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <ul class="list-unstyled">
                                                        @foreach($firmaSektorleri as $firmaSektor)
                                                            <li ><span class="sale-info"> {{$firmaSektor->adi}} </span></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end col-md-4-->
                                    </div>
                                    <!--end row-->
                                </div>
                            </div>
                        </div>
                        <!--tab_1_2-->
                        <div class="tab-pane" id="tab_1_3">
                                    <!-- BEGIN FIRMANIN ONAYLI TEDARIKCILERI-->
                                    <div class="portlet box purple">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-star"></i>
                                                Bu Firmanın Onaylı Tedarikçileri
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="general-item-list">
                                                @if(count($firma->onayliTedarikciler))
                                                    @foreach($firma->onayliTedarikciler as $onayli)
                                                        <div class="item">
                                                            <div class="item-head">
                                                                <div class="item-details">
                                                                    @if($onayli->logo)
                                                                        <img width="50" height="50" class="item-pic rounded" src="{{asset('uploads')}}/{{$onayli->logo}}">
                                                                    @else
                                                                        <img width="50" height="50" class="item-pic rounded" src="{{asset('uploads/logo/defaultFirmaLogo.png')}}">
                                                                    @endif
                                                                    <a href="{{url('firmaDetay/'.$onayli->id)}}" class="item-name primary-link">{{$onayli->adi}}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    Henüz onaylı tedarikçisi yok.
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END FIRMANIN ONAYLI TEDARIKCILERI-->
                        </div>
                        <div class="tab-pane" id="tab_1_6">
                            <div class="portlet box purple">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-commenting"></i>
                                            Firmaya Yapılan Yorumlar ({{$toplamYorum}})
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <!-- BEGIN: Comments -->
                                    <div class="mt-comments">
                                        @if(!$yorumlar)
                                            Henüz bu firma için yorum yapılmamış.
                                        @else
                                        @foreach($yorumlar as $yorum)
                                            <div class="mt-comment">
                                                <div class="mt-comment-img">
                                                    <img width="50" height="50" src="{{asset('uploads')}}/{{$yorum->logo}}" />
                                                </div>
                                                <div class="mt-comment-body">
                                                    <div class="mt-comment-info"><a href="{{url('firmaDetay/'.$yorum->id)}}" class="item-name primary-link"><span class="mt-comment-author">{{$yorum->adi}}</span></a>

                                                        <span class="mt-comment-date">{{$yorum->tarih}}</span>
                                                    </div>
                                                    <div class="mt-comment-text"> {{$yorum->yorum}} </div>
                                                    <div class="mt-comment-details">
                                                    <span class="item-status">
                                                        <span class="badge badge-empty badge-success"></span>
                                                    Kalite:{{$yorum->kriter1}}
                                                        <span class="badge badge-empty badge-warning"></span>
                                                    Teslimat:{{$yorum->kriter2}}
                                                        <span class="badge badge-empty badge-danger"></span>
                                                    Teknik:{{$yorum->kriter3}}
                                                        <span class="badge badge-empty badge-primary"></span>
                                                    Esneklik:{{$yorum->kriter4}}
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                            @endif
                                    </div>
                                    <!-- END: Comments -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
        &nbsp;
            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="col-md-6">
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
@endsection

@section('sayfaSonu')
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
        @if(session()->get('firma_id')!=$firma->id)
        $('#btn-tedEkle').click(function () {
            var tedarikci_id="{{$firma->id}}";
            $.ajax({
                type:"GET",
                url:"{{asset('onayliTedarikciEkle')}}",
                data:{tedarikci_id:tedarikci_id},
                cache: false,
                success: function(data){
                    $('#btn-tedEkle').hide();
                    $('#btn-tedCikar').show();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
        });

        $("#btn-tedCikar").click(function () {
            var tedarikci_id="{{$firma->id}}";
            $.ajax({
                type:"GET",
                url:"{{asset('onayliTedarikciCikar')}}",
                data:{tedarikci_id:tedarikci_id},
                cache: false,
                success: function(data){
                    $('#btn-tedCikar').hide();
                    $('#btn-tedEkle').show();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
        });
        @endif
    </script>
@endsection