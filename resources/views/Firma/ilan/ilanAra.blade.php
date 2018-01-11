@extends('layouts.appUser')
@section('baslik')
    <div class='row content'>
        <div class="container">
            <div class="col-sm-4" id="ilanCount">
                <?php $ilanCount = DB::table('ilanlar')->count();?>
                <h4>Arama kriterlerinize uyan <img src="{{asset('images/sol.png')}}"> </h4>
            </div>
            <div class="col-sm-6">
                <ul style="list-style: none outside none;">
                    <?php $j=0; ?>
                    <li id="multiSel{{$j}}">
                    </li>
                </ul>
            </div>
            <div class=" col-sm-2">
                <div style="padding: 20px; float: right;">
                    <a class="btn bold btn-circle btn-outline purple" id="temizleButton">
                        <span aria-hidden="true" class="icon-trash"></span> Temizle
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('head')
    <style>
        input[type=text] {
            width: 200px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: white;
            background-position: 10px 10px;
            background-repeat: no-repeat;
            padding: 10px 10px 10px 10px;
            -webkit-transition: width 0.4s ease-in-out;
            transition: width 0.4s ease-in-out;
        }

        a {
            color: #000;
        }
        .dropdown dd,
        .dropdown dt {
            margin: 0px;
            padding: 0px;
        }

        .dropdown ul {
            margin: -1px 0 0 0;
        }

        .dropdown dd {
            position: relative;
        }


        .dropdown dt a {
            background-color: #FFF;
            display: block;

            min-height: 25px;
            line-height: 24px;
            overflow: hidden;
            border: 0;
            border-radius: 4px;
            width: 250px;
        }

        .dropdown dt a span,
        .multiSel span {
            cursor: pointer;
            display: inline-block;
            padding: 0 3px 2px 0;
        }

        .dropdown dd ul {
            background-color: purple;
            border: 0;
            color: #fff;
            display: none;
            left: 0px;
            padding: 2px 15px 2px 5px;
            position: absolute;
            top: 2px;
            width: 250px;
            list-style: none;
            height: 170px;
            overflow: auto;
        }

        .dropdown span.value {
            display: none;
        }

        .dropdown dd ul li a {
            padding: 5px;
            display: block;
        }

        .dropdown dd ul li a:hover {
            background-color: #fff;
        }

        .pclass {
            color: #cc00c0;
            border-radius: 3px;
            display: inline-block;
            zoom: 1;
            font-size: small;
            padding: 2px;
        }
        .ajax-loader {
            visibility: hidden;
            background-color: rgba(255,255,255,0.7);
            position: absolute;
            z-index: +100 !important;
            width: 100%;
            height:100%;
        }

        .ajax-loader img {
            position: relative;
            top:50%;
            left:32%;
        }
        .trigger {
            /* font: 16px/1 'roboto-m'; */
            color: #333;
            background: #eee;
            display: block;
            padding: 20px 15px 20px 45px;
        }
    </style>
    <link href="{{asset('css/multiple-select.css')}}" rel="stylesheet"/>
@endsection
@section('bodyAttributes')
    style="overflow-x:hidden"
