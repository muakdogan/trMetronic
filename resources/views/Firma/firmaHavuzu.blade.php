@extends('layouts.appUser')
@section('baslik')
<div class='row content'>
    <div class="container">
        <div class="col-sm-2">
            <h3>Firma Havuzu</h3>
        </div>
        <div class="col-sm-10">
            <ul style="list-style: none outside none;">
                <?php $j=0; ?>
                <li class="li" id="multiSel{{$j}}">
                </li>
            </ul>
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
            z-index: 1;
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
            background:#fff;
            padding: 2px;
        }
        .li {
            position: relative;
            display: inline;
            margin: 20px;
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
                                <i class="icon-globe"></i>
                                Detaylı Firma Arama
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
                                            <input type="radio" name="searchBox" value="sektor"> Sektör Ara<br>
                                            <input type="radio" name="searchBox" value="sehir" > Şehir Ara<br>
                                            <input type="radio" name="searchBox" value="firma" > Sadece Firma Adında Ara

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
                            <h4>Sektöre Göre Ara</h4>
                            <select id="sektorler"   name="sektorler[]" multiple="multiple">
                                @foreach($sektorler as $sektor)
                                    <option data-toggle="tooltip" data-placement="bottom" title="{{$sektor->adi}}" value="{{$sektor->id}}">{{$sektor->adi}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                </div>
                <div class="col-sm-9 firmalar" id="auto_load_div">
                   @include('Firma.firmalar')
               </div>
                <div class="ajax-loader">
                    <img src="{{asset('images/200w.gif')}}" class="img-responsive" />
                </div>
            </div>
@endsection

@section('sayfaSonu')
    <script src="{{asset('js/multiple-select.js')}}"></script>
    <script>
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
                getFirmalar(1);
            }
        });
        $("#temizleButton").click(function(){ //////////// Bütün filtreler kalkması için ///////
            $(".silmeButton").each(function(){
                $(this).click();
            });
            return false;
        });
        function silme(name){
            console.log($('li[name='+name+']').find('span').text());
            $('li[name='+name+']').remove();

            if($('#search').val() !== null){
                $("#radioDiv3 input[type='radio']").each(function(){
                    $(this).prop('checked', false);
                });
                $('#search').val(null);
            }

            if(name.substring(0,1) === "s"){
                var id = name.substring(1,name.length);

                $('#sektorler option:selected').each(function() {
                    if($(this).val()=== id){
                        console.log($('input:checkbox[data-name="selectItemsektorler[]"][value="' + id + '"]'));
                        $('input:checkbox[data-name="selectItemsektorler[]"][value="' + id + '"]').trigger("click");

                    }
                });
            }else{
                $('.mutliSelect input[type="checkbox"]').each(function(){
                    var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').attr('name'),
                        title = $(this).attr('name');
                    if(name == title){
                        $(this).prop('checked', false);
                    }
                });
                getFirmalar(1);
            }
        }
        function doldurma(name,code){
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
            var html = '<li class="li" name="' + birlesmisName + '"><span class="btn-sm btn btn-circle purple" title="' + name + '" style="cursor:auto;">' + name + ' <a class="silmeButton btn" onclick=silme("'+birlesmisName+'") style="padding: 1px;margin: 2px; color:white"><i class="icon-close"></i></a> </span></li>';
            $("#multiSel"+key).append(html);
        }
        $('#button').click(function(){
            doldurma("Anahtar kelime:"+$('#search').val(),$('#search').val());
            getFirmalar(1);
        });
        $('#il_id').change(function(){
            var il = new Array();
            var n = jQuery('.mutliSelect input[type="checkbox"]').length;
            if (n > 0){
                jQuery('.mutliSelect input[type="checkbox"]:checked').each(function(){
                    il.push($(this).val());
                });
            }
            getFirmalar(1);
            doldurma(il,il);
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
                getFirmalar(1);
                doldurma(title,title);
            } else {
                $('span[title="' + title + '"]').remove();
                var ret = $(".hida");
                $('.dropdown dt a').append(ret);
            }
        });
        function getFirmalar(page) {
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
            var selectedSearch = "";    /////////////////////////// search button /////////////////////
            var inputSearch = "";
            var selected3 = $("#radioDiv3 input[type='radio']:checked");
            if (selected3.length > 0) {
                selectedSearch = selected3.val();
            }
            inputSearch=$('#search').val();
            $.ajax({
                beforeSend: function(){
                    $('.ajax-loader').css("visibility", "visible");
                },
                url : '?page='+page,
                dataType: 'json',
                data:{il:selectedIl,sektor:selectedSektor,radSearch:selectedSearch,input:inputSearch
                },
            }).done(function(data){
                $('.firmalar').html(data);
                location.hash = page;
                window.scrollTo(0, 0);

                $('.ajax-loader').css("visibility", "hidden");
            }).fail(function(){
                alert('Firmalar Yüklenemiyor !!!  ');
                $('.ajax-loader').css("visibility", "hidden");
            });
        }
    </script>
@endsection