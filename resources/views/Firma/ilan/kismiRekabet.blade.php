<?php
use Barryvdh\Debugbar\Facade as Debugbar;$puanNumber = 0; ?>
<style>
    .kismiRekabet-loader {
        visibility: hidden;
        background-color: rgba(255,255,255,0.7);
        position: absolute;
        z-index: +100 !important;
        width: 100%;
        height:100%;
    }

    .kismiRekabet-loader img {
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
</style>
@if($ilan->kismi_fiyat==0 && $ilan->sozlesme_turu == 0)
    {{--Kısmi Fiyat Kapalı ve Birim Fiyatlı Olma Şartı--}}
    <div class="portlet light ">

        <div class="portlet-title">
            <div class="caption caption-md">
                <i class="icon-list theme-font"></i>
                <span class="caption-subject theme-font bold uppercase">Teklif Veren Firmaların Listesi</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="portlet-body">
                <div id="accordion1" class="panel-group">
                    @if($ilan->ilan_turu == 1)
                        {{--İlan Türü: Mal, Kısmi Teklife Kapalı, Birim Fiyatlı
                            Rekabet sekmesindeki teklif veren firmalar ve detaylı kalem bilgileri listelenir
                            Kazanan Belirlenir    --}}
                        <?php $index = 1; ?>
                        @foreach($teklifler as $telifHareketDetay)
                            <div class="panel panel-default">
                                <div class="panel-heading accordion-toggle" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1_{{$index}}">
                                    <h4 class="panel-title">
                                        <div class="row">
                                            <div class="panel-title col-md-6">
                                                @if($ilan->firma_id == session()->get('firma_id') || $telifHareketDetay->teklifler->firmalar->id == session()->get('firma_id'))
                                                    {{--Sayfayı görüntüleyen kişi;
                                                    *ilan sahibi ise tüm tekliflerin firmalarını görebilir
                                                    *teklif sahibi ise sadece kendi teklifini görebilir
                                                    --}}
                                                <a href="javascript:;"> {{$index}}. {{$telifHareketDetay->teklifler->firmalar->adi}} </a>
                                                @else
                                                    <a href="javascript:;"> {{$index}}. X Firması </a>
                                                @endif
                                            </div>
                                            <div class="panel-title col-md-4">
                                                Toplam Teklif: {{number_format($telifHareketDetay->kdv_dahil_fiyat, 2, ',', '.')}}{{$para_birimi}}
                                            </div>
                                            <div class="panel-title col-md-2" id="firma_row_{{$telifHareketDetay->teklifler->firmalar->id}}"></div>
                                        </div>
                                    </h4>
                                </div>
                                <div id="accordion1_{{$index}}" class="panel-collapse collapse">
                                    <div class="panel-body"><h4>Teklifin Kalem Detayları:</h4>

                                        <table class="table" style="margin-bottom:0px">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kalem Adı</th>
                                                <th>Miktar</th>
                                                <th>KDV</th>
                                                <th>Birim Fiyat</th>
                                                <th>Teklif</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $kalem_count=1; ?>
                                            @foreach($telifHareketDetay->teklifler->getTeklifDetayMal() as $malKalemDetay)
                                                <tr>
                                                    <td>
                                                        {{$kalem_count++}}
                                                    </td>
                                                    <td>
                                                        {{$malKalemDetay->ilan_mallar->kalem_adi}}
                                                    </td>
                                                    <td>
                                                        {{$malKalemDetay->ilan_mallar->miktar}}
                                                    </td>
                                                    <td>
                                                        % {{$malKalemDetay->kdv_orani}}
                                                    </td>
                                                    <td>
                                                        {{number_format($malKalemDetay->kdv_haric_fiyat, 2, ',', '.')}}{{$para_birimi}}
                                                    </td>
                                                    <td>
                                                        {{number_format($malKalemDetay->kdv_dahil_fiyat, 2, ',', '.')}}{{$para_birimi}}
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td colspan="3">Teklif Tarihi: {{date('G:i d/m/Y', strtotime($telifHareketDetay->tarih))}}</td>
                                                <td colspan="3" class="kazanan" id="kazanan_firma_{{$telifHareketDetay->teklifler->firmalar->id}}">
                                                    @if($ilan->firma_id == session()->get('firma_id'))
                                                        @if($ilan->kapanma_tarihi < $dt)
                                                            {{--ilan sahibi ve ilan kapanmışsa--}}
                                                            @if(!$ilan->kisKapaliKazanBelirlenmisMi())
                                                                {{--kazanan belirlenmemişse kazananı belirle butonu--}}
                                                                <form method="POST" action="{{asset("KazananBelirleKismiKapali")}}" class="kismi_kapali_kazanan_belirle">
                                                                    <input type="hidden" name="ilanID" value="{{$ilan->id}}">
                                                                    <input type="hidden" name="firmaID" value="{{$telifHareketDetay->teklifler->firmalar->id}}">
                                                                    <input type="hidden" name="kdv_dahil_fiyat" value="{{$telifHareketDetay->kdv_dahil_fiyat}}">
                                                                    <button type="submit" id="KazananKisKapali_{{$index}}" class="btn purple-sharp btn-outline sbold uppercase btn-circle " style="float: right">
                                                                        Kazanan Olarak Belirle <i class="icon-trophy"></i>
                                                                    </button>
                                                                </form>
                                                            @else
                                                                {{--kazanan firmaya kupa diğerlerine X ikonu--}}
                                                                @if($ilan->kisKapaliKazananFirmaId() == $telifHareketDetay->teklifler->firmalar->id)
                                                                    <i class="icon-trophy theme-font"></i> Kazandı
                                                                @else
                                                                    <i class="icon-close theme-font"></i> Kaybetti
                                                                @endif
                                                            @endif
                                                        @else
                                                            {{--ilan sahibi ve ilan kapanmamışsa--}}
                                                            <i class="icon-question theme-font"></i> Kazananı Henüz Belirleyemezsin
                                                        @endif
                                                    @else
                                                        @if($ilan->kapanma_tarihi < $dt)
                                                            {{--ilan sahibi değil ve ilan kapanmışsa--}}
                                                            @if(!$ilan->kisKapaliKazanBelirlenmisMi())
                                                                {{--kazanan belirlenmemişse--}}
                                                                <i class="icon-question theme-font"></i> Kazanan Henüz Belirlenmedi
                                                            @else
                                                                {{--kazanan firmaya kupa diğerine X ikonu--}}
                                                                @if($ilan->kisKapaliKazananFirmaId() == $telifHareketDetay->teklifler->firmalar->id)
                                                                    <i class="icon-trophy theme-font"></i> Kazandı
                                                                @else
                                                                    <i class="icon-close theme-font"></i> Kaybetti
                                                                @endif
                                                            @endif
                                                        @else
                                                            {{--ilan sahibi değil ve ilan kapanmamışsa--}}
                                                            <i class="icon-question theme-font"></i> Kazanan Henüz Belirlenmedi
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <?php $index++; ?>
                            </div>
                        @endforeach

                    @elseif($ilan->ilan_turu == 2)
                        {{--İlan Türü: Hizmet, Kısmi Teklife Kapalı, Birim Fiyatlı
                            Rekabet sekmesindeki teklif veren firmalar ve detaylı kalem bilgileri listelenir
                            Kazanan Belirlenir    --}}
                        <?php $index = 1; ?>
                        @foreach($teklifler as $telifHareketDetay)
                        <div class="panel panel-default">
                            <div class="panel-heading accordion-toggle" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1_{{$index}}">
                                <h4 class="panel-title">
                                    <div class="row">
                                        <div class="panel-title col-md-6">
                                            @if($ilan->firma_id == session()->get('firma_id') || $telifHareketDetay->teklifler->firmalar->id == session()->get('firma_id'))
                                                {{--Sayfayı görüntüleyen kişi;
                                                *ilan sahibi ise tüm tekliflerin firmalarını görebilir
                                                *teklif sahibi ise sadece kendi teklifini görebilir
                                                --}}
                                                <a href="javascript:;"> {{$index}}. {{$telifHareketDetay->teklifler->firmalar->adi}} </a>
                                            @else
                                                <a href="javascript:;"> {{$index}}. X Firması </a>
                                            @endif
                                        </div>
                                        <div class="panel-title col-md-4">
                                            Toplam Teklif: {{number_format($telifHareketDetay->kdv_dahil_fiyat, 2, ',', '.')}}{{$para_birimi}}
                                        </div>
                                        <div class="panel-title col-md-2" id="firma_row_{{$telifHareketDetay->teklifler->firmalar->id}}"></div>
                                    </div>
                                </h4>
                            </div>
                            <div id="accordion1_{{$index}}" class="panel-collapse collapse">
                                <div class="panel-body"><h4>Teklifin Kalem Detayları:</h4>

                                    <table class="table" style="margin-bottom:0px">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kalem Adı</th>
                                            <th>Miktar</th>
                                            <th>KDV</th>
                                            <th>Birim Fiyat</th>
                                            <th>Teklif</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $kalem_count=1; ?>
                                        @foreach($telifHareketDetay->teklifler->getTeklifDetayHizmet() as $hizmetKalemDetay)
                                        <tr>
                                            <td>
                                                {{$kalem_count++}}
                                            </td>
                                            <td>
                                                {{$hizmetKalemDetay->ilan_hizmetler->kalem_adi}}
                                            </td>
                                            <td>
                                                {{$hizmetKalemDetay->ilan_hizmetler->miktar}}
                                            </td>
                                            <td>
                                                % {{$hizmetKalemDetay->kdv_orani}}
                                            </td>
                                            <td>
                                                {{number_format($hizmetKalemDetay->kdv_haric_fiyat, 2, ',', '.')}}{{$para_birimi}}
                                            </td>
                                            <td>
                                                {{number_format($hizmetKalemDetay->kdv_dahil_fiyat, 2, ',', '.')}}{{$para_birimi}}
                                            </td>
                                        </tr>
                                        @endforeach

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="3">Teklif Tarihi: {{date('G:i d/m/Y', strtotime($telifHareketDetay->tarih))}}</td>
                                            <td colspan="3" class="kazanan" id="kazanan_firma_{{$telifHareketDetay->teklifler->firmalar->id}}">
                                                @if($ilan->firma_id == session()->get('firma_id'))
                                                    @if($ilan->kapanma_tarihi < $dt)
                                                        {{--ilan sahibi ve ilan kapanmışsa--}}
                                                        @if(!$ilan->kisKapaliKazanBelirlenmisMi())
                                                            {{--kazanan belirlenmemişse kazananı belirle butonu--}}
                                                            <form method="POST" action="{{asset("KazananBelirleKismiKapali")}}" class="kismi_kapali_kazanan_belirle">
                                                                <input type="hidden" name="ilanID" value="{{$ilan->id}}">
                                                                <input type="hidden" name="firmaID" value="{{$telifHareketDetay->teklifler->firmalar->id}}">
                                                                <input type="hidden" name="kdv_dahil_fiyat" value="{{$telifHareketDetay->kdv_dahil_fiyat}}">
                                                                <button type="submit" id="KazananKisKapali_{{$index}}" class="btn purple-sharp btn-outline sbold uppercase btn-circle " style="float: right">
                                                                    Kazanan Olarak Belirle <i class="icon-trophy"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            {{--kazanan firmaya kupa diğerlerine X ikonu--}}
                                                            @if($ilan->kisKapaliKazananFirmaId() == $telifHareketDetay->teklifler->firmalar->id)
                                                                <i class="icon-trophy theme-font"></i> Kazandı
                                                            @else
                                                                <i class="icon-close theme-font"></i> Kaybetti
                                                            @endif
                                                        @endif
                                                    @else
                                                        {{--ilan sahibi ve ilan kapanmamışsa--}}
                                                        <i class="icon-question theme-font"></i> Kazananı Henüz Belirleyemezsin
                                                    @endif
                                                @else
                                                    @if($ilan->kapanma_tarihi < $dt)
                                                        {{--ilan sahibi değil ve ilan kapanmışsa--}}
                                                        @if(!$ilan->kisKapaliKazanBelirlenmisMi())
                                                            {{--kazanan belirlenmemişse--}}
                                                            <i class="icon-question theme-font"></i> Kazanan Henüz Belirlenmedi
                                                        @else
                                                            {{--kazanan firmaya kupa diğerine X ikonu--}}
                                                            @if($ilan->kisKapaliKazananFirmaId() == $telifHareketDetay->teklifler->firmalar->id)
                                                                <i class="icon-trophy theme-font"></i> Kazandı
                                                            @else
                                                                <i class="icon-close theme-font"></i> Kaybetti
                                                            @endif
                                                        @endif
                                                    @else
                                                        {{--ilan sahibi değil ve ilan kapanmamışsa--}}
                                                        <i class="icon-question theme-font"></i> Kazanan Henüz Belirlenmedi
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <?php $index++; ?>
                        </div>
                        @endforeach

                    @elseif($ilan->ilan_turu == 3)
                        {{--İlan Türü: Yapım İşi, Kısmi Teklife Kapalı, Birim Fiyatlı
                            Rekabet sekmesindeki teklif veren firmalar ve detaylı kalem bilgileri listelenir
                            Kazanan Belirlenir    --}}
                        <?php $index = 1; ?>
                        @foreach($teklifler as $telifHareketDetay)
                            <div class="panel panel-default">
                                <div class="panel-heading accordion-toggle" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1_{{$index}}">
                                    <h4 class="panel-title">
                                        <div class="row">
                                            <div class="panel-title col-md-6">
                                                @if($ilan->firma_id == session()->get('firma_id') || $telifHareketDetay->teklifler->firmalar->id == session()->get('firma_id'))
                                                    {{--Sayfayı görüntüleyen kişi;
                                                    *ilan sahibi ise tüm tekliflerin firmalarını görebilir
                                                    *teklif sahibi ise sadece kendi teklifini görebilir
                                                    --}}
                                                    <a href="javascript:;"> {{$index}}. {{$telifHareketDetay->teklifler->firmalar->adi}} </a>
                                                @else
                                                    <a href="javascript:;"> {{$index}}. X Firması </a>
                                                @endif
                                            </div>
                                            <div class="panel-title col-md-4">
                                                Toplam Teklif: {{number_format($telifHareketDetay->kdv_dahil_fiyat, 2, ',', '.')}}{{$para_birimi}}
                                            </div>
                                            <div class="panel-title col-md-2" id="firma_row_{{$telifHareketDetay->teklifler->firmalar->id}}"></div>
                                        </div>
                                    </h4>
                                </div>
                                <div id="accordion1_{{$index}}" class="panel-collapse collapse">
                                    <div class="panel-body"><h4>Teklifin Kalem Detayları:</h4>
                                        <table class="table" style="margin-bottom:0px">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kalem Adı</th>
                                                <th>Miktar</th>
                                                <th>KDV</th>
                                                <th>Birim Fiyat</th>
                                                <th>Teklif</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $kalem_count=1; ?>
                                            @foreach($telifHareketDetay->teklifler->getTeklifDetayYapim() as $yapimKalemDetay)
                                                <tr>
                                                    <td>
                                                        {{$kalem_count++}}
                                                    </td>
                                                    <td>
                                                        {{$yapimKalemDetay->ilan_yapim_isleri->kalem_adi}}
                                                    </td>
                                                    <td>
                                                        {{$yapimKalemDetay->ilan_yapim_isleri->miktar}}
                                                    </td>
                                                    <td>
                                                        % {{$yapimKalemDetay->kdv_orani}}
                                                    </td>
                                                    <td>
                                                        {{number_format($yapimKalemDetay->kdv_haric_fiyat, 2, ',', '.')}}{{$para_birimi}}
                                                    </td>
                                                    <td>
                                                        {{number_format($yapimKalemDetay->kdv_dahil_fiyat, 2, ',', '.')}}{{$para_birimi}}
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td colspan="3">Teklif Tarihi: {{date('G:i d/m/Y', strtotime($telifHareketDetay->tarih))}}</td>
                                                <td colspan="3" class="kazanan" id="kazanan_firma_{{$telifHareketDetay->teklifler->firmalar->id}}">
                                                    @if($ilan->firma_id == session()->get('firma_id'))
                                                        @if($ilan->kapanma_tarihi < $dt)
                                                            {{--ilan sahibi ve ilan kapanmışsa--}}
                                                            @if(!$ilan->kisKapaliKazanBelirlenmisMi())
                                                                {{--kazanan belirlenmemişse kazananı belirle butonu--}}
                                                                <form method="POST" action="{{asset("KazananBelirleKismiKapali")}}" class="kismi_kapali_kazanan_belirle">
                                                                    <input type="hidden" name="ilanID" value="{{$ilan->id}}">
                                                                    <input type="hidden" name="firmaID" value="{{$telifHareketDetay->teklifler->firmalar->id}}">
                                                                    <input type="hidden" name="kdv_dahil_fiyat" value="{{$telifHareketDetay->kdv_dahil_fiyat}}">
                                                                    <button type="submit" id="KazananKisKapali_{{$index}}" class="btn purple-sharp btn-outline sbold uppercase btn-circle " style="float: right">
                                                                        Kazanan Olarak Belirle <i class="icon-trophy"></i>
                                                                    </button>
                                                                </form>
                                                            @else
                                                                {{--kazanan firmaya kupa diğerlerine X ikonu--}}
                                                                @if($ilan->kisKapaliKazananFirmaId() == $telifHareketDetay->teklifler->firmalar->id)
                                                                    <i class="icon-trophy theme-font"></i> Kazandı
                                                                @else
                                                                    <i class="icon-close theme-font"></i> Kaybetti
                                                                @endif
                                                            @endif
                                                        @else
                                                            {{--ilan sahibi ve ilan kapanmamışsa--}}
                                                            <i class="icon-question theme-font"></i> Kazananı Henüz Belirleyemezsin
                                                        @endif
                                                    @else
                                                        @if($ilan->kapanma_tarihi < $dt)
                                                            {{--ilan sahibi değil ve ilan kapanmışsa--}}
                                                            @if(!$ilan->kisKapaliKazanBelirlenmisMi())
                                                                {{--kazanan belirlenmemişse--}}
                                                                <i class="icon-question theme-font"></i> Kazanan Henüz Belirlenmedi
                                                            @else
                                                                {{--kazanan firmaya kupa diğerine X ikonu--}}
                                                                @if($ilan->kisKapaliKazananFirmaId() == $telifHareketDetay->teklifler->firmalar->id)
                                                                    <i class="icon-trophy theme-font"></i> Kazandı
                                                                @else
                                                                    <i class="icon-close theme-font"></i> Kaybetti
                                                                @endif
                                                            @endif
                                                        @else
                                                            {{--ilan sahibi değil ve ilan kapanmamışsa--}}
                                                            <i class="icon-question theme-font"></i> Kazanan Henüz Belirlenmedi
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <?php $index++; ?>
                            </div>
                        @endforeach
                    @endif
                    <br />
                    <p>
                    İlan Türü: {{$ilan->getIlanTuru()}} <br />
                    Fiyatlandırma Şekli: {{$ilan->getFytSekli()}}<br />
                    İlan Kapanma Tarihi: {{date('d-m-Y', strtotime($ilan->kapanma_tarihi))}}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(".kismi_kapali_kazanan_belirle").submit(function(e) {
            var postData = $(this).serialize();
            var formURL = $(this).attr('action');
            $.ajax(
                {
                    url : formURL,
                    type: "POST",
                    data : postData,
                    success:function(data, textStatus, jqXHR)
                    {
                        $(".kazanan").html('<i class="icon-close theme-font"></i> Kaybetti');
                        $("#kazanan_firma_"+data.kazanan_firma_id).html('<i class="icon-trophy theme-font"></i> Kazandı');
                        $("#firma_row_"+data.kazanan_firma_id).html('<i class="icon-trophy theme-font"></i> Kazandı');
                        e.preventDefault();
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        alert(textStatus + "," + errorThrown);
                    }
                });
            e.preventDefault();
        });

        $( document ).ready(function() {
            @foreach($ilan->kisKapaliKazananFirmalar() as $kazananFirmalar)
                    $("#firma_row_{{$kazananFirmalar->kazanan_firma_id}}").html('<i class="icon-trophy theme-font"></i> Kazandı');
            @endforeach
        });
    </script>
@elseif($ilan->kismi_fiyat==1 && $ilan->sozlesme_turu == 0)
    {{--Kısmi Fiyat Açık ve Birim Fiyatlı Olma Şartı--}}
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption caption-md">
                <i class="icon-list theme-font"></i>
                <span class="caption-subject theme-font bold uppercase">Teklif Verilen Kalemlerin Listesi</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="portlet-body">
                <div id="accordion1" class="panel-group">
                    @if($ilan->ilan_turu == 1)
                        {{--İlan Türü: Mal, Kısmi Teklife Açık, Birim Fiyatlı
                            Rekabet sekmesindeki teklif verilen kalemler ve detaylı firma bilgileri listelenir
                            Kazanan Belirlenir    --}}
                        <?php $index = 1; ?>
                        @foreach($ilan->ilan_mallar as $malKalem)
                            <div class="panel panel-default">
                                <div class="panel-heading accordion-toggle" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1_{{$index}}">
                                    <h4 class="panel-title">
                                        <div class="row">
                                            <div class="panel-title col-md-6">
                                                <a href="javascript:;"> {{$index}}. {{$malKalem->kalem_adi}} </a>
                                            </div>
                                            <div class="panel-title col-md-6">
                                                Miktar: {{$malKalem->miktar}} {{$malKalem->birimler->adi}}
                                            </div>
                                        </div>
                                    </h4>
                                </div>
                                <div id="accordion1_{{$index}}" class="panel-collapse collapse">
                                    <div class="panel-body"><h4>Kalemin Teklif Detayları:</h4>
                                        <table class="table" style="margin-bottom:0px">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Firma Adı</th>
                                                <th>KDV</th>
                                                <th>Birim Fiyat</th>
                                                <th>Teklif</th>
                                                <th>Kazanan</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $teklif_count=1; ?>
                                            @foreach($malKalem->getMalTeklifDetay() as $malTeklif)
                                                <tr id="row_{{$malKalem->kalem_id}}_{{$malTeklif->teklifler->firmalar->id}}">
                                                    <td>{{$teklif_count++}}</td>
                                                    <td>
                                                        @if($ilan->firma_id == session()->get('firma_id') || $malTeklif->teklifler->firmalar->id == session()->get('firma_id'))
                                                            {{--Sayfayı görüntüleyen kişi;
                                                            *ilan sahibi ise tüm tekliflerin firmalarını görebilir
                                                            *teklif sahibi ise sadece kendi teklifini görebilir
                                                            --}}
                                                            {{$malTeklif->teklifler->firmalar->adi}}
                                                        @else
                                                            X Firması
                                                        @endif
                                                    </td>
                                                    <td>%{{$malTeklif->kdv_orani}}</td>
                                                    <td>{{number_format($malTeklif->kdv_haric_fiyat, 2, ',', '.')}}{{$para_birimi}}</td>
                                                    <td>{{number_format($malTeklif->kdv_dahil_fiyat, 2, ',', '.')}}{{$para_birimi}}</td>
                                                    <td align="center" id="kalem_{{$malKalem->kalem_id}}_firma_{{$malTeklif->teklifler->firmalar->id}}" class="kalem_{{$malKalem->kalem_id}}">
                                                        @if($ilan->firma_id == session()->get('firma_id'))
                                                            @if($ilan->kapanma_tarihi < $dt)
                                                                {{--ilan sahibi ve ilan kapanmışsa--}}
                                                                @if(!$malKalem->kisKazanBelirlenmisMi())
                                                                    {{--kazanan belirlenmemişse kazananı belirle butonu--}}

                                                                    <form method="POST" action="{{asset("KazananBelirleKismiAcik")}}" class="kismi_acik_kazanan_belirle">
                                                                        <input type="hidden" name="ilanID" value="{{$ilan->id}}">
                                                                        <input type="hidden" name="kalemID" value="{{$malKalem->kalem_id}}">
                                                                        <input type="hidden" name="firmaID" value="{{$malTeklif->teklifler->firmalar->id}}">
                                                                        <input type="hidden" name="kdv_dahil_fiyat" value="{{$malTeklif->kdv_dahil_fiyat}}">
                                                                        <button type="submit" id="KazananKisKapali_{{$index}}" class="btn purple-sharp btn-outline sbold uppercase btn-circle ">
                                                                           <i class="icon-trophy"></i>
                                                                        </button>
                                                                    </form>
                                                                @else
                                                                    {{--kazanan firmaya kupa diğerlerine X ikonu--}}
                                                                    @if($malKalem->kisKazananFirmaId() == $malTeklif->teklifler->firmalar->id)
                                                                        <i class="icon-trophy theme-font"></i> Kazandı
                                                                    @else
                                                                        <i class="icon-close theme-font"></i> Kaybetti
                                                                    @endif
                                                                @endif
                                                            @else
                                                                {{--ilan sahibi ve ilan kapanmamışsa--}}
                                                                <i class="icon-question theme-font"></i>
                                                            @endif
                                                        @else
                                                            @if($ilan->kapanma_tarihi < $dt)
                                                                {{--ilan sahibi değil ve ilan kapanmışsa--}}
                                                                @if(!$malKalem->kisKazanBelirlenmisMi())
                                                                    {{--kazanan belirlenmemişse--}}
                                                                    <i class="icon-question theme-font"></i>
                                                                @else
                                                                    {{--kazanan firmaya kupa diğerine X ikonu--}}
                                                                    @if($malKalem->kisKazananFirmaId() == $malTeklif->teklifler->firmalar->id)
                                                                        <i class="icon-trophy theme-font"></i> Kazandı
                                                                    @else
                                                                        <i class="icon-close theme-font"></i> Kaybetti
                                                                    @endif
                                                                @endif
                                                            @else
                                                                {{--ilan sahibi değil ve ilan kapanmamışsa--}}
                                                                <i class="icon-question theme-font"></i>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php $index++; ?>
                            </div>
                        @endforeach
                    @elseif($ilan->ilan_turu == 2)
                        {{--İlan Türü: Hizmet, Kısmi Teklife Açık, Birim Fiyatlı
                            Rekabet sekmesindeki teklif verilen kalemler ve detaylı firma bilgileri listelenir
                            Kazanan Belirlenir    --}}
                        <?php $index = 1; ?>
                        @foreach($ilan->ilan_hizmetler as $hizmetKalem)
                            <div class="panel panel-default">
                                <div class="panel-heading accordion-toggle" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1_{{$index}}">
                                    <h4 class="panel-title">
                                        <div class="row">
                                            <div class="panel-title col-md-6">
                                                <a href="javascript:;"> {{$index}}. {{$hizmetKalem->kalem_adi}} </a>
                                            </div>
                                            <div class="panel-title col-md-6">
                                                Miktar: {{$hizmetKalem->miktar}} {{$hizmetKalem->birimler->adi}}
                                            </div>
                                        </div>
                                    </h4>
                                </div>
                                <div id="accordion1_{{$index}}" class="panel-collapse collapse">
                                    <div class="panel-body"><h4>Kalemin Teklif Detayları:</h4>
                                        <table class="table" style="margin-bottom:0px">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Firma Adı</th>
                                                <th>KDV</th>
                                                <th>Birim Fiyat</th>
                                                <th>Teklif</th>
                                                <th>Kazanan</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $teklif_count=1; Debugbar::info($hizmetKalem->getHizmetTeklifDetay());?>

                                            @foreach($hizmetKalem->getHizmetTeklifDetay() as $hizmetTeklif)
                                                <tr id="row_{{$hizmetKalem->kalem_id}}_{{$hizmetTeklif->teklifler->firmalar->id}}">
                                                    <td>{{$teklif_count++}}</td>
                                                    <td>
                                                        @if($ilan->firma_id == session()->get('firma_id') || $hizmetTeklif->teklifler->firmalar->id == session()->get('firma_id'))
                                                            {{--Sayfayı görüntüleyen kişi;
                                                            *ilan sahibi ise tüm tekliflerin firmalarını görebilir
                                                            *teklif sahibi ise sadece kendi teklifini görebilir
                                                            --}}
                                                            {{$hizmetTeklif->teklifler->firmalar->adi}}
                                                        @else
                                                            X Firması
                                                        @endif
                                                    </td>
                                                    <td>%{{$hizmetTeklif->kdv_orani}}</td>
                                                    <td>{{number_format($hizmetTeklif->kdv_haric_fiyat, 2, ',', '.')}}{{$para_birimi}}</td>
                                                    <td>{{number_format($hizmetTeklif->kdv_dahil_fiyat, 2, ',', '.')}}{{$para_birimi}}</td>
                                                    <td align="center" id="kalem_{{$hizmetKalem->kalem_id}}_firma_{{$hizmetTeklif->teklifler->firmalar->id}}" class="kalem_{{$hizmetKalem->kalem_id}}">
                                                        @if($ilan->firma_id == session()->get('firma_id'))
                                                            @if($ilan->kapanma_tarihi < $dt)
                                                                {{--ilan sahibi ve ilan kapanmışsa--}}
                                                                @if(!$hizmetKalem->kisKazanBelirlenmisMi())
                                                                    {{--kazanan belirlenmemişse kazananı belirle butonu--}}

                                                                    <form method="POST" action="{{asset("KazananBelirleKismiAcik")}}" class="kismi_acik_kazanan_belirle">
                                                                        <input type="hidden" name="ilanID" value="{{$ilan->id}}">
                                                                        <input type="hidden" name="kalemID" value="{{$hizmetKalem->kalem_id}}">
                                                                        <input type="hidden" name="firmaID" value="{{$hizmetTeklif->teklifler->firmalar->id}}">
                                                                        <input type="hidden" name="kdv_dahil_fiyat" value="{{$hizmetTeklif->kdv_dahil_fiyat}}">
                                                                        <button type="submit" id="KazananKisKapali_{{$index}}" class="btn purple-sharp btn-outline sbold uppercase btn-circle ">
                                                                            <i class="icon-trophy"></i>
                                                                        </button>
                                                                    </form>
                                                                @else
                                                                    {{--kazanan firmaya kupa diğerlerine X ikonu--}}
                                                                    @if($hizmetKalem->kisKazananFirmaId() == $hizmetTeklif->teklifler->firmalar->id)
                                                                        <i class="icon-trophy theme-font"></i> Kazandı
                                                                    @else
                                                                        <i class="icon-close theme-font"></i> Kaybetti
                                                                    @endif
                                                                @endif
                                                            @else
                                                                {{--ilan sahibi ve ilan kapanmamışsa--}}
                                                                <i class="icon-question theme-font"></i>
                                                            @endif
                                                        @else
                                                            @if($ilan->kapanma_tarihi < $dt)
                                                                {{--ilan sahibi değil ve ilan kapanmışsa--}}
                                                                @if(!$hizmetKalem->kisKazanBelirlenmisMi())
                                                                    {{--kazanan belirlenmemişse--}}
                                                                    <i class="icon-question theme-font"></i>
                                                                @else
                                                                    {{--kazanan firmaya kupa diğerine X ikonu--}}
                                                                    @if($hizmetKalem->kisKazananFirmaId() == $hizmetTeklif->teklifler->firmalar->id)
                                                                        <i class="icon-trophy theme-font"></i> Kazandı
                                                                    @else
                                                                        <i class="icon-close theme-font"></i> Kaybetti
                                                                    @endif
                                                                @endif
                                                            @else
                                                                {{--ilan sahibi değil ve ilan kapanmamışsa--}}
                                                                <i class="icon-question theme-font"></i>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php $index++; ?>
                            </div>
                        @endforeach
                    @elseif($ilan->ilan_turu == 3)
                        {{--İlan Türü: Yapım İşi, Kısmi Teklife Açık, Birim Fiyatlı
                            Rekabet sekmesindeki teklif verilen kalemler ve detaylı firma bilgileri listelenir
                            Kazanan Belirlenir    --}}
                        <?php $index = 1; ?>
                        @foreach($ilan->ilan_yapim_isleri as $yapimIsiKalem)
                            <div class="panel panel-default">
                                <div class="panel-heading accordion-toggle" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1_{{$index}}">
                                    <h4 class="panel-title">
                                        <div class="row">
                                            <div class="panel-title col-md-6">
                                                    <a href="javascript:;"> {{$index}}. {{$yapimIsiKalem->kalem_adi}} </a>
                                            </div>
                                            <div class="panel-title col-md-6">
                                                Miktar: {{$yapimIsiKalem->miktar}} {{$yapimIsiKalem->birimler->adi}}
                                            </div>
                                        </div>
                                    </h4>
                                </div>
                                <div id="accordion1_{{$index}}" class="panel-collapse collapse">
                                    <div class="panel-body"><h4>Kalemin Teklif Detayları:</h4>
                                        <table class="table" style="margin-bottom:0px">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Firma Adı</th>
                                                <th>KDV</th>
                                                <th>Birim Fiyat</th>
                                                <th>Teklif</th>
                                                <th>Kazanan</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $teklif_count=1; ?>
                                            @foreach($yapimIsiKalem->getYapimIsiTeklifDetay() as $yapimIsiTeklif)
                                                <tr id="row_{{$yapimIsiKalem->kalem_id}}_{{$yapimIsiTeklif->teklifler->firmalar->id}}">
                                                    <td>{{$teklif_count++}}</td>
                                                    <td>
                                                        @if($ilan->firma_id == session()->get('firma_id') || $yapimIsiTeklif->teklifler->firmalar->id == session()->get('firma_id'))
                                                            {{--Sayfayı görüntüleyen kişi;
                                                            *ilan sahibi ise tüm tekliflerin firmalarını görebilir
                                                            *teklif sahibi ise sadece kendi teklifini görebilir
                                                            --}}
                                                            {{$yapimIsiTeklif->teklifler->firmalar->adi}}
                                                        @else
                                                            X Firması
                                                        @endif
                                                    </td>
                                                    <td>%{{$yapimIsiTeklif->kdv_orani}}</td>
                                                    <td>{{number_format($yapimIsiTeklif->kdv_haric_fiyat, 2, ',', '.')}}{{$para_birimi}}</td>
                                                    <td>{{number_format($yapimIsiTeklif->kdv_dahil_fiyat, 2, ',', '.')}}{{$para_birimi}}</td>
                                                    <td align="center" id="kalem_{{$yapimIsiKalem->kalem_id}}_firma_{{$yapimIsiTeklif->teklifler->firmalar->id}}" class="kalem_{{$yapimIsiKalem->kalem_id}}">
                                                        @if($ilan->firma_id == session()->get('firma_id'))
                                                            @if($ilan->kapanma_tarihi < $dt)
                                                                {{--ilan sahibi ve ilan kapanmışsa--}}
                                                                @if(!$yapimIsiKalem->kisKazanBelirlenmisMi())
                                                                    {{--kazanan belirlenmemişse kazananı belirle butonu--}}

                                                                    <form method="POST" action="{{asset("KazananBelirleKismiAcik")}}" class="kismi_acik_kazanan_belirle">
                                                                        <input type="hidden" name="ilanID" value="{{$ilan->id}}">
                                                                        <input type="hidden" name="kalemID" value="{{$yapimIsiKalem->kalem_id}}">
                                                                        <input type="hidden" name="firmaID" value="{{$yapimIsiTeklif->teklifler->firmalar->id}}">
                                                                        <input type="hidden" name="kdv_dahil_fiyat" value="{{$yapimIsiTeklif->kdv_dahil_fiyat}}">
                                                                        <button type="submit" id="KazananKisKapali_{{$index}}" class="btn purple-sharp btn-outline sbold uppercase btn-circle ">
                                                                            <i class="icon-trophy"></i>
                                                                        </button>
                                                                    </form>
                                                                @else
                                                                    {{--kazanan firmaya kupa diğerlerine X ikonu--}}
                                                                    @if($yapimIsiKalem->kisKazananFirmaId() == $yapimIsiTeklif->teklifler->firmalar->id)
                                                                        <i class="icon-trophy theme-font"></i> Kazandı
                                                                    @else
                                                                        <i class="icon-close theme-font"></i> Kaybetti
                                                                    @endif
                                                                @endif
                                                            @else
                                                                {{--ilan sahibi ve ilan kapanmamışsa--}}
                                                                <i class="icon-question theme-font"></i>
                                                            @endif
                                                        @else
                                                            @if($ilan->kapanma_tarihi < $dt)
                                                                {{--ilan sahibi değil ve ilan kapanmışsa--}}
                                                                @if(!$yapimIsiKalem->kisKazanBelirlenmisMi())
                                                                    {{--kazanan belirlenmemişse--}}
                                                                    <i class="icon-question theme-font"></i>
                                                                @else
                                                                    {{--kazanan firmaya kupa diğerine X ikonu--}}
                                                                    @if($yapimIsiKalem->kisKazananFirmaId() == $yapimIsiTeklif->teklifler->firmalar->id)
                                                                        <i class="icon-trophy theme-font"></i> Kazandı
                                                                    @else
                                                                        <i class="icon-close theme-font"></i> Kaybetti
                                                                    @endif
                                                                @endif
                                                            @else
                                                                {{--ilan sahibi değil ve ilan kapanmamışsa--}}
                                                                <i class="icon-question theme-font"></i>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php $index++; ?>
                            </div>
                        @endforeach
                    @endif
                    <br />
                    <p>
                        İlan Türü: {{$ilan->getIlanTuru()}} <br />
                        Fiyatlandırma Şekli: {{$ilan->getFytSekli()}}<br />
                        İlan Kapanma Tarihi: {{date('d-m-Y', strtotime($ilan->kapanma_tarihi))}}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(".kismi_acik_kazanan_belirle").submit(function(e) {
            var postData = $(this).serialize();
            var formURL = $(this).attr('action');
            $.ajax(
                {
                    url : formURL,
                    type: "POST",
                    data : postData,
                    success:function(data, textStatus, jqXHR)
                    {
                        $(".kalem_"+data.kalem_id).html('<i class="icon-close theme-font"></i> Kaybetti');
                        $("#kalem_"+data.kalem_id+"_firma_"+data.kazanan_firma_id).html('<i class="icon-trophy theme-font"></i> Kazandı');
                        $("#row_"+data.kalem_id+"_"+data.kazanan_firma_id).addClass("success");
                        e.preventDefault();
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        alert(textStatus + "," + errorThrown);
                    }
                });
            e.preventDefault();
        });
        $( document ).ready(function() {
            @foreach($ilan->kisAcikKazananFirmalar() as $kazananFirmalar)
                    $("#row_{{$kazananFirmalar->kalem_id}}_{{$kazananFirmalar->kazanan_firma_id}}").addClass("success");
            @endforeach
        });
    </script>
@elseif(false)
    @if($ilan->ilan_turu == 1 && $ilan->sozlesme_turu == 0)
    <h3>Fiyat İstenen Kalemler Rekabet Listesi</h3>
       <table class="table" style="border-collapse:collapse;" >
                <thead>
                    <tr>
                        <th width="6%">Sıra:</th>
                        <th width="9%">Marka:</th>
                        <th width="9%">Model:</th>
                        <th width="9%">Adı:</th>
                        <th width="9%">Ambalaj:</th>
                        <th width="4%">Miktar:</th>
                        <th width="9%">Birim:</th>
                    </tr>
                </thead>
                    <?php
                    $kismiCount =1;
                    $kullanici_id=Auth::user()->id;?>

                    @foreach($ilan->ilan_mallar as $ilan_mal)

                    <tr style="background-color:#e6e0d4 "data-toggle="collapse" data-target="#kalem{{$kismiCount}}" class="accordion-toggle">
                        <td>
                            {{$kismiCount}}
                        </td>
                        <td>
                            {{$ilan_mal->marka}}
                        </td>
                        <td>
                            {{$ilan_mal->model}}
                        </td>
                        <td>
                            {{$ilan_mal->adi}}
                        </td>
                        <td>
                            {{$ilan_mal->ambalaj}}
                        </td>
                        <td>
                            {{$ilan_mal->miktar}}
                        </td>
                        <td>
                            {{$ilan_mal->birimler->adi}}
                        </td>
                        <input type="hidden" name="ilan_mal_id[]"  id="ilan_mal_id" value="{{$ilan_mal->id}}">
                    </tr>
                    <tr>
                        <td colspan="8" class="hiddenRow">
                            <div class="accordian-body collapse" id="kalem{{$kismiCount}}">
                                                                                        <!--Mal kalemleri çekme sorgusu -->
                                <?php $malIdCount=1;?>
                                <table class="table table-light">
                                    <thead>
                                        <tr>
                                            <th >Sıra:</th>
                                            <th >Firma:</th>
                                            <th >KDV:</th>
                                            <th >Birim Fiyat:</th>
                                            <th >Toplam:</th>
                                        </tr>
                                    </thead>

                                        @foreach($ilan_mal->malIdTeklifler($ilan_mal->id,$ilan->id) as $malIdTeklif)

                                        @if($ilan_mal->kisKazanCount() == 1 && $ilan_mal->kisKazananFirmaId() == $ilan_mal->getFirmaId($malIdTeklif->teklif_id))
                                            <tr data-toggle="collapse" data-target="#kalem{{$kismiCount}}" class="accordion-toggle kismiKazanan">
                                        @else
                                            <tr data-toggle="collapse" data-target="#kalem{{$kismiCount}}" class="accordion-toggle">
                                        @endif
                                            @if(session()->get('firma_id') == $ilan_mal->getFirmaId($malIdTeklif->teklif_id)) <!--Teklifi veren firma ise -->
                                                <td class="highlight">
                                                    {{$malIdCount++}}
                                                </td>
                                                <td class="highlight">
                                                    {{$ilan_mal->getFirmaAdi($malIdTeklif->teklif_id)}}
                                                </td>
                                                <td class="highlight">
                                                    {{$malIdTeklif->kdv_orani}}
                                                </td>
                                                <td class="highlight">
                                                    {{$malIdTeklif->kdv_haric_fiyat}}
                                                </td>
                                                <td class="highlight currency2">
                                                    {{number_format($malIdTeklif->kdv_dahil_fiyat,2,'.','')}}
                                                </td>
                                            @elseif(session()->get('firma_id') == $ilan->firmalar->id)<!--İlan sahibi ise Kazananı belirlemek için -->
                                                <td>
                                                    {{$malIdCount++}}
                                                </td>
                                                <td>
                                                    {{$ilan_mal->getFirmaAdi($malIdTeklif->teklif_id)}}
                                                </td>
                                                <td>
                                                    {{$malIdTeklif->kdv_orani}}
                                                </td>
                                                <td>
                                                    {{$malIdTeklif->kdv_haric_fiyat}}
                                                </td>
                                                <td class="currency2">
                                                    {{number_format($malIdTeklif->kdv_dahil_fiyat,2,'.','')}}
                                                </td>

                                                @if($ilan->kapanma_tarihi > $dt)
                                                    <td><button name="kazanan" style="float:right" type="button" class="btn btn-info disabled" >Kazanan</button></td>
                                                @else
                                                    @if($ilan_mal->kisKazanCount() == 0)
                                                        <td><button  style="float:right" name="{{$malIdTeklif->ilan_mal_id}}_{{number_format($malIdTeklif->kdv_dahil_fiyat,2,'.','')}}" id="{{$ilan_mal->getFirmaId($malIdTeklif->teklif_id)}}" type="button" class="btn btn-info kazanan kazan{{$malIdTeklif->ilan_mal_id}}">Kazanan</button></td>
                                                    @elseif($ilan_mal->kisKazanCount() == 1 && $ilan_mal->kisKazananFirmaId() == $ilan_mal->getFirmaId($malIdTeklif->teklif_id))
                                                        <td>KAZANDI</td>
                                                        <?php $existYorum = $ilan->existsYorum($ilan_mal->getFirmaId($malIdTeklif->teklif_id));  ///////////// Daha önce yorum
                                                              $existPuan = $ilan->existsPuan($ilan_mal->getFirmaId($malIdTeklif->teklif_id)); ///////yapılmış mı onun kontrolü
                                                        ?>
                                                        @if(count($existPuan) != 0 || count($existYorum) != 0)
                                                            <td>
                                                           <a><button style="float:right;padding: 4px 12px;font-size:12px" type="button" class="btn btn-info add" id="{{$puanNumber}}">Puan Ver/Yorum Yap</button></a>
                                                        @endif
                                                            <div class="modal fade" id="myModalForm{{$puanNumber}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div style="background-color: #fcf8e3;" class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                            <h4 style="font-size:14px" class="modal-title" id="myModalLabel"><img src="{{asset('images/arrow.png')}}">&nbsp;<strong>Puanla/Yorum Yap</strong></h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="dialog" id="dialog{{$puanNumber++}}" style="display:none">

                                                                                {!! Form::open(array('url'=>'yorumPuan/'.$firma->id.'/'.$ilan_mal->getFirmaId($malIdTeklif->teklif_id).'/'.$ilan->id.'/'.$kullanici_id,'method'=>'POST', 'files'=>true)) !!}
                                                                                  <div class="row col-lg-12">
                                                                                    <div class="col-lg-3">
                                                                                        <label1 name="kriter1" type="text" >Ürün/hizmet kalitesi</label1>
                                                                                      <div id="puanlama">
                                                                                          <div class="sliders" id="k{{$puanNumber}}"></div>
                                                                                          <input type="hidden" id="puan1" name="puan1" value="5"/>
                                                                                      </div>
                                                                                    </div>
                                                                                    <div class="col-lg-3" style="border-color:#ddd">
                                                                                        <label1 name="kriter2" type="text"><br>Teslimat</label1>
                                                                                      <div id="puanlama">
                                                                                          <div class="sliders" id="k{{$puanNumber+1}}"></div>
                                                                                          <input type="hidden" id="puan2" name="puan2" value="5"/>
                                                                                      </div>
                                                                                    </div>
                                                                                    <div class="col-lg-3">
                                                                                        <label1 name="kriter3" type="text">Teknik ve Yönetsel Yeterlilik</label1>
                                                                                      <div id="puanlama">
                                                                                          <div class="sliders" id="k{{$puanNumber+2}}"></div>
                                                                                          <input type="hidden" id="puan3" name="puan3" value="5"/>
                                                                                      </div>
                                                                                    </div>
                                                                                    <div class="col-lg-3">
                                                                                        <label1 name="kriter4" type="text" >İletişim ve Esneklik</label1>
                                                                                      <div id="puanlama">
                                                                                          <div class="sliders" id="k{{$puanNumber+3}}"></div>
                                                                                          <input type="hidden" id="puan4" name="puan4" value="5"/>
                                                                                      </div>
                                                                                    </div>
                                                                                  </div>


                                                                                  <textarea name="yorum" placeholder="Yorum" cols="30" rows="5" wrap="soft"></textarea>
                                                                                  <input type="submit" value="Ok"/>
                                                                                {{ Form::close() }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td><?php $puanNumber=$puanNumber+3;?>
                                                        @endif
                                                    @endif

                                            @else
                                                <td>
                                                    {{$malIdCount++}}
                                                </td>
                                                <td>
                                                    X Firması
                                                </td>
                                                <td>
                                                    {{$malIdTeklif->kdv_orani}}
                                                </td>
                                                <td>
                                                    {{$malIdTeklif->kdv_haric_fiyat}}
                                                </td>
                                                <td class="currency2">
                                                    {{number_format($malIdTeklif->kdv_dahil_fiyat,2,'.','')}}
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </td>
                    </tr>
                    <?php $kismiCount=$kismiCount+1;?>
                @endforeach
        </table>
    @elseif($ilan->ilan_turu == 2 && $ilan->sozlesme_turu == 0)     <!--Hizmet Teklifler -->
        <h3>Fiyat İstenen Kalemler Rekabet Listesi</h3>
    <table class="table" style="border-collapse:collapse;" >
        <thead>
        <tr>
            <th>Sıra:</th>
            <th>Adı:</th>
            <th>Fiyat Standartı:</th>
            <th>Fiyat Standartı Birimi:</th>
            <th>Miktar:</th>
            <th>Miktar Birimi:</th>
        </tr>
        </thead>
        <?php $kismiCount =1;?>
        <?php $puanCount=0;  $i = 0;?>
        @foreach($ilan->ilan_hizmetler as $ilan_hizmet)

            <tr style="background-color:#e6e0d4 "data-toggle="collapse" data-target="#kalem{{$kismiCount}}" class="accordion-toggle">
                <td>
                    {{$kismiCount}}
                </td>
                <td>
                    {{$ilan_hizmet->kalem_adi}}
                </td>
                <td>
                    {{$ilan_hizmet->fiyat_standardi}}
                </td>
                <td>
                    {{$ilan_hizmet->fiyat_birimler->adi}}
                </td>
                <td>
                    {{$ilan_hizmet->miktar}}
                </td>
                <td>
                    {{$ilan_hizmet->miktar_birimler->adi}}
                </td>
            </tr>
            <tr>
                <td colspan="8" class="hiddenRow">
                    <div class="accordian-body collapse" id="kalem{{$kismiCount}}">
                        <!--Hizmet kalemleri çekme sorgusu -->
                        <?php  $hizmetIdCount=1; ?>
                        <table class="table table-light">
                            <thead>
                            <tr>
                                <th >Sıra:</th>
                                <th >Firma:</th>
                                <th >KDV:</th>
                                <th >Birim Fiyat:</th>
                                <th >Toplam:</th>
                            </tr>
                            </thead>

                            @foreach($ilan_hizmet->hizmetIdTeklifler($ilan->id) as $hizmetIdTeklif)

                                @if($ilan_hizmet->kisKazanCount() == 1 && $ilan_hizmet->kisKazananFirmaId() == $ilan_hizmet->getFirmaId($hizmetIdTeklif->teklif_id))
                                    <tr data-toggle="collapse" data-target="#kalem{{$kismiCount}}" class="accordion-toggle kismiKazanan">
                                @else
                                    <tr data-toggle="collapse" data-target="#kalem{{$kismiCount}}" class="accordion-toggle">
                                @endif

                                @if(session()->get('firma_id') == $ilan_hizmet->getFirmaId($hizmetIdTeklif->teklif_id)) <!--Teklifi veren firma ise -->
                                        <td class="highlight">
                                            @if($hizmetIdCount == 1)
                                                <img src="{{asset('images/rightOk.png')}}" width="40" height="20">
                                            @endif
                                            {{$hizmetIdCount++}}
                                        </td>
                                        <td class="highlight">
                                            {{$ilan_hizmet->getFirmaAdi($hizmetIdTeklif->teklif_id)}}
                                        </td>
                                        <td class="highlight">
                                            {{$hizmetIdTeklif->kdv_orani}}
                                        </td>
                                        <td class="highlight">
                                            {{$hizmetIdTeklif->kdv_haric_fiyat}}
                                        </td>
                                        <td class="highlight currency2">
                                            {{number_format($hizmetIdTeklif->kdv_dahil_fiyat,2,'.','')}}
                                        </td>
                                @elseif(session()->get('firma_id') == $ilan->firmalar->id)<!--İlan sahibi ise Kazananı belirlemek için -->
                                        <td>
                                            {{$hizmetIdCount++}}
                                        </td>
                                        <td>
                                            {{$ilan_hizmet->getFirmaAdi($hizmetIdTeklif->teklif_id)}}
                                        </td>
                                        <td>
                                            {{$hizmetIdTeklif->kdv_orani}}
                                        </td>
                                        <td>
                                            {{$hizmetIdTeklif->kdv_haric_fiyat}}
                                        </td>
                                        <td class="currency2">
                                            {{number_format($hizmetIdTeklif->kdv_dahil_fiyat,2,'.','')}}
                                        </td>
                                    @if($ilan->kapanma_tarihi > $dt)
                                            <td><button name="kazanan" style="float:right" type="button" class="btn btn-info disabled" >Kazanan</button></td>
                                    @else
                                        @if($ilan_hizmet->kisKazanCount() == 0)
                                                    <td><button  style="float:right" name="{{$hizmetIdTeklif->ilan_hizmet_id}}_{{number_format($hizmetIdTeklif->kdv_dahil_fiyat,2,'.','')}}" id="{{$ilan_hizmet->getFirmaId($hizmetIdTeklif->teklif_id)}}" type="button" class="btn btn-info kazanan kazan{{$hizmetIdTeklif->ilan_hizmet_id}}">Kazanan</button></td>
                                        @elseif($ilan_hizmet->kisKazanCount() == 1 && $ilan_hizmet->kisKazananFirmaId() == $ilan_hizmet->getFirmaId($hizmetIdTeklif->teklif_id))
                                                <td>KAZANDI</td>
                                                <?php $existYorum = $ilan->existsYorum($ilan_hizmet->getFirmaId($hizmetIdTeklif->teklif_id));  ///////////// Daha önce yorum
                                                $existPuan = $ilan->existsPuan($ilan_hizmet->getFirmaId($hizmetIdTeklif->teklif_id)); ///////yapılmış mı onun kontrolü
                                                ?>
                                            @if(count($existPuan) != 0 || count($existYorum) != 0)
                                                        <td>
                                                            <a><button style="float:right;padding: 4px 12px;font-size:12px" type="button" class="btn btn-info add" id="{{$puanNumber}}">Puan Ver/Yorum Yap</button></a>
                                            @endif
                                                        <div class="modal fade" id="myModalForm{{$puanNumber}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div style="background-color: #fcf8e3;" class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                        <h4 style="font-size:14px" class="modal-title" id="myModalLabel"><img src="{{asset('images/arrow.png')}}">&nbsp;<strong>Puanla/Yorum Yap</strong></h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="dialog" id="dialog{{$puanNumber++}}" style="display:none">

                                                                            {!! Form::open(array('url'=>'yorumPuan/'.$firma->id.'/'.$ilan_hizmet->getFirmaId($hizmetIdTeklif->teklif_id).'/'.$ilan->id.'/'.$kullanici_id,'method'=>'POST', 'files'=>true)) !!}
                                                                            <div class="row col-lg-12">
                                                                                <div class="col-lg-3">
                                                                                    <label1 name="kriter1" type="text" >Ürün/hizmet kalitesi</label1>
                                                                                    <div id="puanlama">
                                                                                        <div class="sliders" id="k{{$puanNumber}}"></div>
                                                                                        <input type="hidden" id="puan1" name="puan1" value="5"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-3" style="border-color:#ddd">
                                                                                    <label1 name="kriter2" type="text"><br>Teslimat</label1>
                                                                                    <div id="puanlama">
                                                                                        <div class="sliders" id="k{{$puanNumber+1}}"></div>
                                                                                        <input type="hidden" id="puan2" name="puan2" value="5"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-3">
                                                                                    <label1 name="kriter3" type="text">Teknik ve Yönetsel Yeterlilik</label1>
                                                                                    <div id="puanlama">
                                                                                        <div class="sliders" id="k{{$puanNumber+2}}"></div>
                                                                                        <input type="hidden" id="puan3" name="puan3" value="5"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-3">
                                                                                    <label1 name="kriter4" type="text" >İletişim ve Esneklik</label1>
                                                                                    <div id="puanlama">
                                                                                        <div class="sliders" id="k{{$puanNumber+3}}"></div>
                                                                                        <input type="hidden" id="puan4" name="puan4" value="5"/>
                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                            <textarea name="yorum" placeholder="Yorum" cols="30" rows="5" wrap="soft"></textarea>
                                                                            <input type="submit" value="Ok"/>
                                                                            {{ Form::close() }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td><?php $puanNumber=$puanNumber+3;?>
                                        @endif
                                    @endif
                                @else
                                    <td>
                                        {{$hizmetIdCount++}}
                                    </td>
                                    <td>
                                        X Firması
                                    </td>
                                    <td>
                                        {{$hizmetIdTeklif->kdv_orani}}
                                    </td>
                                    <td>
                                        {{$hizmetIdTeklif->kdv_haric_fiyat}}
                                    </td>
                                    <td class="currency2">
                                        {{number_format($hizmetIdTeklif->kdv_dahil_fiyat,2,'.','')}}
                                    </td>
                                @endif
                                    </tr>

                                @endforeach
                        </table>
                    </div>
                </td>
            </tr>
            <?php $kismiCount=$kismiCount+1;?>
        @endforeach
    </table>
    @elseif($ilan->ilan_turu == 3)  <!--Yapım İşi Teklifler -->
        <h3>Fiyat İstenen Kalemler Rekabet Listesi</h3>
       <table class="table" style="border-collapse:collapse;" >
                <thead>
                    <tr>
                        <th>Sıra:</th>
                        <th>Adı:</th>
                        <th>Miktar:</th>
                        <th>Birim:</th>
                    </tr>
                </thead>
                    <?php $kismiCount =1;?>
                    <?php $puanCount=0; $i = 0;?>
                    @foreach($ilan->ilan_yapim_isleri as $ilan_yapim_isi)

                    <tr style="background-color:#e6e0d4 "data-toggle="collapse" data-target="#kalem{{$kismiCount}}" class="accordion-toggle">
                        <td>
                            {{$kismiCount}}
                        </td>
                        <td>
                            {{$ilan_yapim_isi->adi}}
                        </td>
                        <td>
                            {{$ilan_yapim_isi->miktar}}
                        </td>
                        <td>
                            {{$ilan_yapim_isi->birimler->adi}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" class="hiddenRow">
                            <div class="accordian-body collapse" id="kalem{{$kismiCount}}">
                                <!--Hizmet kalemleri çekme sorgusu -->
                                <?php  $yapimIsiIdCount=1;?>
                                <table class="table table-light">
                                    <thead>
                                        <tr>
                                            <th >Sıra:</th>
                                            <th >Firma:</th>
                                            <th >KDV:</th>
                                            <th >Birim Fiyat:</th>
                                            <th >Toplam:</th>
                                        </tr>
                                    </thead>

                                    @foreach($ilan_yapim_isi->yapimIsiIdTeklifler($ilan->id) as $yapimIsiIdTeklif)

                                        @if($ilan_yapim_isi->kisKazanCount() == 1 && $ilan_yapim_isi->kisKazananFirmaId() == $ilan_yapim_isi->getFirmaId($yapimIsiIdTeklif->teklif_id))
                                            <tr data-toggle="collapse" data-target="#kalem{{$kismiCount}}" class="accordion-toggle kismiKazanan">
                                        @else
                                            <tr data-toggle="collapse" data-target="#kalem{{$kismiCount}}" class="accordion-toggle">
                                        @endif
                                        <tr data-toggle="collapse" data-target="#kalem{{$kismiCount}}" class="accordion-toggle">
                                            @if(session()->get('firma_id') == $ilan_yapim_isi->getFirmaId($yapimIsiIdTeklif->teklif_id)) <!--Teklifi veren firma ise -->
                                                <td class="highlight">
                                                    {{$yapimIsiIdCount++}}
                                                </td>
                                                <td class="highlight">
                                                    {{$ilan_yapim_isi->getFirmaAdi($yapimIsiIdTeklif->teklif_id)}}
                                                </td>
                                                <td class="highlight">
                                                    {{$yapimIsiIdTeklif->kdv_orani}}
                                                </td>
                                                <td class="highlight">
                                                    {{$yapimIsiIdTeklif->kdv_haric_fiyat}}
                                                </td>
                                                <td class="highlight currency2">
                                                    {{number_format($yapimIsiIdTeklif->kdv_dahil_fiyat,2,'.','')}}
                                                </td>
                                            @elseif(session()->get('firma_id') == $ilan->firmalar->id)<!--İlan sahibi ise Kazananı belirlemek için -->
                                                <td>
                                                    {{$yapimIsiIdCount++}}
                                                </td>
                                                <td>
                                                    {{$ilan_yapim_isi->getFirmaAdi($yapimIsiIdTeklif->teklif_id)}}
                                                </td>
                                                <td>
                                                    {{$yapimIsiIdTeklif->kdv_orani}}
                                                </td>
                                                <td>
                                                    {{$yapimIsiIdTeklif->kdv_haric_fiyat}}
                                                </td>
                                                <td class="currency2">
                                                    {{number_format($yapimIsiIdTeklif->kdv_dahil_fiyat,2,'.','')}}
                                                </td>
                                                @if($ilan->kapanma_tarihi > $dt)
                                                    <td><button name="kazanan" style="float:right" type="button" class="btn btn-info disabled" >Kazanan</button></td>
                                                @else
                                                    @if($ilan_yapim_isi->kisKazanCount() == 0)
                                                        <td><button  style="float:right" name="{{$yapimIsiIdTeklif->ilan_yapim_isleri_id}}_{{number_format($yapimIsiIdTeklif->kdv_dahil_fiyat,2,'.','')}}" id="{{$ilan_yapim_isi->getFirmaId($yapimIsiIdTeklif->teklif_id)}}" type="button" class="btn btn-info kazanan kazan{{$yapimIsiIdTeklif->ilan_yapim_isleri_id}}">Kazanan</button></td>
                                                    @elseif($ilan_yapim_isi->kisKazanCount() == 1 && $kazan->kazanan_firma_id == $ilan_yapim_isi->getFirmaId($yapimIsiIdTeklif->teklif_id))
                                                        <td>KAZANDI</td>
                                                        <?php $existYorum = $ilan->existsYorum($ilan_yapim_isi->getFirmaId($yapimIsiIdTeklif->teklif_id));  ///////////// Daha önce yorum
                                                              $existPuan = $ilan->existsPuan($ilan_yapim_isi->getFirmaId($yapimIsiIdCount->teklif_id)); ///////yapılmış mı onun kontrolü
                                                        ?>
                                                        @if(count($existPuan) != 0 || count($existYorum) != 0)
                                                            <td>
                                                                <a><button style="float:right;padding: 4px 12px;font-size:12px" type="button" class="btn btn-info add" id="{{$puanNumber}}">Puan Ver/Yorum Yap</button></a>
                                                        @endif <div class="modal fade" id="myModalForm{{$puanNumber}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div style="background-color: #fcf8e3;" class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                            <h4 style="font-size:14px" class="modal-title" id="myModalLabel"><img src="{{asset('images/arrow.png')}}">&nbsp;<strong>Puanla/Yorum Yap</strong></h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="dialog" id="dialog{{$puanNumber++}}" style="display:none">

                                                                                {!! Form::open(array('url'=>'yorumPuan/'.$firma->id.'/'.$ilan_yapim_isi->getFirmaId($yapimIsiIdTeklif->teklif_id).'/'.$ilan->id.'/'.$kullanici_id,'method'=>'POST', 'files'=>true)) !!}
                                                                                  <div class="row col-lg-12">
                                                                                    <div class="col-lg-3">
                                                                                        <label1 name="kriter1" type="text" >Ürün/hizmet kalitesi</label1>
                                                                                      <div id="puanlama">
                                                                                          <div class="sliders" id="k{{$puanNumber}}"></div>
                                                                                          <input type="hidden" id="puan1" name="puan1" value="5"/>
                                                                                      </div>
                                                                                    </div>
                                                                                    <div class="col-lg-3" style="border-color:#ddd">
                                                                                        <label1 name="kriter2" type="text"><br>Teslimat</label1>
                                                                                      <div id="puanlama">
                                                                                          <div class="sliders" id="k{{$puanNumber+1}}"></div>
                                                                                          <input type="hidden" id="puan2" name="puan2" value="5"/>
                                                                                      </div>
                                                                                    </div>
                                                                                    <div class="col-lg-3">
                                                                                        <label1 name="kriter3" type="text">Teknik ve Yönetsel Yeterlilik</label1>
                                                                                      <div id="puanlama">
                                                                                          <div class="sliders" id="k{{$puanNumber+2}}"></div>
                                                                                          <input type="hidden" id="puan3" name="puan3" value="5"/>
                                                                                      </div>
                                                                                    </div>
                                                                                    <div class="col-lg-3">
                                                                                        <label1 name="kriter4" type="text" >İletişim ve Esneklik</label1>
                                                                                      <div id="puanlama">
                                                                                          <div class="sliders" id="k{{$puanNumber+3}}"></div>
                                                                                          <input type="hidden" id="puan4" name="puan4" value="5"/>
                                                                                      </div>
                                                                                    </div>
                                                                                  </div>
                                                                                  <textarea name="yorum" placeholder="Yorum" cols="30" rows="5" wrap="soft"></textarea>
                                                                                  <input type="submit" value="Ok"/>
                                                                                {{ Form::close() }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                             </div>
                                                        </td><?php $puanNumber=$puanNumber+3;?>
                                                    @endif
                                                @endif
                                            @else
                                                <td>
                                                    {{$yapimIsiIdCount++}}
                                                </td>
                                                <td>
                                                    X Firması
                                                </td>
                                                <td>
                                                    {{$yapimIsiIdTeklif->kdv_orani}}
                                                </td>
                                                <td>
                                                    {{$yapimIsiIdTeklif->kdv_haric_fiyat}}
                                                </td>
                                                <td class="currency2">
                                                    {{number_format($yapimIsiIdTeklif->kdv_dahil_fiyat,2,'.','')}}
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </td>
                    </tr>
                    <?php $kismiCount=$kismiCount+1;?>
                @endforeach
        </table>
    @endif
@endif
<script>
    $(".kazanan").click(function(){
       var name=$(this).attr("name");
       var nameArray = name.split('_');
       var kalemId = nameArray[0];
       var kazananFiyat = nameArray[1];

       var kazananFirmaId=$(this).attr("id");
       var ilanID="{{$ilan->id}}";
       var successValue = $(this);
       if(confirm("Bu firmayı kazanan ilan etmek istediğinize emin misiniz ?")){
            $.ajax({
                type:"POST",
                url:"{{asset('KismiAcikKazanan')}}",
                data:{ilan_id:ilanID, kazananFirmaId:kazananFirmaId, kalem_id:kalemId ,kazanan_fiyat:kazananFiyat},
                cache: false,
                success: function(data){
                    console.log(data);
                    console.log(successValue.parent().parent());
                    alert(" Seçmiş Olduğunuz Kalemin Kazanını Kaydedildi!");
                    $('.kazan'+kalemId).hide();
                    $('.KapaliAcikRekabetKazanan').hide();
                    successValue.parent().parent().addClass("kismiKazanan");
                    successValue.parent().text("KAZANDI");
                }
            });
        }
        else{
            return false;
        }
    });

     $(document).ready(function() {
        for(var key=0; key<"{{$puanNumber}}"; key=key+4){
            $('#'+key).click(function(e){
                var j = $(this).attr('id');
              e.stopPropagation();
             if ($(this).hasClass('active')){
                $('#dialog'+j).fadeOut(200);
                $(this).removeClass('active');
             } else {
                $('#myModalForm'+j).modal('show');
                $('#dialog'+j).delay(300).fadeIn(200);
                $(this).addClass('active');
             }
           });
        }
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
        console.log(tooltip);
        var value = document.getElementsByClassName('value');
        for ( var i = 0; i < sliders.length; i++ ) {
            noUiSlider.create(sliders[i], {
                    start: 5,
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
