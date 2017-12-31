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
@if($ilan->sozlesme_turu==1)
    {{--Götürü Bedel Olma Şartı--}}

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
                                            @foreach($telifHareketDetay->teklifler->getTeklifDetayGoturu() as $goturuKalemDetay)
                                                <tr>
                                                    <td>
                                                        {{$kalem_count++}}
                                                    </td>
                                                    <td>
                                                        {{$goturuKalemDetay->ilan_goturu_bedeller->kalem_adi}}
                                                    </td>
                                                    <td>
                                                        {{$goturuKalemDetay->ilan_goturu_bedeller->miktar}}
                                                    </td>
                                                    <td>
                                                        % {{$goturuKalemDetay->kdv_orani}}
                                                    </td>
                                                    <td>
                                                        {{number_format($goturuKalemDetay->kdv_haric_fiyat, 2, ',', '.')}}{{$para_birimi}}
                                                    </td>
                                                    <td>
                                                        {{number_format($goturuKalemDetay->kdv_dahil_fiyat, 2, ',', '.')}}{{$para_birimi}}
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
                                                            @if(!$ilan->goturuKazanBelirlenmisMi())
                                                                {{--kazanan belirlenmemişse kazananı belirle butonu--}}
                                                                <form method="POST" action="{{asset("KazananBelirleGoturuBedel")}}" class="goturu_bedel_kazanan_belirle">
                                                                    <input type="hidden" name="ilanID" value="{{$ilan->id}}">
                                                                    <input type="hidden" name="firmaID" value="{{$telifHareketDetay->teklifler->firmalar->id}}">
                                                                    <input type="hidden" name="kdv_dahil_fiyat" value="{{$telifHareketDetay->kdv_dahil_fiyat}}">
                                                                    <button type="submit" id="KazananGoturuBedel_{{$index}}" class="btn purple-sharp btn-outline sbold uppercase btn-circle " style="float: right">
                                                                        Kazanan Olarak Belirle <i class="icon-trophy"></i>
                                                                    </button>
                                                                </form>
                                                            @else
                                                                {{--kazanan firmaya kupa diğerlerine X ikonu--}}
                                                                @if($ilan->goturuKazananFirmaId() == $telifHareketDetay->teklifler->firmalar->id)
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
                                                            @if(!$ilan->goturuKazanBelirlenmisMi())
                                                                {{--kazanan belirlenmemişse--}}
                                                                <i class="icon-question theme-font"></i> Kazanan Henüz Belirlenmedi
                                                            @else
                                                                {{--kazanan firmaya kupa diğerine X ikonu--}}
                                                                @if($ilan->goturuKazananFirmaId() == $telifHareketDetay->teklifler->firmalar->id)
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

                    <p>
                        İlan Türü: {{$ilan->getIlanTuru()}} <br />
                        Sözleşme Türü: {{$ilan->getSozlesmeTuru()}}<br />
                        İlan Kapanma Tarihi: {{date('d-m-Y', strtotime($ilan->kapanma_tarihi))}}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(".goturu_bedel_kazanan_belirle").submit(function(e) {
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
            @foreach($ilan->goturuKazananFirmalar() as $kazananFirmalar)
                    $("#firma_row_{{$kazananFirmalar->kazanan_firma_id}}").html('<i class="icon-trophy theme-font"></i> Kazandı');
            @endforeach
        });
    </script>

@elseif($ilan->kismi_fiyat==0 && $ilan->sozlesme_turu == 0)
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
                                                                    <button type="submit" class="btn purple-sharp btn-outline sbold uppercase btn-circle " style="float: right">
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
                                                                <button type="submit" class="btn purple-sharp btn-outline sbold uppercase btn-circle " style="float: right">
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
                                                                    <button type="submit" class="btn purple-sharp btn-outline sbold uppercase btn-circle " style="float: right">
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
                                                                        <button type="submit" class="btn purple-sharp btn-outline sbold uppercase btn-circle ">
                                                                           <i class="icon-trophy"></i> Belirle
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
                                                                        <button type="submit" class="btn purple-sharp btn-outline sbold uppercase btn-circle ">
                                                                            <i class="icon-trophy"></i> Belirle
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
                                                                        <button type="submit" class="btn purple-sharp btn-outline sbold uppercase btn-circle ">
                                                                            <i class="icon-trophy"></i> Belirle
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
@endif