@endsection
 @section('content')
    <div id="FilterSection" class="row content">
        <div class="col-sm-3">
            <div class="row">
                <div class="portlet box purple">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-paper-plane"></i>
                            Detaylı İlan Arama
                        </div>
                    </div>
                    <div class="portlet-body">
                        <h4>Kelime Ara</h4>
                        <div id="radioDiv3">
                            <form action="javascript:runCheck()">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" id="search" placeholder="Anahtar Kelime">
                                    <span class="input-group-btn">
                                                <button id="button" class="btn purple uppercase bold" type="button"><i class="icon-magnifier"></i></button>
                                            </span>
                                </div>
                                <input type="radio" name="searchBox" value="tum" checked="checked"> Tüm İlanda<br>
                                <input type="radio" name="searchBox" value="ilan_baslık"> Sadece İlan Başlığında<br>
                                <input type="radio" name="searchBox" value="firma"> Sadece Firma Adında Ara
                            </form>
                        </div>
                        <hr>
                        <h4>Şehirlere Göre Ara</h4>
                        <dl style="margin-bottom:0px" class="dropdown">
                            <dt>
                                <a href="#" style="padding:2px"><span class="hida">Seçiniz<span class="caret"></span></span></a>
                            </dt>
                            <dd>
                                <div class="mutliSelect">
                                    <ul>
                                        @foreach($iller as $il)
                                            <li><input type="checkbox" value="{{$il->id}}" name="{{$il->adi}}" />{{$il->adi}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </dd>
                        </dl>
                        <hr>
                        <h4>Tarihe Göre Ara</h4>
                        <p>Başlangıç Tarihi</p>
                        <input type="date" class="form-control datepicker" id="baslangic_tarihi" name="baslangic_tarihi" placeholder="" value="">
                        <br>
                        <p>Bitiş Tarihi</p>
                        <input type="date" class="form-control datepicker" id="bitis_tarihi" name="bitis_tarihi" placeholder="" value="">
                        <hr>
                        <h4>Sektöre Göre Ara</h4>
                        <select id="sektorler"   name="sektorler[]" multiple="multiple">
                            @foreach($sektorler as $sektor)
                                <option data-toggle="tooltip" data-placement="bottom" title="{{$sektor->adi}}" value="{{$sektor->id}}">{{$sektor->adi}}</option>
                            @endforeach
                        </select>
                        <hr>
                        <div id="radioDiv">
                        <h4>ilan Türüne Göre Ara</h4>
                        <input type="radio" name="ilanTuru[]" class="tur" value="Mal"><span class="lever"></span>Mal<br>
                        <input type="radio" name="ilanTuru[]" class="tur" value="Hizmet"><span class="lever"></span>Hizmet<br>
                        <input type="radio" name="ilanTuru[]" class="tur" value="Yapım İşi"><span class="lever"></span>Yapım İşi
                        </div>
                        <hr>

                        <div id="radioDiv4">
                        <h4>Sözleşme Türüne Göre Ara</h4>
                        <input type="radio" name="sozlesmeTuru[]" class="sozlesme" value="Birim Fiyatlı"><span class="lever"></span>Birim Fiyatlı<br>
                        <input type="radio" name="sozlesmeTuru[]" class="sozlesme" value="Götürü Bedel"><span class="lever"></span>Götürü Bedel<br>
                        <hr>
                        <h4>Ödeme Türüne Göre Ara</h4>
                        @foreach($odeme_turleri as $odeme)
                            <input type="checkbox" class="checkboxClass2" value="{{$odeme->id}}" name="{{$odeme->adi}}"> {{$odeme->adi}}<br>
                        @endforeach
                        </div>
                        <hr>

                        <div id="radioDiv2">
                        <h4>İlan Usülüne Göre Ara</h4>
                        <input type="radio" name="gender[]" class="usul" value="Açık"> Açık<br>
                        <input type="radio" name="gender[]" class="usul" value="Belirli İstekliler Arasında">Belirli İstekler Arasında<br>
                        <input type="radio" name="gender[]" class="usul" value="Başvuru">Başvuru
                        </div>
                    </div>
                </div>
            </div>
        </div>
                 @if(count($firma->belirli_istekliler) != 0 )
                <div class="col-sm-9">
                     <div class="portlet light ">
                         <div class="portlet-title">
                             <div class="caption caption-md">
                                 <i class="icon-envelope-open theme-font"></i>
                                 <span class="caption-subject theme-font bold uppercase">Davet Edildiğiniz İlanlar</span>
                             </div>
                         </div>
                         <div class="portlet-body">
                             @foreach ($firma->belirli_istekliler as $davetEdildigimIlan)
<div class="row hover" style="padding-top: 20px;">
                                 <div class="ilanDetayPop " name="{{$davetEdildigimIlan->ilanlar->id}}">

                                     <div class="pop-up"  style="display: none;
                                                                position: absolute;
                                                                left: 200px;
                                                                width: 300px;
                                                                padding: 10px;
                                                                background: #8E44AD;
                                                                color: #fff;
                                                                border: 1px solid #1a1a1a;
                                                                font-size: 90%;
                                                                border-radius: 5px;
                                                                z-index: 1000;">
                                         <p id="popIlanAdi"><img src="{{asset('images/ok.png')}}"><strong>İlan Adı :</strong> {{$davetEdildigimIlan->ilanlar->adi}}</p>
                                         <p id="popIlanTuru"><img src="{{asset('images/ok.png')}}"><strong>İlan Türü :</strong> {{$davetEdildigimIlan->ilanlar->getIlanTuru()}}</p>
                                         <p id="popIlanUsulu"><img src="{{asset('images/ok.png')}}"><strong>Usulü : </strong>{{$davetEdildigimIlan->ilanlar->getRekabet()}}</p>
                                         <p id="popIlanSektoru"><img src="{{asset('images/ok.png')}}"><strong>İlan Sektörü :</strong>{{$davetEdildigimIlan->ilanlar->sektorler->adi}}</p>
                                         <p id="popIlanAciklama"><img src="{{asset('images/ok.png')}}"><strong>Açıklama : </strong>{{$davetEdildigimIlan->ilanlar->aciklama}}</p>
                                         <p id="popIlanIsinSuresi"><img src="{{asset('images/ok.png')}}"><strong>İşin Süresi:</strong> {{$davetEdildigimIlan->ilanlar->isin_suresi}}</p>
                                         <p id="popIlanSözlesmeTuru"><img src="{{asset('images/ok.png')}}"><strong>Sözleşme Türü : </strong>{{$davetEdildigimIlan->ilanlar->getSozlesmeTuru()}}</p>
                                     </div>
                                     <div class="col-sm-10">
                                         <p><b>İlan Adı: {{$davetEdildigimIlan->ilanlar->adi}}</b></p>
                                         @if($davetEdildigimIlan->ilanlar->firmalar->puanlamaOrtalama() > 0)
                                             <div class="puanlama">{{$davetEdildigimIlan->ilanlar->firmalar->puanlamaOrtalama()}}</div>
                                             <p><a href="{{url('firmaDetay/'.$davetEdildigimIlan->ilanlar->firmalar->id)}}" >Firma: {{$davetEdildigimIlan->ilanlar->firmalar->adi}}</a></p>
                                         @else
                                             <p><a href="{{url('firmaDetay/'.$davetEdildigimIlan->ilanlar->firmalar->id)}}" style="padding: 0px" >Firma: {{$davetEdildigimIlan->ilanlar->firmalar->adi}}</a></p>
                                         @endif
                                         <p>{{$davetEdildigimIlan->ilanlar->adi}}</p>

                                         <p style="font-size: 13px;color: #999">{{date('d-m-Y', strtotime($davetEdildigimIlan->ilanlar->yayin_tarihi))}}</p>
                                     </div>
                                     <div class="col-sm-2">
                                         @if(Auth::guest())
                                         @else
                                             <a href="#"><button type="button" class="btn purple btn-circle" name="{{$davetEdildigimIlan->ilanlar->firmalar->id}} {{$davetEdildigimIlan->ilanlar->id}}" id="{{$davetEdildigimIlan->ilanlar->id}}"style='float:right;margin-top:60px'><i class="icon-target"></i> Başvur</button></a><br><br>
                                         @endif
                                     </div>
                                 </div>

</div>
                                 <hr />
                             @endforeach
                         </div>
                     </div>
                </div>
                 @endif
                <div class="col-sm-9 ilanlar" id="auto_load_div">
                   @include('Firma.ilan.ilanlar')
               </div>
                <div class="ajax-loader">
                    <img src="{{asset('images/200w.gif')}}" class="img-responsive" />
                </div>
            </div>
 @endsection
@section('sayfaSonu')
    <script src="{{asset('js/multiple-select.js')}}"></script>
    <script type="text/javascript">
    var sektor = new Array();
    $("#sektorler").multipleSelect({
            width: 260,
            multiple: true,
            multipleWidth: 200,
            placeholder: "Seçiniz",
            filter: true,
            onClick: function() {
                var sonSecilen="";
                var id=0;
                
                console.log($(this));
              
                $('#sektorler option:selected').each(function() {
                    sonSecilen = $(this).text();
             
                    id=$(this).val();
                    if(jQuery.inArray(sonSecilen, sektor) === -1){
                        sektor.push(sonSecilen);
                        return false;
                    }
                });
                console.log(sonSecilen);
                if(sonSecilen !== ""){
                    doldurma(sonSecilen,"s"+id);
                }
                getIlanlar(1);
            }
    });
    $("#temizleButton").click(function(){ //////////// Bütün filtreler kalkması için ///////

       $(".silmeButton").each(function(){
           $(this).click();
       });
       return false;
    });
    function silme(name){
            $('li[name='+name+']').remove();
            if(name === "Tarım" || name === "Hizmet"){
                $('.checkboxClass[name='+name+']').prop("checked", false);
                getIlanlar(1);
            }
            if(name === "Nakit" || name === "KrediKartı" || name === "Havale" || name === "Çek" || name === "Senet"){
                $('.checkboxClass2[name='+name+']').prop("checked", false);
                getIlanlar(1);
            }
            if(name === "Mal" || name === "Hizmet" || name === "Yapımİşi"){

                $("#radioDiv input[type='radio']").each(function(){

                    $(this).prop('checked', false);
                });
                getIlanlar(1);
            }
            if(name === "Açık" || name === "BelirliİsteklilerArasında" || name === "Başvuru"){

                $("#radioDiv2 input[type='radio']").each(function(){

                    $(this).prop('checked', false);

                });
                getIlanlar(1);
            }
            if(name === "BirimFiyatlı" || name === "GötürüBedel"){
                $("#radioDiv4 input[type='radio']").each(function(){

                    $(this).prop('checked', false);

                });
                getIlanlar(1);
            }
            if(name.indexOf("başlangıç") !== -1){
                $(' input[type=date]').each( function resetDate(){
                    if(name.indexOf(this.value) !== -1){
                        this.value = this.defaultValue;
                    }
                } );
                getIlanlar(1);    
            }
            if($('#search').val() !== null){
                $("#radioDiv3 input[type='radio']").each(function(){
                    $(this).prop('checked', false);
                });
                $('#search').val(null);
            }
            if(name.indexOf("bitiş") !== -1){
                $(' input[type=date]').each( function resetDate(){
                    if(name.indexOf(this.value) !== -1){
                        this.value = this.defaultValue;
                    }
                } );
                getIlanlar(1);

            }
            if(name.substring(0,1) === "s"){
                var id = name.substring(1,name.length);
                $('#sektorler option:selected').each(function() {
                    if($(this).val()=== id){
                        console.log($('input:checkbox[data-name="selectItemsektorler[]"][value="' + id + '"]'));
                       $('input:checkbox[data-name="selectItemsektorler[]"][value="' + id + '"]').trigger("click");
                       
                    }
                });
                getIlanlar(1);
            }else{
                $('.mutliSelect input[type="checkbox"]').each(function(){
                    var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').attr('name'),
                    title = $(this).attr('name');
                    if(name == title){
                        $(this).prop('checked', false);
                    }
                });
                 getIlanlar(1);
            }
        }
    function doldurma(name,code){ // sektorleri kontrol etmek için 2 attribute alıyorum.
            var key=0;
            var birlesmisName;
            $("#multisel"+key).empty();
            if(code.length === 0){
                
            }
            var name1 = code.split(" "); /// Birden fazla kelime kontrolü
            if(name1.length === 1){
                birlesmisName = name1[0];
            }
            else if(name1.length === 2){
                birlesmisName=name1[0]+name1[1];
            }
            else if(name1.length === 3){
                birlesmisName=name1[0]+name1[1]+name1[2];
            }

            var html = '<li class="li" name="'+birlesmisName+'"> <span class="btn-sm btn btn-circle purple" title="' + name + '" style="cursor:auto;">' + name + '<a class="silmeButton btn " onclick=silme("'+birlesmisName+'") style="padding: 1px;margin: 2px; color:white"><i class="icon-close"></i></a></span> </li>';

            $("#multiSel"+key).append(html);                                     
    }
    $('#button').click(function(){
        doldurma("anahtar kelime:"+$('#search').val(),$('#search').val());
        getIlanlar(1);
    });
    $('#il_id').change(function(){
        var il = new Array();
        var n = jQuery('.mutliSelect input[type="checkbox"]').length;
        if (n > 0){
            jQuery('.mutliSelect input[type="checkbox"]:checked').each(function(){
            il.push($(this).val());
            });
        }
        getIlanlar(1);
        doldurma(il,il);
    });
    $('#baslangic_tarihi').change(function(){
        var bas=$('#baslangic_tarihi').val()+"başlangıç";
        getIlanlar(1);
        doldurma(bas,bas);
        });
    $('#bitis_tarihi').change(function(){
        var bit=$('#bitis_tarihi').val()+"bitiş";
        getIlanlar(1);
        doldurma(bit,bit);
    });
    $('.tur').click(function(){
        var tur=$("#radioDiv input[type='radio']:checked").val();
        getIlanlar(1);
        doldurma(tur,tur);
    });
    $('.usul').click(function(){
        var usul=$("#radioDiv2 input[type='radio']:checked").val();
        getIlanlar(1);
        doldurma(usul,usul);
    });
    $('.sozlesme').click(function(){
        var sozlesme=$("#radioDiv4 input[type='radio']:checked").val();
        getIlanlar(1);
        doldurma(sozlesme,sozlesme);
    });
    var odeme = new Array();
    $('.checkboxClass2').click(function(){ ///////////odeme turu /////////////////
        var sonSecilen;
        var n = jQuery('.checkboxClass2:checked').length;
        if (n > 0){
            jQuery('.checkboxClass2:checked').each(function(){
                sonSecilen = $(this).attr('name');
                if(jQuery.inArray(sonSecilen, odeme) === -1){
                console.log(sonSecilen);
                odeme.push(sonSecilen);
                return false;
                }
            });

        }
        getIlanlar(1);
        doldurma(sonSecilen,sonSecilen);
    });
    
    
    $(".dropdown dt a").on('click', function() {
        $(".dropdown dd ul").slideToggle('fast');
    });

    $(".dropdown dd ul li a").on('click', function() {
        $(".dropdown dd ul").hide();
    });

    function getSelectedValue(id) {
        return $("#" + id).find("dt a span.value").html();
    }

    $(document).bind('click', function(e) {
        var $clicked = $(e.target);
        if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
    });

    $('.mutliSelect input[type="checkbox"]').on('click', function() {
        var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').attr('name'),
          title = $(this).attr('name');

        if ($(this).is(':checked')) {
          var html = '<span title="' + title + '">' + title + '</span>';
          $('.multiSel').append(html);
          $(".hida").hide();
          getIlanlar(1);
          doldurma(title,title);
        } else {
          $('span[title="' + title + '"]').remove();
          var ret = $(".hida");
          $('.dropdown dt a').append(ret);
        }
    });

    $(document).ready(function(){

        $(document).on('click', '.pagination a', function (e){
            getIlanlar($(this).attr('href').split('page=')[1]);
            e.preventDefault();
        });
        var sehirId = "{{$ilId}}";
        var keyword = "{{$keyword}}";
        var sektorID = "{{$sektor_id}}";

        if(sehirId != ""){
            jQuery('.mutliSelect input[type="checkbox"]').each(function(){
                if($(this).val() == sehirId ){
                    var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').attr('name'),
                        title = $(this).attr('name');
                    var html = '<span title="' + title + '">' + title + '</span>';
                    $(".hida").append(title+",");
                    $(this).prop( "checked", true );
                    doldurma(title,title);
                }
            });
        }
        if(keyword != ""){
            $("#search").val(keyword);
            doldurma(keyword,keyword);
            $("#radioDiv3 input[type='radio']").each(function(){
                if($(this).val() == "tum"){
                    $(this).prop("checked",true);
                }
            });
        }
        if(sektorID != ""){
            var sektor = new Array();
           
            $("#sektorler").multipleSelect("setSelects", [sektorID]);
              
            var sonSecilen;
            var id=0;
            $('#sektorler option:selected').each(function() {
            
                sonSecilen = $(this).text();
                id=$(this).val();
                if(jQuery.inArray(sonSecilen, sektor) === -1){
                    sektor.push(sonSecilen);
                    return false;
                }
            });
            console.log(sonSecilen,"s"+id);
            
            getIlanlar(1);
            doldurma(sonSecilen,"s"+id);
        }
    });

    function getIlanlar(page) {
        var il_id=$('#il_id').val();
        var basTar=$('#baslangic_tarihi').val();
        var bitTar=$('#bitis_tarihi').val();
        var selectedSektor = new Array();
        var n = $('#sektorler option:selected').length;  ///////////sektor /////////////
        if (n > 0){
            $('#sektorler option:selected').each(function() {
                 selectedSektor.push($(this).val());
            });
           
        }
        var selectedIl = new Array(); /////////// iller //////////////
        var n = jQuery('.mutliSelect input[type="checkbox"]').length;
        if (n > 0){
            jQuery('.mutliSelect input[type="checkbox"]:checked').each(function(){
                    selectedIl.push($(this).val());
            });
        }
        var selectedOdeme = new Array(); /////////// odeme Turu ////////////
        var n = jQuery('.checkboxClass2:checked').length;
        if (n > 0){
            jQuery('.checkboxClass2:checked').each(function(){
                selectedOdeme.push($(this).val());
            });
        }
        var selectedTur = "";   //////////////////ilan türü /////
        var selected = $("#radioDiv input[type='radio']:checked");
        if (selected.length > 0) {
            selectedTur = selected.val();
            if(selectedTur === "Mal"){
                selectedTur = 1;
            }else if(selectedTur === "Hizmet"){
                selectedTur = 2;
            }else{
                selectedTur = 3;
            }
        }
        var selectedUsul = "";   //////////////////////////////İlan Usulü ///////////
        var selected2 = $("#radioDiv2 input[type='radio']:checked");
        if (selected2.length > 0) {
            selectedUsul = selected2.val();
            if(selectedUsul === "Açık"){
                selectedUsul = 1;
            }else if(selectedUsul === "Belirli İstekliler Arasında"){
                selectedUsul = 2;
            }else{
                selectedUsul = 3;
            }
        }
        var selectedSearch = "";    /////////////////////////// search button /////////////////////
        var inputSearch = "";
        var selected3 = $("#radioDiv3 input[type='radio']:checked");
        if (selected3.length > 0) {
            selectedSearch = selected3.val();
            inputSearch=$('#search').val();
        }
        var selectedSozlesme = ""; //////////////////////Sözleşme Türü //////////////////////////
        var selected4 = $("#radioDiv4 input[type='radio']:checked");
        if (selected4.length > 0) {
            selectedSozlesme = selected4.val();
            if(selectedSozlesme === "Birim Fiyatlı"){
                selectedSozlesme = 0;
            }else if(selectedSozlesme === "Götürü Bedel"){
                selectedSozlesme = 1;
            }
        }
        $.ajax({
            beforeSend: function(){
                $('.ajax-loader').css("visibility", "visible");
            },
            url : '?page='+page,
            dataType: 'json',
            data:{il:selectedIl,bas_tar:basTar,bit_tar:bitTar,sektor:selectedSektor,tur:selectedTur,
                        usul:selectedUsul,radSearch:selectedSearch,input:inputSearch,odeme:selectedOdeme,
                        sozles:selectedSozlesme
            },
        }).done(function(data){
            $('.ilanlar').html(data);
            location.hash = page;
            window.scrollTo(0, 0);

            $('.ajax-loader').css("visibility", "hidden");
        }).fail(function(jqXHR, textStatus, errorThrown){ 
            console.log("jqXHR:");
            console.log(jqXHR);
            console.log("textStatus:");
            console.log(textStatus);
            console.log("errorThrown:");
            console.log(errorThrown);
            alert('İlanlar Yüklenemiyor !!!  ');
            $('.ajax-loader').css("visibility", "hidden");
        });
    }

</script>
@endsection