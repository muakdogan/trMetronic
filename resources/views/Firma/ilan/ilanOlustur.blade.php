<?php
  use App\Adres;
  use App\Il;
  use App\Ilce;
  use App\Semt;
  use Barryvdh\Debugbar\Facade as Debugbar;

$i=1;
?>
@extends('layouts.appUser')
@section('baslik') İlan Oluştur @endsection

@section('head')
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="{{asset('css/multi-select.css')}}" media="screen" rel="stylesheet" type="text/css"></link>
        <link href="{{asset('css/skin-bootstrap/ui.fancytree.css')}}" rel="stylesheet" class="skinswitcher">

        <!--kalem agacı -->
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script src="//cdn.jsdelivr.net/jquery.ui-contextmenu/1/jquery.ui-contextmenu.min.js"></script>
        <script src="{{asset('js/jquery.fancytree.js')}}"></script>
        <script src="{{asset('js/jquery.fancytree.glyph.js')}}"></script>
        <script src="{{asset('js/jquery.fancytree.dnd.js')}}"></script>
        <script src="{{asset('js/jquery.fancytree.edit.js')}}"></script>
        <script src="{{asset('js/jquery.fancytree.filter.js')}}"></script>
        <script src="{{asset('js/jquery.fancytree.table.js')}}"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
        <script src="//cdn.ckeditor.com/4.5.10/basic/ckeditor.js"></script>

        <style>
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }
            td, th {
                text-align: center;
                padding: 5px;
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
            /*headings*/
            .fs-title {
                font-size: 15px;
                text-transform: uppercase;
                color: #2C3E50;
                margin-bottom: 10px;
            }
            .eula-container {
                padding: 15px 20px;
                height: 250px;
                overflow: auto;
                border: 2px solid #ebebeb;
                color: #7B7B7B;
                font-size: 12pt;
                font-weight: 700;
                background-color: #fff;
                background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJod…EiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
                background-image: -webkit-linear-gradient(top, rgba(231,231,231,0.55) 0%, rgba(255,255,255,0.63) 17%, #feffff 100%);
                background-image: linear-gradient(to bottom, rgba(231,231,231,0.55) 0%, rgba(255,255,255,0.63) 17%, #feffff 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#8ce7e7e7', endColorstr='#feffff',GradientType=0 );
                background-clip: border-box;
                border-radius: 4px;
            }
            .info-box {
                margin: 0 0 15px;
            }
            .box h3{
                text-align:center;
                position:relative;
                top:80px;
            }
        </style>
@endsection
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />
    <script src="{{asset('js/jquery.multi-select.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('js/jquery.quicksearch.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/additional-methods.js')}}"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

    <link rel="stylesheet" type="text/css" href="{{asset('css/aciklama-tooltip.css')}}" />

    <div class="portlet light " id="form_wizard_1">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-layers theme-font"></i>
                <span class="caption-subject theme-font bold uppercase">İlan Oluştur</span>
            </div>

        </div>
        <div class="portlet-body form">
            {!! Form::open(array('id'=>'submit_form','url'=>'ilanOlusturEkle/'.$firma->id,'method'=>'POST', 'files'=>true,'class'=>'form-horizontal' )) !!}
            <div class="form-wizard">
                    <div class="form-body">
                        <ul class="nav nav-pills nav-justified steps">
                            <li>
                                <a href="#tab1" data-toggle="tab" class="step">
                                    <span class="number"> 1 </span>
                                    <span class="desc">
                                                                                    <i class="fa fa-check"></i> İlan Bilgileri </span>
                                </a>
                            </li>
                            <li>
                                <a href="#tab2" data-toggle="tab" class="step">
                                    <span class="number"> 2 </span>
                                    <span class="desc">
                                                                                    <i class="fa fa-check"></i> Kalem Bilgileri </span>
                                </a>
                            </li>
                            <li>
                                <a href="#tab3" data-toggle="tab" class="step active">
                                    <span class="number"> 3 </span>
                                    <span class="desc">
                                                                                    <i class="fa fa-check"></i> Sözleşme </span>
                                </a>
                            </li>
                        </ul>
                        <div id="bar" class="progress progress-striped" role="progressbar">
                            <div class="progress-bar progress-bar-success"> </div>
                        </div>
                        <div class="tab-content">
                            <div class="alert alert-danger display-none">
                                <button class="close" data-dismiss="alert"></button> Bazı hatalar var! Lütfen kontrol ediniz. </div>
                            <div class="alert alert-success display-none">
                                <button class="close" data-dismiss="alert"></button> Form başarılı! </div>
                            <div class="tab-pane active" id="tab1">
                                <h3 class="block">İlan Bilgileri Oluştur</h3>
                                <h2 style=" text-align: center;margin-top:0px;margin-bottom:10px" class="fs-title"><strong>İLAN BİLGİLERİ OLUŞTUR</strong></h2>
                                <br>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="inputEmail3" style="padding-right:3px;padding-left:12px" class="col-sm-3 control-label">Firma Adı Göster</label>
                                                <label for="inputTask" style="text-align: right;padding-right:3px;padding-left:3px"class="col-sm-1 control-label">:</label>
                                                <div class="col-sm-7">
                                                    <input type="radio" class="filled-in firma_goster  required"  name="firma_adi_goster" value="1"  data-validation-error-msg="Lütfen birini seçiniz!" checked><label> Göster</label> </input>
                                                    <input type="radio" data-placement="bottom" class="filled-in test firma_goster"  name="firma_adi_goster" value="0" data-validation-error-msg="Lütfen birini seçiniz!"><label>Gizle</label> </input>
                                                    <div class="col-md-1 aciklama-tooltip">
                                                    </div>
                                                    @if($errors->first('firma_adi_goster') != null)
                                                        <span class="help-block" style="color:red">{{ $errors->first('firma_adi_goster') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="inputEmail3" style="padding-right:3px;padding-left:12px" class="col-sm-3 control-label">İlan Adı<span class="required"> * </span></label>
                                                <label for="inputTask" style="text-align: right;padding-right:3px;padding-left:3px"class="col-sm-1 control-label">:</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control required" id="ilan_adi" name="ilan_adi" placeholder="İlan Adı" value="" >
                                                    @if($errors->first('ilan_adi') != null)
                                                        <span class="help-block" style="color:red">{{ $errors->first('ilan_adi') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-1 aciklama-tooltip">
                                                    <img src="{{asset("images/soru-isareti.ico")}}" />
                                                    <span class="tooltiptext">Satın almak istediğiniz mal veya hizmet için kısa ancak açıklayıcı bir ilan adı belirleyiniz.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="inputEmail3" style="padding-right:3px;padding-left:12px" class="col-sm-3 control-label">İlan Türü<span class="required"> * </span></label>
                                                <label for="inputTask" style="text-align:right;padding-right:3px;padding-left:3px" class="col-sm-1 control-label">:</label>
                                                <div class="col-sm-7">
                                                    <select class="form-control selectpicker required"  name="ilan_turu" id="ilan_turu">
                                                        <option selected disabled value="Seçiniz">Seçiniz</option>
                                                        <option value="1">Mal</option>
                                                        <option value="2">Hizmet</option>
                                                        <option value="3">Yapım İşi</option>
                                                    </select>
                                                    @if($errors->first('ilan_turu') != null)
                                                        <span class="help-block" style="color:red">{{ $errors->first('ilan_turu') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-1 aciklama-tooltip">
                                                    <img src="{{asset("images/soru-isareti.ico")}}" />
                                                    <span class="tooltiptext">Yapacağınız satın alımın türünü seçiniz. Seçenklerde belirtilen 3 türden yalnızca birini seçebilirsiniz.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="inputEmail3" style="padding-right:3px;padding-left:12px" class="col-sm-3 control-label">İlan Sektör<span class="required"> * </span></label>
                                                <label for="inputTask" style="text-align: right;padding-right:3px;padding-left:3px"class="col-sm-1 control-label">:</label>
                                                <div class="col-sm-7">
                                                    <select class="form-control selectpicker required" data-live-search="true"  name="firma_sektor" id="firma_sektor">
                                                        <option selected disabled>Seçiniz</option>
                                                    </select>
                                                    @if($errors->first('firma_sektor') != null)
                                                        <span class="help-block" style="color:red">{{ $errors->first('firma_sektor') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-1 aciklama-tooltip">
                                                    <img src="{{asset("images/soru-isareti.ico")}}" />
                                                    <span class="tooltiptext">Aynı sektöre ait 2 farklı tür alım gerçekleştirecekseniz yeni bir ilan daha açmanız gerekecektir.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">

                                                <label for="inputEmail3" style="padding-right:3px;padding-left:12px" class="col-sm-3 control-label">İlanın Tarih Aralığı<span class="required"> * </span></label>
                                                <label for="inputTask" style="text-align: right;padding-right:3px;padding-left:3px"class="col-sm-1 control-label">:</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="ilan_tarihi_araligi"  id="ilan_tarihi_araligi"  readonly value="" class="form-control  filled-in"
                                                           data-placement="bottom"/>
                                                    @if($errors->first('ilan_tarihi_araligi') != null)
                                                        <span class="help-block" style="color:red">{{ $errors->first('ilan_tarihi_araligi') }}</span>
                                                @endif
                                                <!--input class="form-control date" id="yayinlanma_tarihi"  readonly   name="yayinlanma_tarihi" value="" placeholder="Yayinlanma Tarihi" type="text" /-->
                                                </div>
                                                <div class="col-md-1 aciklama-tooltip">
                                                    <img src="{{asset("images/soru-isareti.ico")}}" />
                                                    <span class="tooltiptext">İlanın ne kadar süre yayında kalmasını istiyorsanız o tarih aralığını seçiniz.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="inputEmail3" style="padding-right:3px;padding-left:12px" class="col-sm-3 control-label">İşin Süresi<span class="required"> * </span></label>
                                                <label for="inputTask" style="text-align: right;padding-right:3px;padding-left:3px"class="col-sm-1 control-label">:</label>
                                                <div class="col-sm-7">
                                                    <select class="form-control selectpicker required" name="isin_suresi" id="isin_suresi">
                                                        <option selected disabled>Seçiniz</option>
                                                        <option value="Tek Seferde">Tek Seferde</option>
                                                        <option value="Zamana Yayılarak">Zamana Yayılarak</option>
                                                    </select>
                                                    @if($errors->first('isin_suresi') != null)
                                                        <span class="help-block" style="color:red">{{ $errors->first('isin_suresi') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-1 aciklama-tooltip">
                                                    <img src="{{asset("images/soru-isareti.ico")}}" />
                                                    <span class="tooltiptext">Satın almak istediğiniz mal veya hizmet tek seferde gerçekleşecek ise Tek Seferde seçeneğini yoksa belirli bir zamanı kapsayacak şekilde tekrarlayarak belirli bir dönemde gerçekleşecek ise Zamana Yayılarak seçeneğini işaretleyiniz.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="inputEmail3" style="padding-right:3px;padding-left:12px" class="col-sm-3 control-label">İş Tarih Aralığı<span class="required"> * </span></label>
                                                <label for="inputTask" style="text-align: right;padding-right:3px;padding-left:3px"class="col-sm-1 control-label">:</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="is_tarihi_araligi"  id="is_tarihi_araligi"  readonly value="" class="form-control filled-in"
                                                           data-placement="bottom"/>
                                                    @if($errors->first('is_tarihi_araligi') != null)
                                                        <span class="help-block" style="color:red">{{ $errors->first('is_tarihi_araligi') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-1 aciklama-tooltip">
                                                    <img src="{{asset("images/soru-isareti.ico")}}" />
                                                    <span class="tooltiptext">Satın almak istediğiniz mal veya hizmete ilişkin iş hangi tarihler arasında gerçekleşecekse o tarih aralığını seçiniz</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-12">

                                                <label for="inputEmail3" style="padding-right:3px;padding-left:12px" class="col-sm-3 control-label">Teknik Şartname</label>
                                                <label for="inputTask" style="text-align: right;padding-right:3px;padding-left:3px"class="col-sm-1 control-label">:</label>
                                                <div id="sartname" class="col-md-7" style="background-color: #fcf8e3; margin-top: 2px;margin-bottom:2px;padding: 2px">
                                                    {!! Form::file('teknik',array(
                                                       'accept'=>'application/msword, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                                       'id'=>'sartnameGozat'))!!}
                                                    <a style="display: none;" id="sartnameVazgec" href="#"><span style="float: right; color: red">Vazgec</span></a>
                                                    @if($errors->first('sartnameVazgec') != null)
                                                        <span class="help-block" style="color:red">{{ $errors->first('sartnameVazgec') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-1 aciklama-tooltip">
                                                    <img src="{{asset("images/soru-isareti.ico")}}" />
                                                    <span class="tooltiptext">Satın alım ilanınıza ilişkin bir teknik şartname dokümanınız var ise lütfen bu dokümanı yükleyiniz.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="inputEmail3" style="padding-right:3px;padding-left:12px" class="col-sm-3 control-label">Katılımcılar<span class="required"> * </span></label>
                                                <label for="inputTask" style="text-align: right;padding-right:3px;padding-left:3px"class="col-sm-1 control-label">:</label>
                                                <div class="col-sm-7">
                                                    <select class="form-control selectpicker required" name="katilimcilar" id="katilimcilar" data-validation="required"
                                                            data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                                        <option selected disabled value="Seçiniz">Seçiniz</option>
                                                        <option value="1">Tüm Firmalar</option>
                                                        <option value="2">Belirli Firmalar</option>
                                                    </select>
                                                    @if($errors->first('katilimcilar') != null)
                                                        <span class="help-block" style="color:red">{{ $errors->first('katilimcilar') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-1 aciklama-tooltip">
                                                    <img src="{{asset("images/soru-isareti.ico")}}" />
                                                    <span class="tooltiptext">Satın alım ilanınıza katılmasını istediğiniz firmaları veya grupları seçiniz.</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="belirli-firmalar" style="display: none;">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <div style="padding-right:3px;padding-left:1px"  class="col-md-11 col-md-offset-1">
                                                        <select id='belirliFirma' multiple='multiple' name="belirli_istekli[]" id="belirli_istekli[]" data-rule-multiselectOnay="true">
                                                            <optgroup label='Onaylı Tedarikçiler'></optgroup>
                                                            <optgroup label='Diğer Tedarikçiler'></optgroup>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-10 col-md-offset-1" style="padding-top:10px">
                                                        <a href="javascript:;" class="btn" id="onayliOtomatik">Onaylı Tedarikçilerimi Otomatik Ekle</a>
                                                        <a href="javascript:;" style="float: right" class="btn" id="firmaVazgec">Tümünden Vazgeç</a>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="inputEmail3" style="padding-right:3px;padding-left:12px" class="col-sm-3 control-label">Rekabet Şekli<span class="required"> * </span></label>
                                                <label for="inputTask" style="text-align: right;padding-right:3px;padding-left:3px"class="col-sm-1 control-label">:</label>
                                                <div class="col-sm-7">
                                                    <select class="form-control selectpicker required" name="rekabet_sekli" id="rekabet_sekli">
                                                        <option selected disabled value="Seçiniz">Seçiniz</option>
                                                        <option value="1">Tamrekabet</option>
                                                        <option value="2">Sadece Başvuru</option>
                                                    </select>
                                                    @if($errors->first('rekabet_sekli') != null)
                                                        <span class="help-block" style="color:red">{{ $errors->first('rekabet_sekli') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-1 aciklama-tooltip">
                                                    <img src="{{asset("images/soru-isareti.ico")}}" />
                                                    <span class="tooltiptext">Satın alım ilanınıza fiyat verecek firmaların aktif şekilde rekabet etmelerini ve birbirlerinin firmalarını görmeden sadece fiyatlarını görerek fiyat eksiltmelerini istiyorsanız Tamrekabet seçeneğini, katılacak firmalardan rekabet etmeksizin sistem üzerinden kapalı zaf usulü fiyat teklifi toplamak istiyorsanız Sadece Başvuru seçeneğini işaretleyiniz.</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="inputEmail3" style="padding-right:3px;padding-left:12px" class="col-sm-3 control-label">Sözleşme Türü<span class="required"> * </span></label>
                                                <label for="inputTask" style="text-align:right;padding-right:3px;padding-left:3px"class="col-sm-1 control-label">:</label>
                                                <div class="col-sm-7">
                                                    <select class="form-control selectpicker required" name="sozlesme_turu" id="sozlesme_turu">
                                                        <option selected disabled value="Seçiniz">Seçiniz</option>
                                                        <option value="0">Birim Fiyatlı</option>
                                                        <option value="1">Götürü Bedel</option>
                                                    </select>
                                                    @if($errors->first('sozlesme_turu') != null)
                                                        <span class="help-block" style="color:red">{{ $errors->first('sozlesme_turu') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-1 aciklama-tooltip">
                                                    <img src="{{asset("images/soru-isareti.ico")}}" />
                                                    <span class="tooltiptext">Satın alımı gerçekleştireceğiniz firmadan istediğiniz teklifte kalemleri fiyatlandırmadan işin tamamına dair bir teklif istiyorsanız Götürü Bedel seçeneğini, satın almak istediğiniz işe dair kalemlerin ayrı ayrı fiyatlandırılmasını istiyorsanız Birim Fiyatlı şeneğini işaretleyiniz.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group fiyatlandirma row" style="display: none;">
                                            <div class="col-md-12">

                                                <label for="inputEmail3"   style="padding-right:3px;padding-left:12px" class="col-sm-3 control-label">Fiyatlandırma Şekli<span class="required"> * </span></label>
                                                <label for="inputTask" style="text-align:right;padding-right:3px;padding-left:3px"class="col-sm-1 control-label">:</label>
                                                <div class="col-sm-7">
                                                    <select class="form-control selectpicker required" name="kismi_fiyat" id="kismi_fiyat" >
                                                        <option selected disabled value="Seçiniz">Seçiniz</option>
                                                        <option   value="1">Kısmi Fiyat Teklifine Açık</option>
                                                        <option  value="0">Kısmi Fiyat Teklifine Kapalı</option>
                                                    </select>
                                                    @if($errors->first('kismi_fiyat') != null)
                                                        <span class="help-block" style="color:red">{{ $errors->first('kismi_fiyat') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-1 aciklama-tooltip">
                                                    <img src="{{asset("images/soru-isareti.ico")}}" />
                                                    <span class="tooltiptext">Satın alım ilanına ilişkin mal veya hizmetlerinize teklif verecek firmaların alımını gerçekleştireceğiniz kalemlerin tümüne fiyat vermesini istiyorsanız Birim Fiyat Teklifine Kapalı seçeneğini, eğer kalemlerin belli bir kısmına da firmaların teklif verebilmesini istiyorsanız Birim Fiyat Teklifine Açık seçeneğini işaretleyiniz.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">

                                                <label for="inputEmail3" style="padding-right:3px;padding-left:12px" class="col-sm-3 control-label">Yaklaşık Maliyet</label>
                                                <label for="inputTask" style="text-align: right;padding-right:3px;padding-left:3px"class="col-sm-1 control-label">:</label>
                                                <div class="col-sm-7">
                                                    <select class="form-control selectpicker required" name="yaklasik_maliyet" id="yaklasik_maliyet" >
                                                        <option selected disabled>Seçiniz</option>
                                                        @foreach($maliyetler as $maliyet)
                                                            <option value="{{$maliyet->miktar}}" >{{$maliyet->aralik}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->first('yaklasik_maliyet') != null)
                                                        <span class="help-block" style="color:red">{{ $errors->first('yaklasik_maliyet') }}</span>
                                                    @endif
                                                    <input type="hidden" id="maliyet" name="maliyet" value=""></input>
                                                </div>
                                                <div class="col-md-1 aciklama-tooltip">
                                                    <img src="{{asset("images/soru-isareti.ico")}}" />
                                                    <span class="tooltiptext">Alım ilanınıza ilişkin, satın alacağınız mal veya hizmetlerin yaklaşık toplam maliyet aralığını işaretleyiniz.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="inputEmail3" style="padding-right:3px;padding-left:12px" class="col-sm-3 control-label">Ödeme Türü<span class="required"> * </span></label>
                                                <label for="inputTask" style="text-align:right;padding-right:3px;padding-left:3px"class="col-sm-1 control-label">:</label>
                                                <div class="col-sm-7">
                                                    <select class="form-control selectpicker required" name="odeme_turu" id="odeme_turu" >
                                                        <option selected disabled>Seçiniz</option>
                                                        @foreach($odeme_turleri as $odeme_turu)
                                                            <option value="{{$odeme_turu->id}}" >{{$odeme_turu->adi}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->first('odeme_turu') != null)
                                                        <span class="help-block" style="color:red">{{ $errors->first('odeme_turu') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-1 aciklama-tooltip"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="inputEmail3" style="padding-right:3px;padding-left:12px" class="col-sm-3 control-label">Para Birimi<span class="required"> * </span></label>
                                                <label for="inputTask" style="text-align:right;padding-right:3px;padding-left:3px"class="col-sm-1 control-label">:</label>
                                                <div class="col-sm-7">
                                                    <select class="form-control selectpicker required" name="para_birimi" id="para_birimi" >
                                                        <option selected disabled>Seçiniz</option>
                                                        @foreach($para_birimleri as $para_birimi)
                                                            <option  value="{{$para_birimi->id}}" >{{$para_birimi->adi}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->first('para_birimi') != null)
                                                        <span class="help-block" style="color:red">{{ $errors->first('para_birimi') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-1 aciklama-tooltip"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="inputEmail3" style="padding-right:3px;padding-left:12px" class="col-sm-3 control-label">Teslim Yeri<span class="required"> * </span></label>
                                                <label for="inputTask" style="text-align: right;padding-right:3px;padding-left:3px"class="col-sm-1 control-label">:</label>
                                                <div class="col-sm-7">
                                                    <select class="form-control selectpicker required" name="teslim_yeri" id="teslim_yeri" >
                                                        <option selected disabled value="Seçiniz">Seçiniz</option>
                                                        <option   value="Satıcı Firma">Satıcı Firma</option>
                                                        <option  value="Adrese Teslim">Adrese Teslim</option>
                                                    </select>
                                                    @if($errors->first('teslim_yeri') != null)
                                                        <span class="help-block" style="color:red">{{ $errors->first('teslim_yeri') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-1 aciklama-tooltip">
                                                    <img src="{{asset("images/soru-isareti.ico")}}" />
                                                    <span class="tooltiptext">Alacağınız ürün ve hizmetler iş yapacağınız yere gelsin istiyorsanız Adrese Teslim seçeneğini, tedarikçinizin bulunduğu yerden almak istiyorsanız Satıcı Firma seçeneğini işaretleyiniz.</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group teslim_il row" style="display: none;">
                                            <div class="col-md-12">

                                                <label for="inputTask" style="padding-right:3px;padding-left:12px" class="col-sm-3 control-label">Teslim Ad. İli<span class="required"> * </span></label>
                                                <label for="inputTask" style="text-align: right;padding-right:3px;padding-left:3px"class="col-sm-1 control-label">:</label>
                                                <div class="col-sm-7">
                                                    <select class="form-control selectpicker required" name="il_id" id="il_id" >
                                                        <option selected disabled>Seçiniz</option>
                                                        <?php $iller_query= DB::select(DB::raw("SELECT *
                                                                        FROM  `iller`
                                                                        WHERE adi = 'İstanbul'
                                                                        OR adi =  'İzmir'
                                                                        OR adi =  'Ankara'
                                                                        UNION
                                                                        SELECT *
                                                                        FROM iller"));
                                                        ?>
                                                        @foreach($iller_query as $il)
                                                            <option  value="{{$il->id}}" >{{$il->adi}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->first('il_id') != null)
                                                        <span class="help-block" style="color:red">{{ $errors->first('il_id') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-1 aciklama-tooltip"></div>
                                            </div>
                                        </div>
                                        <div class="form-group teslim_ilce row" style="display: none;">
                                            <div class="col-md-12">
                                                <label for="inputTask" style="padding-right:3px;padding-left:12px" class="col-sm-3 control-label">Teslim Ad. İlçesi<span class="required"> * </span></label>
                                                <label for="inputTask" style="text-align: right;padding-right:3px;padding-left:3px"class="col-sm-1 control-label">:</label>
                                                <div class="col-sm-7">
                                                    <select class="form-control selectpicker required" name="ilce_id" id="ilce_id" >
                                                        <option selected disabled value="Seçiniz">Seçiniz</option>
                                                    </select>
                                                    @if($errors->first('ilce_id') != null)
                                                        <span class="help-block" style="color:red">{{ $errors->first('ilce_id') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-1 aciklama-tooltip"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" >
                                        <div class="form-group">
                                            <label for="inputEmail3" style="padding-right:3px;padding-left:12px" class="col-sm-1 control-label">Açıklama</label>
                                            <label for="inputTask" style="text-align: right;padding-right:3px;padding-left:3px" class=" col-sm-1 control-label">:</label>
                                            <div class="col-sm-10" >

                                                <textarea id="aciklama" name="aciklama" rows="5"  class="form-control ckeditor" placeholder="Lütfen Açıklamayı buraya yazınız.." ></textarea>
                                                @if($errors->first('aciklama') != null)
                                                    <span class="help-block" style="color:red">{{ $errors->first('aciklama') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2">
                                <fieldset  id="kalem" >
                                <h3 class="block">Kalem bilgileri Oluştur</h3>
                                <div id="mal">
                                    <table  id="mal_table" class="table" >
                                        <thead id="tasks-list" name="tasks-list">
                                        <tr style="text-align:center">
                                            <th>Sıra</th>
                                            <th>Kalem Ekle</th>
                                            <th>Marka</th>
                                            <th>Model</th>
                                            <th>Açıklama</th>
                                            <th>Ambalaj</th>
                                            <th>Miktar</th>
                                            <th>Birim</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>
                                                <input type="text" style="background:url({{asset('images/ekle.png')}}) no-repeat scroll ;padding-left:25px" class="form-control  mal_show required" id="mal_kalem0" name="mal_kalem[0]" placeholder="Kalem Ekle" readonly  value="">
                                                <p class="help-block" style="color:red">{{ $errors->first('mal_kalem') }}</p>
                                            </td>

                                            <td><input type="text" class="form-control required" id="mal_marka" name="mal_marka[0]" placeholder="Marka" value="" ></td>
                                            <td>
                                                <input type="text" class="form-control required" id="mal_model" name="mal_model[0]" placeholder="Model" value="" >
                                            </td>
                                            <td>
                                                <textarea id="mal_aciklama" name="mal_aciklama[0]" rows="2" class="form-control required" placeholder="Açıklama" ></textarea>
                                            </td>
                                            <td><input type="text" class="form-control required" id="mal_ambalaj" name="mal_ambalaj[0]" placeholder="Ambalaj" value="" ></td>

                                            <td>
                                                <input type="number" min="0" class="form-control  required" id="mal_miktar" name="mal_miktar[0]" placeholder="Miktar" value=""  >

                                            </td>
                                            <td>
                                                <select class="form-control selectpicker  required" name="mal_birim[0]" id="mal_birim" data-live-search="true"  >
                                                    <option selected disabled>Seçiniz</option>
                                                    @foreach($birimler as $birimleri)
                                                        <option  value="{{$birimleri->id}}" >{{$birimleri->adi}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <a href="#"  class="sil"> <img src="{{asset("images/sil1.png")}}"></a> <input type="hidden" name="mal_id[0]"  id="mal_id0" value=""><!--agaçtan seçilen kalemin id -->
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                                <div id="hizmet">
                                    <table id="hizmet_table" class="table" >
                                        <tr style="text-align:center">
                                            <th>Sıra</th>
                                            <th>Kalem Ekle</th>
                                            <th>Açıklama</th>
                                            <th>Fiyat Standartı</th>
                                            <th>Fiyat Standartı Birimi</th>
                                            <th>Miktar</th>
                                            <th>Birim</th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td><input type="text" style="background:url({{asset('images/ekle.png')}}) no-repeat scroll ;padding-left:25px" class="form-control hizmet_show required" id="hizmet_kalem0" name="hizmet_kalem[0]" placeholder="Kalem Ekle" readonly  value="" > </td>
                                            <td>
                                                <textarea id="hizmet_aciklama" name="hizmet_aciklama[0]" rows="2" class="form-control required" placeholder="Açıklama"  ></textarea>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control required" id="hizmet_fiyat_standardi" name="hizmet_fiyat_standardi[0]" placeholder="Fiyat Standartı" value="" >
                                            </td>
                                            <td>
                                                <select class="form-control selectpicker required"  data-live-search="true"  name="hizmet_fiyat_standardi_birimi[0]" id="hizmet_fiyat_standardi_birimi" >
                                                    <option selected disabled>Seçiniz</option>
                                                    @foreach($birimler as $fiyat_birimi)
                                                        <option  value="{{$fiyat_birimi->id}}" >{{$fiyat_birimi->adi}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control required" id="hizmet_miktar0" name="hizmet_miktar[0]" placeholder="Miktar" value="" >
                                            </td>
                                            <td>
                                                <select class="form-control selectpicker required"  data-live-search="true"  name="hizmet_miktar_birim_id[0]" id="hizmet_miktar_birim_id" >
                                                    <option selected disabled>Seçiniz</option>
                                                    @foreach($birimler as $miktar_birim)
                                                        <option  value="{{$miktar_birim->id}}" >{{$miktar_birim->adi}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><a href="#"  class="sil"><img src="{{asset("images/sil1.png")}}"></a><input type="hidden" name="hizmet_id[0]"  id="hizmet_id0" value=""></td>
                                        </tr>
                                    </table>
                                </div>

                                <div id="goturu" >
                                    <table id="goturu_table" class="table" >
                                        <tr style="text-align:center">
                                            <th>Sıra</th>
                                            <th>Kalem Ekle</th>
                                            <th>Açıklama</th>
                                            <th>Miktar</th>
                                            <th>Birim</th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td><input type="text" style="background:url({{asset('images/ekle.png')}}) no-repeat scroll ;padding-left:25px" class="form-control goturu_show required" id="goturu_kalem0" name="goturu_kalem[0]" placeholder="Kalem Ekle" readonly  value=""  > </td>
                                            <td>
                                                <textarea id="goturu_aciklama" name="goturu_aciklama[0]" rows="2" class="form-control required" placeholder="Açıklama" ></textarea>
                                            </td>

                                            <td>
                                                <input type="number" class="form-control required" id="goturu_miktar" name="goturu_miktar[0]" placeholder="Miktar" value="" >
                                            </td>
                                            <td>
                                                <select class="form-control selectpicker required"  data-live-search="true" name="goturu_miktar_birim_id[0]" id="goturu_miktar_birim_id" >
                                                    <option selected disabled>Seçiniz</option>
                                                    @foreach($birimler as $miktar_birim)
                                                        <option  value="{{$miktar_birim->id}}" >{{$miktar_birim->adi}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><a href="#"  class="sil"> <img src="{{asset("images/sil1.png")}}"></a><input type="hidden" name="goturu_id[0]"  id="goturu_id0" value=""></td>
                                        </tr>
                                    </table>
                                </div>

                                <div id="yapim" >
                                    <table id="yapim_table" class="table" >
                                        <tr style="text-align:center">
                                            <th>Sıra</th>
                                            <th>Kalem Ekle</th>
                                            <th>Açıklama</th>
                                            <th>Fiyat Standartı</th>
                                            <th>Fiyat Standartı Birimi</th>
                                            <th>Miktar</th>
                                            <th>Birim</th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td><input type="text" style="background:url({{asset('images/ekle.png')}}) no-repeat scroll ;padding-left:25px" class="form-control yapim_show required" id="yapim_kalem0" name="yapim_kalem[0]" placeholder="Kalem Ekle" readonly  value="" > </td>
                                            <td>
                                                <textarea id="yapim_aciklama" name="yapim_aciklama[0]" rows="2" class="form-control required" placeholder="Açıklama" ></textarea>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control required" id="yapim_fiyat_standardi" name="yapim_fiyat_standardi[0]" placeholder="Fiyat Standartı" value="" >
                                            </td>
                                            <td>
                                                <select class="form-control selectpicker required" data-live-search="true"  name="yapim_fiyat_standardi_birimi[0]" id="yapim_fiyat_standardi_birimi" >
                                                    <option selected disabled>Seçiniz</option>
                                                    @foreach($birimler as $fiyat_birimi)
                                                        <option  value="{{$fiyat_birimi->id}}" >{{$fiyat_birimi->adi}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control required" id="yapim_miktar" name="yapim_miktar[0]" placeholder="Miktar" value="">
                                            </td>
                                            <td>
                                                <select class="form-control selectpicker required"  data-live-search="true" name="yapim_miktar_birim_id[0]" id="yapim_miktar_birim_id" >
                                                    <option selected disabled>Seçiniz</option>
                                                    @foreach($birimler as $miktar_birim)
                                                        <option  value="{{$miktar_birim->id}}" >{{$miktar_birim->adi}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><a href="#" class="sil"> <img src="{{asset("images/sil1.png")}}"></a> <input type="hidden" name="yapim_id[0]"  id="yapim_id0" value=""></td>

                                        </tr>
                                    </table>
                                </div>

                                <input style="float:right" type="button" class="btn purple" id="btn2" value="Kalem Ekle" />
                                </fieldset>
                            </div>
                            <div class="tab-pane" id="tab3">
                                <h3 class="block">Sözleşme Onayı</h3>
                                <h2   style=" text-align:center;margin-top:0px;margin-bottom:10px" class="fs-title"><strong>ONAYLA VE GÖNDER</strong></h2>
                                <h2   style=" text-align:center;margin-top:0px;margin-bottom:10px" class="fs-title"><strong>Sözleşme-1</strong></h2>
                                <div class="info-box eula-container ">
                                    <h3>İlan Bilgileri</h3>
                                </div>
                                <input type="checkbox"  id='sozlesme_onay' name="sozlesme_onay" value="1" class="required"><strong>Sözleşmeyi Okudum Onaylıyorum</strong>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-9 col-md-3">
                                <a href="javascript:;" class="btn default button-previous">
                                    <i class="fa fa-angle-left"></i> Geri </a>
                                <a href="javascript:;" class="btn btn-outline purple button-next next"> İleri
                                    <i class="fa fa-angle-right"></i>
                                </a>
                                <button class="btn purple button-submit" type="submit">Gönder <i class="fa fa-check"></i></button>

                            </div>
                        </div>
                    </div>
                </div>

            {!! Form::close() !!}
        </div>
        <!--kalemler tree modalı -->
        @include('Firma.ilan.kalemAgaci')
    </div>


    <script src="http://thecodeplayer.com/uploads/js/jquery.easing.min.js" type="text/javascript"></script>
    <script src="{{asset('js/jquery.bpopup-0.11.0.min.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script charset="utf-8">

    $('#btn-add-ilanBilgileri').click(function () {
        $('#btn-save-ilanBilgileri').val("add");
        $('#myModal-ilanBilgileri').modal('show');
    });

    $("#sartnameGozat").change(function (){
        $("#sartnameVazgec").show();
       });

    $("#sartnameVazgec").click(function(){
        $(this).hide();
        $("#sartnameGozat").val('');
    });

var sektor = 0;

$( ".box" ).click(function() {
   $('#cke_1_contents').each(function(){
       $('#cke_1_contents').css('height', '100px');
   });
});

$(document).ready(function(){
     $('#il_id').on('change', function (e) {
         var il_id = e.target.value;
         GetIlce(il_id);
     });
    jQuery.validator.methods["date"] = function (value, element) { return true; };
    jQuery.validator.addMethod("multiselectOnay", function(value, element) {
        return $($('#'+$(element).attr('id')+' :selected')).length>0;
    }, 'En az bir tane firma seçmelisiniz!!');
    $('#myModal-ilanBilgileri').modal('show');
 });
var ilan_turu;
var sozlesme_turu;

$('#ilan_turu').on('change', function (e) {
        ilan_turu = e.target.value;
        getSektor(ilan_turu);
});

$('#sozlesme_turu').on('change', function (e) {
             sozlesme_turu = e.target.value;
               if(sozlesme_turu=="1")
                {
                   $('.fiyatlandirma').hide();

                }else if(sozlesme_turu=="0")
                 {
                    $('.fiyatlandirma').show();
                 }
 });
//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches
$(".next").click(function(){
    if(sozlesme_turu=="1")
    {
        $('#goturu').show();
        $('#hizmet').hide();
        $('#mal').hide();
        $('#yapim').hide();
    }
    else if(ilan_turu=="1")
    {
        $('#mal').show();
        $('#hizmet').hide();
        $('#goturu').hide();
        $('#yapim').hide();
    }
    else if(ilan_turu=="2")
    {
       $('#hizmet').show();
       $('#mal').hide();
       $('#goturu').hide();
       $('#yapim').hide();
    }
    else if(ilan_turu=="3")
    {
       $('#yapim').show();
       $('#hizmet').hide();
       $('#goturu').hide();
       $('#mal').hide();
    }
});
$('.previous').click(function(){
        if($('#kalem').is(":visible")){
                current_fs = $('#kalem');
                next_fs = $('#ilan');
        }else if ($('#onay').is(":visible")){
                current_fs = $('#onay');
                next_fs = $('#kalem');
        }
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
        next_fs.show();
        current_fs.hide();
});
function GetIlce(il_id) {
        if (il_id > 0) {
            $("#ilce_id").get(0).options.length = 0;
            $("#ilce_id").get(0).options[0] = new Option("Yükleniyor", "-1");

            $.ajax({
                type: "GET",
                url: "{{asset('ajax-subcat')}}",
                data:{il_id:il_id},
                contentType: "application/json; charset=utf-8",

                success: function(msg) {
                    $("#ilce_id").get(0).options.length = 0;
                    $("#ilce_id").get(0).options[0] = new Option("Seçiniz", "-1");

                    $.each(msg, function(index, ilce) {
                        $("#ilce_id").get(0).options[$("#ilce_id").get(0).options.length] = new Option(ilce.adi, ilce.id);
                    });
                    $('.selectpicker').selectpicker('refresh');
                },
                async: false,
                error: function() {
                    $("#ilce_id").get(0).options.length = 0;
                    alert("İlçeler yükelenemedi!!!");
                }
            });
        }
        else {
            $("#ilce_id").get(0).options.length = 0;
        }
    }

$("#yaklasik_maliyet").change(function(){
    var option = $('option:selected', this).attr('name');
    $('#maliyet').val(option);
});

$('#belirliFirma').multiSelect({
    selectableHeader: "<p style='font-size:12px;color:red'>Tüm Firmalar</p><input style='width:100%' type='text' class='search-input' autocomplete='off' placeholder='Firma Seçiniz'>",
    selectionHeader: "<p style='font-size:12px;color:red'>Seçili Firmalar</p><input  style='width:100%' type='text' class='search-input' autocomplete='off' placeholder='Firma Seçiniz'>",
    selectableOptgroup: true,
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

        that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
            .on('keydown', function(e){
                if (e.which == 40){
                    that.$selectionUl.focus();
                    return false;
                }
            });
    },
    afterSelect: function(){
        this.qs1.cache();
        this.qs2.cache();
    },
    afterDeselect: function(){
        this.qs1.cache();
        this.qs2.cache();
    }
});

var option;

    $( "#firmaVazgec" ).click(function() {
        $('#belirliFirma').multiSelect('deselect_all');
    });
    var onayliTed=new Array();
    $( "#onayliOtomatik" ).click(function() {
        for(var key=0; key < onayliTed.length;key++) {
            $('#belirliFirma').multiSelect('select', (onayliTed[key]));
        }
    });


$("#firma_sektor").change(function(){
  sektor = $('option:selected', this).attr('value');
     $('select#katilimcilar option').removeAttr("selected");
     $("#katilimcilar option[value='Seçiniz']").prop('selected', true).trigger("change");;

});

function getBelirliFirmalar(){
    $.ajax({
        type:"GET",
        url: "{{asset('belirli')}}",
        data:{
            sektorIlan:sektor
        },
        cache: false,
        success: function(data){
            $("#belirliFirma option").remove();
            for(var key=0; key <Object.keys(data.onayliTedarikciler).length;key++) {
                $('#belirliFirma').multiSelect('addOption', { value: data.onayliTedarikciler[key].id, text: data.onayliTedarikciler[key].adi, index:key, nested: 'Onaylı Tedarikçiler'});
                onayliTed[key]=data.onayliTedarikciler[key].id;
            }
           for(var key=0; key <Object.keys(data.digerTedarikciler).length;key++) {
                $('#belirliFirma').multiSelect('addOption', { value: data.digerTedarikciler[key].id, text: data.digerTedarikciler[key].adi, index:key, nested: 'Diğer Tedarikçiler'});
            }
            $('#belirliFirma').multiSelect('refresh');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Status: " + textStatus+" Error: " + errorThrown);
        }
    });
}

$("#katilimcilar").change(function(){
   option = $('option:selected', this).attr('value');
    if(sektor!==0){
        if(option==="1"){
            $('#belirli-firmalar').hide();
        }
        else if (option==="2"){
            $('#belirliFirma').multiSelect('deselect_all');
            getBelirliFirmalar();
            $('#belirli-firmalar').show();
        }
    }
});

$( "#teslim_yeri" ).change(function() {
        var teslim_yeri= $('#teslim_yeri').val();
        if(teslim_yeri=="Satıcı Firma"){
            $('#il_id').prop('selectedIndex',0);
            $('#ilce_id').prop('selectedIndex',0);
            $('.teslim_il').hide();
            $('.teslim_ilce').hide();
            $('.selectpicker').selectpicker('refresh');
        }
        else if(teslim_yeri=="Adrese Teslim"){
             $('.teslim_il').show();
            $('.teslim_ilce').show();
        }
});
$('.firma_goster').click(function() {
    $(this).siblings('input:checkbox').prop('checked', false);
});
$(function() {
  $('.selectpicker').selectpicker();
});
$('.selectpicker').selectpicker({
  noneResultsText: 'Sonuç Bulunamadı'
});
var kalem_num=0;
var i="{{$i}}";
$("#btn2").click(function(){ //birden fazla kalem ekleme modal form içerisinde.

    if(ilan_turu=="1" &&sozlesme_turu=="0")
    {
        i = ($(".mal_show").length) +1;
        kalem_num = i-1;

        $("#mal_table").append(['<tr>','<td>'+i+'</td>','<td> <input type="text"  style="background:url({{asset("images/ekle.png")}}) no-repeat scroll ;padding-left:25px"class="form-control mal_show  required" id="mal_kalem'+kalem_num+'" name="mal_kalem['+kalem_num+']" placeholder="Kalem Ekle" readonly value="" > </td>',
                      '<td><input type="text" class="form-control required " id="mal_marka" name="mal_marka['+kalem_num+']" placeholder="Marka" value="" ></td>',
                      ' <td><input type="text" class="form-control required " id="mal_model" name="mal_model['+kalem_num+']" placeholder="Model" value="" ></td>',
                      '<td><textarea id="mal_aciklama" name="mal_aciklama['+kalem_num+']" rows="2" class="form-control required" placeholder="Açıklama" ></textarea></td>',
                      ' <td> <input type="text" class="form-control required" id="mal_ambalaj" name="mal_ambalaj['+kalem_num+']" placeholder="ambalaj" value="" ></td>',
                      '<td><input type="number" class="form-control required " id="mal_miktar'+kalem_num+'" name="mal_miktar['+kalem_num+']" placeholder="Miktar" value="" ></td>',
                      '<td><select class="form-control selectpicker required " name="mal_birim['+kalem_num+']" id="mal_birim"><option selected disabled>Seçiniz</option>@foreach($birimler as $birimleri) <option  value="{{$birimleri->id}}" >{{$birimleri->adi}}</option> @endforeach </select></td>',
                      '<td><a href="#" class="sil" ><img src="{{asset("images/sil1.png")}}"></a><input type="hidden" name="mal_id['+kalem_num+']"  id="mal_id'+kalem_num+'" value=""></td>','</tr>'].join(''));

    }
    else if(ilan_turu=="2" && sozlesme_turu=="0"){

        i = ($(".hizmet_show").length) +1;
        kalem_num = i-1;

    $("#hizmet_table").append(['<tr>','<td>'+i+'</td>',
            '<td><input type="text" style="background:url({{asset("images/ekle.png")}}) no-repeat scroll ;padding-left:25px" class="form-control hizmet_show required" id="hizmet_kalem'+kalem_num+'" name="hizmet_kalem['+kalem_num+']" placeholder="Kalem Ekle" readonly  value="" data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"> </td>',
            '<td><textarea id="hizmet_aciklama" name="hizmet_aciklama['+kalem_num+']" rows="2" class="form-control required" placeholder="Açıklama" data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"></textarea></td>',
            '<td><input type="text" class="form-control required" id="hizmet_fiyat_standardi" name="hizmet_fiyat_standardi['+kalem_num+']" placeholder="Fiyat Standartı" value="" data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"></td>',
            '<td><select class="form-control selectpicker required" name="hizmet_fiyat_standardi_birimi['+kalem_num+']" id="hizmet_fiyat_standardi_birimi" data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"><option selected disabled>Seçiniz</option>@foreach($birimler as $fiyat_birimi)<option  value="{{$fiyat_birimi->id}}" >{{$fiyat_birimi->adi}}</option>@endforeach</select></td>',
            '<td><input type="number" class="form-control  required" id="hizmet_miktar'+kalem_num+'" name="hizmet_miktar['+kalem_num+']" placeholder="Miktar" value="" data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"></td>',
            '<td><select class="form-control selectpicker required" name="hizmet_miktar_birim_id['+kalem_num+']" id="hizmet_miktar_birim_id" data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"><option selected disabled>Seçiniz</option>@foreach($birimler as $miktar_birim) <option  value="{{$miktar_birim->id}}" >{{$miktar_birim->adi}}</option>@endforeach</select></td>',
            '<td><a href="#"  class="sil"> <img src="{{asset("images/sil1.png")}}"></a><input type="hidden" name="hizmet_id['+kalem_num+']"  id="hizmet_id'+kalem_num+'" value=""></td>','</tr>'].join(''));
    }
    else if(sozlesme_turu=="1" && $("#goturu_kalem0").length==0){

          i = ($(".goturu_show").length) +1;
          kalem_num = i-1;

     $("#goturu_table").append(['<tr>','<td>'+i+'</td>',
            '<td><input type="text" style="background:url({{asset("images/ekle.png")}}) no-repeat scroll ;padding-left:25px" class="form-control goturu_show required" id="goturu_kalem'+kalem_num+'" name="goturu_kalem['+kalem_num+']" placeholder="Kalem Ekle" readonly  value="" data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"> </td>',

            '<td><textarea id="goturu_aciklama" name="goturu_aciklama['+kalem_num+']" rows="2" class="form-control required " placeholder="Açıklama" data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"></textarea></td>',
            '<td><input type="number" class="form-control required" id="goturu_miktar" name="goturu_miktar['+kalem_num+']" placeholder="Miktar" value="" data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"></td>',

            '<td><select class="form-control selectpicker required" name="goturu_miktar_birim_id['+kalem_num+']" id="goturu_miktar_birim_id" data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"><option selected disabled>Seçiniz</option>@foreach($birimler as $miktar_birim) <option  value="{{$miktar_birim->id}}" >{{$miktar_birim->adi}}</option>@endforeach</select></td>',
            '<td><a href="#"  class="sil"> <img src="{{asset("images/sil1.png")}}"></a><input type="hidden" name="goturu_id['+kalem_num+']"  id="goturu_id'+kalem_num+'" value=""></td>','</tr>'].join(''));

    }
    else if(sozlesme_turu=="1" && $("#goturu_kalem0").length>0){
        alert("Götürü Bedel İlanlara Sadece 1 Kalem Eklenebilir!");
    }
    else if(ilan_turu=="3"){

          i = ($(".yapim_show").length) +1;
          kalem_num = i-1;

      $("#yapim_table").append(['<tr>','<td>'+i+'</td>',
            '<td><input type="text" style="background:url({{asset("images/ekle.png")}}) no-repeat scroll ;padding-left:25px" class="form-control yapim_show required" id="yapim_kalem'+kalem_num+'" name="yapim_kalem['+kalem_num+']" placeholder="Kalem Ekle" readonly  value="" data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"> </td>',
            '<td><textarea id="yapim_aciklama" name="yapim_aciklama['+kalem_num+']" rows="2" class="form-control required" placeholder="Açıklama" data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"></textarea></td>',
            '<td><input type="text" class="form-control required" id="yapim_fiyat_standardi" name="yapim_fiyat_standardi['+kalem_num+']" placeholder="Fiyat Standartı" value="" data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"></td>',
            '<td><select class="form-control selectpicker required" name="yapim_fiyat_standardi_birimi['+kalem_num+']" id="yapim_fiyat_standardi_birimi" data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"><option selected disabled>Seçiniz</option>@foreach($birimler as $fiyat_birimi)<option  value="{{$fiyat_birimi->id}}" >{{$fiyat_birimi->adi}}</option>@endforeach</select></td>',
            '<td><input type="number" class="form-control required" id="yapim_miktar'+kalem_num+'" name="yapim_miktar['+kalem_num+']" placeholder="Miktar" value="" data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"></td>',
            '<td><select class="form-control selectpicker required" name="yapim_miktar_birim_id['+kalem_num+']" id="yapim_miktar_birim_id" data-validation="required" data-validation-error-msg="Lütfen bu alanı doldurunuz!"><option selected disabled>Seçiniz</option>@foreach($birimler as $miktar_birim) <option  value="{{$miktar_birim->id}}" >{{$miktar_birim->adi}}</option>@endforeach</select></td>',
            '<td><a href="#" class="sil" > <img src="{{asset("images/sil1.png")}}"></a><input type="hidden" name="yapim_id['+kalem_num+']"  id="yapim_id'+kalem_num+'" value=""></td>','</tr>'].join(''));
    }
    $('.selectpicker').selectpicker('refresh');
});
//kalemleri silme
$('#mal_table').on('click', '.sil', function(e) {

    e.preventDefault();
    i = $(".mal_show").length;
    if(i > 1)
      $(this).parents('tr').first().remove();
});
$('#hizmet_table').on('click', '.sil', function(e) {

    e.preventDefault();
    i = $(".hizmet_show").length;
    if(i > 1)
      $(this).parents('tr').first().remove();
});
$('#goturu_table').on('click', '.sil', function(e) {

    e.preventDefault();
    i = $(".goturu_show").length;
    if(i > 1)
      $(this).parents('tr').first().remove();
});
$('#yapim_table').on('click', '.sil', function(e) {

    e.preventDefault();
    i = $(".yapim_show").length;
    if(i > 1)
      $(this).parents('tr').first().remove();
});
//kalem tree modaliını açma.
$('#mal_table').on('click', '.mal_show', function(event) {
     kalemAgaci();
  var input_id=event.target.id;
  $(".m_kalemAgaci #input_mal_id").val(input_id);
  $('.m_kalemAgaci').modal('show');
});
$('#hizmet_table').on('click', '.hizmet_show', function(event) {

     kalemAgaci();
    var input_id=event.target.id;
    $(".m_kalemAgaci #input_hizmet_id").val(input_id);
    $('.m_kalemAgaci').modal('show');
});
$('#goturu_table').on('click', '.goturu_show', function(event) {
     kalemAgaci();
    var input_id=event.target.id;
    $(".m_kalemAgaci #input_goturu_id").val(input_id);
    $('.m_kalemAgaci').modal('show');
});
$('#yapim_table').on('click', '.yapim_show', function(event) {
     kalemAgaci();
    var input_id=event.target.id;
    $(".m_kalemAgaci #input_yapim_id").val(input_id);
    $('.m_kalemAgaci').modal('show');
});
 function getSektor(mal_turu) {
        if (mal_turu > 0) {
            $("#firma_sektor").get(0).options.length = 0;
            $("#firma_sektor").get(0).options[0] = new Option("Yükleniyor", "-1");

            $.ajax({
                type: "GET",
                url: "{{asset('getSektorler')}}",
                data:{mal_turu:mal_turu},
                contentType: "application/json; charset=utf-8",

                success: function(msg) {
                    console.log(msg);
                    $("#firma_sektor").get(0).options.length = 0;
                    $("#firma_sektor").get(0).options[0] = new Option("Seçiniz", "-1");

                    $.each(msg, function(index, sektor) {
                        $("#firma_sektor").get(0).options[$("#firma_sektor").get(0).options.length] = new Option(sektor.adi, sektor.id);
                    });

                        $('.selectpicker').selectpicker('refresh');

                },
                async: false,
                error: function() {
                    $("#firma_sektor").get(0).options.length = 0;
                    alert("Sektörler  yükelenemedi!!!");
                }
            });
        }
        else {
            $("#firma_sektor").get(0).options.length = 0;
        }
    }
</script>
<script type="text/javascript"> //kalemAgacı scriptleri
glyph_opts = {
  map: {
    checkbox: "glyphicon glyphicon-unchecked",
    checkboxSelected: "glyphicon glyphicon-check",
    checkboxUnknown: "glyphicon glyphicon-share",
    dragHelper: "glyphicon glyphicon-play",
    dropMarker: "glyphicon glyphicon-arrow-right",
    error: "glyphicon glyphicon-warning-sign",
    expanderClosed: "glyphicon glyphicon-plus",
    expanderLazy: "glyphicon glyphicon-plus",  // glyphicon-plus-sign
    expanderOpen: "glyphicon glyphicon-minus",  // glyphicon-collapse-down
    //folder: "glyphicon glyphicon-plus",
    //folderOpen: "glyphicon glyphicon-minus",
    loading: "glyphicon glyphicon-refresh glyphicon-spin"
  }
};
function kalemAgaci(){
    $("#tree").remove();
    $(".ftree").append('<div id="tree"></div>');

  // Initialize Fancytree
  $("#tree").fancytree({
    extensions: ["filter", "glyph"],
    quicksearch: true,
    checkbox: true,
    glyph: glyph_opts,
    selectMode: 1,
    source: {
      data:{id:0},
      url: "{{asset('findChildrenTree')}}"+"/"+sektor,
      dataType:'json', debugDelay: 1000
    },
    filter: {
      autoApply: true,   // Re-apply last filter if lazy data is loaded
      autoExpand: true, // Expand all branches that contain matches while filtered
      counter: false,     // Show a badge with number of matching child nodes near parent icons
      fuzzy: false,      // Match single characters in order, e.g. 'fb' will match 'FooBar'
      hideExpandedCounter: true,  // Hide counter badge if parent is expanded
      hideExpanders: false,       // Hide expanders if all child nodes are hidden by filter
      highlight: true,   // Highlight matches by wrapping inside <mark> tags
      leavesOnly: false, // Match end nodes only
      nodata: true,      // Display a 'no data' status node if result is empty
      mode: "hide"       // Grayout unmatched nodes (pass "hide" to remove unmatched node instead)
    },
    toggleEffect: { effect: "drop", options: {direction: "left"}, duration: 200 },

    activate: function(event, data) {
   // alert("activate " + data.node);
    },
    lazyLoad: function(event, data){
		var node = data.node;
        data.result = {
		  url: "{{asset('findChildrenTree')}}"+"/"+sektor,
        debugDelay: 1000,
                    data: {id: node.key},
                    dataType:'json',
          cache: false
        }
      }
  });
  $(".fancytree-container").toggleClass("fancytree-connectors");

  $("input[name=search]").keyup(function(e){
    var n,
      tree = $.ui.fancytree.getTree(),
      args = "autoApply autoExpand fuzzy hideExpanders highlight leavesOnly nodata".split(" "),
      opts = {},
      filterFunc = $("#branchMode").is(":checked") ? tree.filterBranches : tree.filterNodes,
      match = $(this).val();

    $.each(args, function(i, o) {
      opts[o] = $("#" + o).is(":checked");
    });
    opts.mode = $("#hideMode").is(":checked") ? "hide" : "dimm";

    if(e && e.which === $.ui.keyCode.ESCAPE || $.trim(match) === ""){
      $("button#btnResetSearch").click();
      return;
    }
    if($("#regex").is(":checked")) {
      // Pass function to perform match
      n = filterFunc.call(tree, function(node) {
        return new RegExp(match, "i").test(node.title);
      }, opts);
    } else {
      // Pass a string to perform case insensitive matching
      n = filterFunc.call(tree, match, opts);
    }
    $("button#btnResetSearch").attr("disabled", false);
    $("span#matches").text("(" + n + " matches)");
  }).focus();
  $("button#btnResetSearch").click(function(e){
    $("input[name=search]").val("");
    $("span#matches").text("");
    tree.clearFilter();
  }).attr("disabled", true);
  $("fieldset input:checkbox").change(function(e){
      var id = $(this).attr("id"),
        flag = $(this).is(":checked");

      // Some options can only be set with general filter options (not method args):
      switch( id ){
      case "counter":
      case "hideExpandedCounter":
        tree.options.filter[id] = flag;
        break;
      }
      tree.clearFilter();
      $("input[name=search]").keyup();
  });
}
$("#tamamBtn").click(function(){
    if(ilan_turu==1 &&sozlesme_turu==0)
    {
      var tree = $("#tree").fancytree("getTree");
      var kalem_id=tree.getSelectedNodes();
      var sel_key= $.map(kalem_id,function(node){
        var mal_kalem_id=$("#input_mal_id").val();
          $("#"+mal_kalem_id).val(node.title);
           var id = mal_kalem_id.substring(9,mal_kalem_id.lenght);
           $("#mal_id"+id).val(node.key);
         });
        $('.m_kalemAgaci').modal('hide');
        $("#tree").fancytree("getTree").visit(function(node){
           node.setSelected(false);
        });
    }
    else if(ilan_turu==2 && sozlesme_turu==0){

        var tree = $("#tree").fancytree("getTree");
        var kalem_id=tree.getSelectedNodes();
        var sel_key= $.map(kalem_id,function(node){
        var hizmet_kalem_id=$("#input_hizmet_id").val();
          $("#"+hizmet_kalem_id).val(node.title);
        var id = hizmet_kalem_id.substring(12,hizmet_kalem_id.lenght);
           $("#hizmet_id"+id).val(node.key);
         });
        $('.m_kalemAgaci').modal('hide');
        $("#tree").fancytree("getTree").visit(function(node){
          node.setSelected(false);
        });
    }
    else if(sozlesme_turu==1){

        var tree = $("#tree").fancytree("getTree");
        var kalem_id=tree.getSelectedNodes();
        var sel_key= $.map(kalem_id,function(node){
        var goturu_kalem_id=$("#input_goturu_id").val();
          $("#"+goturu_kalem_id).val(node.title);
        var id = goturu_kalem_id.substring(12,goturu_kalem_id.lenght);
           $("#goturu_id"+id).val(node.key);
         });
        $('.m_kalemAgaci').modal('hide');
        $("#tree").fancytree("getTree").visit(function(node){
          node.setSelected(false);
        });
    }
    else if(ilan_turu==3){
        var tree = $("#tree").fancytree("getTree");
        var kalem_id=tree.getSelectedNodes();
        var sel_key= $.map(kalem_id,function(node){
        var yapim_kalem_id=$("#input_yapim_id").val();
          $("#"+yapim_kalem_id).val(node.title);
        var id = yapim_kalem_id.substring(11,yapim_kalem_id.lenght);
           $("#yapim_id"+id).val(node.key);
         });
        $('.m_kalemAgaci').modal('hide');
        $("#tree").fancytree("getTree").visit(function(node){
          node.setSelected(false);
        });
    }
  });

var firma_id='{{$firma->id}}';

$(function() {
    var dt = new Date();
    dt.setDate(dt.getDate() + 3);
    var is_tarihi_start= new Date();
    $('input[name="ilan_tarihi_araligi"]').daterangepicker({
                locale: {
                  format: 'DD/MM/YYYY',
                    "applyLabel": "Uygula",
                    "cancelLabel": "Vazgeç",
                    "fromLabel": "Dan",
                    "toLabel": "a",
                    "customRangeLabel": "Seç",
                    "daysOfWeek": [
                        "Pt",
                        "Sl",
                        "Çr",
                        "Pr",
                        "Cm",
                        "Ct",
                        "Pz"
                    ],
                    "monthNames": [
                        "Ocak",
                        "Şubat",
                        "Mart",
                        "Nisan",
                        "Mayıs",
                        "Haziran",
                        "Temmuz",
                        "Ağustos",
                        "Eylül",
                        "Ekim",
                        "Kasım",
                        "Aralık"
                    ],
                    "firstDay": 1
                },
                    startDate: new Date(),
                    endDate: dt
      },function(start, end, label) {
            is_tarihi_start=end.format('DD/MM/YYYY');
            var is_tarihi_end=end.format('DD/MM/YYYY');

          $('input[name="is_tarihi_araligi"]').daterangepicker({
                    locale: {
                      format: 'DD/MM/YYYY',
                     "applyLabel": "Uygula",
                    "cancelLabel": "Vazgeç",
                    "fromLabel": "Dan",
                    "toLabel": "a",
                    "customRangeLabel": "Seç",
                    "daysOfWeek": [
                        "Pt",
                        "Sl",
                        "Çr",
                        "Pr",
                        "Cm",
                        "Ct",
                        "Pz"
                    ],
                    "monthNames": [
                        "Ocak",
                        "Şubat",
                        "Mart",
                        "Nisan",
                        "Mayıs",
                        "Haziran",
                        "Temmuz",
                        "Ağustos",
                        "Eylül",
                        "Ekim",
                        "Kasım",
                        "Aralık"
                    ],
                    "firstDay": 1
                },
                    startDate: is_tarihi_start,
                    endDate: is_tarihi_end
        });
    });
    $('input[name="is_tarihi_araligi"]').daterangepicker({
                locale: {
                  format: 'DD/MM/YYYY',
                   "applyLabel": "Uygula",
                    "cancelLabel": "Vazgeç",
                    "fromLabel": "Dan",
                    "toLabel": "a",
                    "customRangeLabel": "Seç",
                    "daysOfWeek": [
                        "Pt",
                        "Sl",
                        "Çr",
                        "Pr",
                        "Cm",
                        "Ct",
                        "Pz"
                    ],
                    "monthNames": [
                        "Ocak",
                        "Şubat",
                        "Mart",
                        "Nisan",
                        "Mayıs",
                        "Haziran",
                        "Temmuz",
                        "Ağustos",
                        "Eylül",
                        "Ekim",
                        "Kasım",
                        "Aralık"
                    ],
                    "firstDay": 1

                },
                startDate:new Date(),
                endDate: dt
     });
});

//FORM WIZARD VALIDATION, SOZLESME VE SUBMIT
    var FormWizard = function () {
        return {
            //main function to initiate the module
            init: function () {
                if (!jQuery().bootstrapWizard) {
                    return;
                }

                function format(state) {
                    return state.text;
                }

                var form = $('#submit_form');
                var error = $('.alert-danger', form);
                var success = $('.alert-success', form);

                form.validate({
                    doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                    errorElement: 'span', //default input error message container
                    errorClass: 'help-block help-block-error', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    rules: {
                        sozlesme_onay: {
                            required: true
                        },
                    },

                    messages: {
                        sozlesme_onay: {
                            required: "Sözleşmeyi Onaylamanız Gerekmektedir",
                        }
                    },

                    errorPlacement: function (error, element) { // render error placement for each input type
                        if (element.attr("name") == "gender") { // for uniform radio buttons, insert the after the given container
                            error.insertAfter("#form_gender_error");
                        } else if (element.attr("name") == "payment[]") { // for uniform checkboxes, insert the after the given container
                            error.insertAfter("#form_payment_error");
                        } else {
                            error.insertAfter(element); // for other inputs, just perform default behavior
                        }
                    },

                    invalidHandler: function (event, validator) { //display error alert on form submit
                        success.hide();
                        error.show();
                        App.scrollTo(error, -200);
                    },

                    highlight: function (element) { // hightlight error inputs
                        $(element)
                            .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                    },

                    unhighlight: function (element) { // revert the change done by hightlight
                        $(element)
                            .closest('.form-group').removeClass('has-error'); // set error class to the control group
                    },

                    success: function (label) {
                        if (label.attr("for") == "gender" || label.attr("for") == "payment[]") { // for checkboxes and radio buttons, no need to show OK icon
                            label
                                .closest('.form-group').removeClass('has-error').addClass('has-success');
                            label.remove(); // remove error label here
                        } else { // display success icon for other inputs
                            label
                                .addClass('valid') // mark the current input as valid and display OK icon
                                .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                        }
                    },

                    submitHandler: function (form) {
                        success.show();
                        error.hide();

                        for ( instance in CKEDITOR.instances )
                            CKEDITOR.instances[instance].updateElement();
                        var postData = new FormData(form[0]);
                        var formURL = form.attr('action');

                        $.ajax(
                            {
                                beforeSend: function(){
                                    $('.ajax-loader').css("visibility", "visible");
                                },
                                url : formURL,
                                type: "POST",
                                contentType: false,
                                processData: false,
                                data : postData,
                                success:function(data, textStatus, jqXHR)
                                {

                                    // let the browser natively reset defaults
                                    form[0].reset();
                                    setTimeout(function(){
                                        window.location = "{{asset('ilanlarim')}}/{{$firma->id}}";
                                    }, 5);

                                    e.preventDefault();
                                },
                                error: function(jqXHR, textStatus, errorThrown)
                                {
                                    console.log(jqXHR);
                                    alert(textStatus + "," + errorThrown+","+jqXHR);
                                    $('.ajax-loader').css("visibility", "hidden");
                                }
                            });
                        e.preventDefault(); //STOP default action
                    }
                });

                var displayConfirm = function() {
                    $('#tab4 .form-control-static', form).each(function(){
                        var input = $('[name="'+$(this).attr("data-display")+'"]', form);
                        if (input.is(":radio")) {
                            input = $('[name="'+$(this).attr("data-display")+'"]:checked', form);
                        }
                        if (input.is(":text") || input.is("textarea")) {
                            $(this).html(input.val());
                        } else if (input.is("select")) {
                            $(this).html(input.find('option:selected').text());
                        } else if (input.is(":radio") && input.is(":checked")) {
                            $(this).html(input.attr("data-title"));
                        } else if ($(this).attr("data-display") == 'payment[]') {
                            var payment = [];
                            $('[name="payment[]"]:checked', form).each(function(){
                                payment.push($(this).attr('data-title'));
                            });
                            $(this).html(payment.join("<br>"));
                        }
                    });
                }

                var handleTitle = function(tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    // set wizard title
                    $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                    // set done steps
                    jQuery('li', $('#form_wizard_1')).removeClass("done");
                    var li_list = navigation.find('li');
                    for (var i = 0; i < index; i++) {
                        jQuery(li_list[i]).addClass("done");
                    }

                    if (current == 1) {
                        $('#form_wizard_1').find('.button-previous').hide();
                    } else {
                        $('#form_wizard_1').find('.button-previous').show();
                    }

                    if (current >= total) {
                        $('#form_wizard_1').find('.button-next').hide();
                        $('#form_wizard_1').find('.button-submit').show();
                        $(".info-box").append('<li style="list-style-type:circle">Firma Adi Göster: '+$("input[type='radio']:checked").next('label:first').html+'</li>');
                        $(".info-box").append('<li style="list-style-type:circle">İlan Adı: '+$("#ilan_adi").val()+'</li>');
                        $(".info-box").append('<li style="list-style-type:circle">İlan Türü: '+$( "#ilan_turu option:selected" ).text()+'</li>');
                        $(".info-box").append('<li style="list-style-type:circle">İlan Sektörü: '+$( "#firma_sektor option:selected" ).text()+'</li>');
                        $(".info-box").append('<li style="list-style-type:circle">İlan Yayın-Kapanma Tarihi: '+$( "#ilan_tarihi_araligi option:selected" ).text()+'</li>');
                        $(".info-box").append('<li style="list-style-type:circle">İş Süresi: '+$( "#isin_suresi option:selected" ).text()+'</li>');
                        $(".info-box").append('<li style="list-style-type:circle">İş Başlama-Bitiş Tarihi: '+$( "#is_tarihi_araligi option:selected" ).text()+'</li>');
                        $(".info-box").append('<li style="list-style-type:circle">Teknik Şartname: '+$( "#teknik" ).val()+'</li>');
                        $(".info-box").append('<li style="list-style-type:circle">Katılımcılar: '+$( "#katilimcilar option:selected" ).text()+'</li>');
                        $(".info-box").append('<li style="list-style-type:circle">Rekabet Şekli: '+$( "#rekabet_sekli option:selected" ).text()+'</li>');
                        $(".info-box").append('<li style="list-style-type:circle">Sözleşme Türü: '+$( "#sozlesme_turu option:selected" ).text()+'</li>');
                        $(".info-box").append('<li style="list-style-type:circle">Fiyatlandırma Şekli: '+$( "#kismi_fiyat option:selected" ).text()+'</li>');
                        $(".info-box").append('<li style="list-style-type:circle">Yaklaşık Maliyet: '+$( "#yaklasik_maliyet option:selected" ).text()+'</li>');
                        $(".info-box").append('<li style="list-style-type:circle">Ödeme Türü: '+ $("#odeme_turu option:selected" ).text()+'</li>');
                        $(".info-box").append('<li style="list-style-type:circle">Para Birimi: '+ $("#para_birimi option:selected" ).text()+'</li>');
                        $(".info-box").append('<li style="list-style-type:circle">Teslim Yeri: '+ $( "#teslim_yeri option:selected" ).text()+'</li>');
                        displayConfirm();
                    } else {
                        $('#form_wizard_1').find('.button-next').show();
                        $('#form_wizard_1').find('.button-submit').hide();
                    }
                    App.scrollTo($('.page-title'));
                }

                // default form wizard
                $('#form_wizard_1').bootstrapWizard({
                    'nextSelector': '.button-next',
                    'previousSelector': '.button-previous',
                    onTabClick: function (tab, navigation, index, clickedIndex) {
                        return false;

                        success.hide();
                        error.hide();
                        if (form.valid() == false) {
                            return false;
                        }

                        handleTitle(tab, navigation, clickedIndex);
                    },
                    onNext: function (tab, navigation, index) {
                        success.hide();
                        error.hide();

                        if (form.valid() == false) {
                            return false;
                        }

                        handleTitle(tab, navigation, index);
                    },
                    onPrevious: function (tab, navigation, index) {
                        success.hide();
                        error.hide();

                        handleTitle(tab, navigation, index);
                    },
                    onTabShow: function (tab, navigation, index) {
                        var total = navigation.find('li').length;
                        var current = index + 1;
                        var $percent = (current / total) * 100;
                        $('#form_wizard_1').find('.progress-bar').css({
                            width: $percent + '%'
                        });
                    }
                });

                $('#form_wizard_1').find('.button-previous').hide();
                $('#form_wizard_1 .button-submit').hide();

                //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
                $('#country_list', form).change(function () {
                    form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
                });
            }
        };
    }();

    jQuery(document).ready(function() {
        CKEDITOR.config.autoParagraph = false;
        FormWizard.init();
    });
</script>
@endsection

@section('sayfaSonu')
    <script src="{{asset('MetronicFiles/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('MetronicFiles/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}" type="text/javascript"></script>
@endsection