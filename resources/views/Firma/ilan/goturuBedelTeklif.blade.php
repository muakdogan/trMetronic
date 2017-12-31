<div  id="goturu">
    {{ Form::open(array('id'=>'teklifForm','url'=>'teklifGonder/'.$firma_id .'/'.$ilan->id.'/'.Auth::user()->id))}}
    <table class="table" >
        <thead id="tasks-list" name="tasks-list">
            <?php $i=1;?>
            <tr>
                <th width="4%">Sıra:</th>
                <th width="30%">Kalem Adı:</th>
                <th>Açıklama:</th>
                <th width="10%">Miktar</th>
                <th width="10%">Miktar Türü:</th>
                @if(session()->get('firma_id') != $ilan->firmalar->id) <!-- ilan sahibi ise teklif vermemesi için bu butonların kaldırıyorum. -->
                <th width="20%">KDV Oranı:</th>
                <th width="25%">Fiyat:</th>
                <th width="1%"></th>
                <th width="10%">Toplam:({{$para_birimi}})</th>
                @endif
            </tr>
            @foreach($ilan->ilan_goturu_bedeller as $ilan_goturu_bedel)
                @if(count($teklif) != 0)
                    <?php $goturuBedelTeklif = $ilan_goturu_bedel->getGoturuBedelTeklif($ilan_goturu_bedel->id,$teklif[0]["id"]); ?>
                @endif
                <tr>
                    <td>
                        {{$i++}}
                    </td>

                    <td>
                        {{$ilan_goturu_bedel->kalem_adi}}
                    </td>
                    <td>
                        {{$ilan_goturu_bedel->aciklama}}
                    </td>
                    <td>
                        {{$ilan_goturu_bedel->miktar}}
                    </td>
                    <td>
                        {{$ilan_goturu_bedel->miktar_birimler->adi}}
                    </td>


                @if(session()->get('firma_id') != $ilan->firmalar->id) <!-- ilan sahibi ise teklif vermemesi için bu butonların kaldırıyorum. -->
                    <td>
                        <select style="margin-top: 0px" class="select kdv" name="kdv[]" id="kdv{{$i-2}}"  required>
                            @if(count($teklif)!=0 && count($goturuBedelTeklif) != 0)
                                @if($goturuBedelTeklif[0]['kdv_orani'] == 0)
                                    <option value="-1" hidden>Seçiniz</option>
                                    <option value="0"  selected>%0</option>
                                    <option value="1">%1</option>
                                    <option value="8" >%8</option>
                                    <option value="18">%18</option>
                                @elseif($goturuBedelTeklif[0]['kdv_orani'] == 1)
                                    <option value="-1" hidden>Seçiniz</option>
                                    <option value="0">%0</option>
                                    <option value="1" selected>%1</option>
                                    <option value="8">%8</option>
                                    <option value="18">%18</option>
                                @elseif($goturuBedelTeklif[0]['kdv_orani'] == 8)
                                    <option value="-1" hidden>Seçiniz</option>
                                    <option value="0">%0</option>
                                    <option value="1">%1</option>
                                    <option value="8" selected>%8</option>
                                    <option value="18">%18</option>
                                @elseif($goturuBedelTeklif[0]['kdv_orani'] == 18)
                                    <option value="-1" hidden>Seçiniz</option>
                                    <option value="0">%0</option>
                                    <option value="1">%1</option>
                                    <option value="8">%8</option>
                                    <option value="18" selected>%18</option>
                                @endif
                            @else
                                <option value="-1" selected hidden>Seçiniz</option>
                                <option value="0">%0</option>
                                <option value="1">%1</option>
                                <option value="8">%8</option>
                                <option value="18">%18</option>
                            @endif
                        </select>
                    </td>
                    <td>
                        @if(count($teklif)!=0 && count($goturuBedelTeklif) != 0)
                            <input id="visible_miktar#{{$i-1}}" idd="{{$i-1}}" style="margin-top: 0px" align="right"  type="text" class="form-control fiyat kdvsizFiyat" value="{{$teklifler[0]->paraFormat($goturuBedelTeklif[0]['kdv_haric_fiyat'])}}" onkeypress="return isNumberKey(event)" required>
                            <input id="miktar#{{$i-1}}" type="hidden" name="birim_fiyat[]" value="{{$goturuBedelTeklif[0]['kdv_haric_fiyat']}}" />
                            <label class="control-label toplam">Eski Teklif: {{$teklifler[0]->paraFormat($goturuBedelTeklif[0]['kdv_haric_fiyat'])}}</label>
                        @else
                            <input id="visible_miktar#{{$i-1}}" idd="{{$i-1}}" style="margin-top: 0px" align="right" type="text" class="form-control fiyat kdvsizFiyat" value="0,00" onkeypress="return isNumberKey(event)" required>
                            <input id="miktar#{{$i-1}}" type="hidden" name="birim_fiyat[]" value="0" />
                        @endif
                    </td>
                    <td></td><!-- Fiyat hesaplaması için gerekli -->
                    <td>
                        @if(count($teklif)!=0 && count($goturuBedelTeklif) != 0)
                            <span align="right" class="kalem_toplam" name="kalem_toplam" class="col-sm-3">{{$teklifler[0]->paraFormat($goturuBedelTeklif[0]['kdv_dahil_fiyat'])}}</span>
                            <input type="hidden" name="kalem_toplam[]"  id="kalem_toplam" value="{{$goturuBedelTeklif[0]['kdv_dahil_fiyat']}}">
                        @else
                            <span align="right" class="kalem_toplam" name="kalem_toplam" class="col-sm-3">0,00</span>
                            <input type="hidden" name="kalem_toplam[]"  id="kalem_toplam" value="">
                        @endif
                    </td>
                    <input type="hidden" name="ilan_goturu_bedel_id[]"  id="ilan_goturu_bedel_id" value="{{$ilan_goturu_bedel->id}}">
                    @endif
                </tr>
            @endforeach
            @if(session()->get('firma_id') != $ilan->firmalar->id) <!-- ilan sahibi ise teklif vermemesi için bu butonların kaldırıyorum. --> 
                <tr>
                    <td colspan="5"></td>
                    <td colspan="4" style="text-align:right">
                        @if($kullaniciTeklifi != null)
                            <label for="" id="toplamFiyatL" class="control-label toplam" >KDV Hariç Toplam Fiyat: {{$teklifler[0]->paraFormat($kullaniciTeklifi['kdv_haric_fiyat'])}} {{$para_birimi}}</label>
                            <input type="hidden" name="toplamFiyatKdvsiz"  id="toplamFiyatKdvsiz" value="{{$kullaniciTeklifi['kdv_haric_fiyat']}}">
                        @else
                            <label for="" id="toplamFiyatL" class="control-label toplam" ></label>
                            <input type="hidden" name="toplamFiyatKdvsiz"  id="toplamFiyatKdvsiz" value="">
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td colspan="4" style="text-align:right">
                        @if($kullaniciTeklifi != null)
                            <label for="toplamFiyatLabel" id="toplamFiyatLabel" name="toplamFiyatLabel" class="control-label toplam" >KDV Dahil Toplam Fiyat: {{$teklifler[0]->paraFormat($kullaniciTeklifi['kdv_dahil_fiyat'])}} {{$para_birimi}}</label>
                            <input type="hidden" name="toplamFiyat"  id="toplamFiyat" value="{{$kullaniciTeklifi['kdv_dahil_fiyat']}}">
                        @else
                            <label for="toplamFiyatLabel" id="toplamFiyatLabel" name="toplamFiyatLabel" class="control-label toplam"></label>
                            <input type="hidden" name="toplamFiyat"  id="toplamFiyat" value="">
                        @endif
                    </td>
                </tr>
            @endif    
        </tbody>
    </table>
    <div align="right">
        @if(session()->get('firma_id') != $ilan->firmalar->id) <!-- ilan sahibi ise teklif vermemesi için bu butonların kaldırıyorum. --> 
            @if($ilan->kapanma_tarihi > $dt)
               @if(count($teklif)!=0) <!--Teklif varsa buton güncelleme kontrolu -->
                   {!! Form::button('Teklif Güncelle', array('id'=>'gonder','class'=>'btn btn-info')) !!}
               @else
                   {!! Form::button('Teklif Gönder', array('id'=>'gonder','class'=>'btn btn-info')) !!}
               @endif
            @else
               Bu ilanın KAPANMA SÜRESİ geçmiştir.O yüzden teklif günceleyemezsiniz !   
           @endif
        @endif   
        {!! Form::close() !!}
    </div>

</div>
<div id="mesaj" class="popup">
    <span class="button b-close"><span>X</span></span>
    <h2 style="color:red"> Üzgünüz.. !!!</h2>
    <h3>Sistemsel bir hata oluştu.Lütfen daha sonra tekrar deneyin</h3>
</div>