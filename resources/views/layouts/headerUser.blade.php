<!-- BEGIN HEADER -->
<div class="page-header">
    <!-- BEGIN HEADER TOP -->
    <div class="page-header-top">
        <div class="container">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="#">
                    <img src="{{asset('images/fe/logo_big.png')}}" alt="Tamrekabet">
                </a>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler"></a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">

                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <li class="dropdown dropdown-user ">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <?php $firma_logo= session()->get('firma_logo'); ?>
                            @if($firma_logo != "")
                                <img alt="" class="img-circle" src="{{asset('uploads')}}/{{$firma_logo}}">
                            @else
                                <img alt="" class="img-circle" src="{{asset('uploads/logo/defaultFirmaLogo.png')}}">
                            @endif

                            <span class="username username-hide-mobile">{{session()->get('kullanici_adi') }}/ {{session()->get('firma_adi')}}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="javascript:;"><i class="fa fa-tachometer"></i>Firmalarım</a>

                                <?php
                                $kullanici = Auth::user();//onaylanmamış firmaların kullanıcı adı altında görünebilmesi için
                                //$kullaniciF=$kullanici->firmalar()->where('onay',1)->get();
                                $kullaniciF= $kullanici->firmalar()->get();
                                ?>

                                <ul>
                                    @if(count($kullaniciF) != 0)
                                        @foreach($kullaniciF as $kullanicifirma)
                                    <li>
                                        <a class="firmaSec" name="{{$kullanicifirma->id}}">
                                            {{$kullanicifirma->adi}} </a>
                                    </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                            <li>
                                <a href="{{url('yeniFirmaKaydet/')}}">
                                    <i class="icon-plus"></i> Yeni Firma Ekle </a>
                            </li>
                            <li>
                                <a href="{{URL::to('kullaniciBilgileri')}}">
                                    <i class="icon-info"></i> Bilgilerim
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="icon-question"></i> Yardım
                                </a>
                            </li>
                            <li class="divider"> </li>
                            <li>
                                <a href="{{url('/sessionKill')}}">
                                    <i class="icon-key"></i> Çıkış Yap </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->

                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
    </div>
    <!-- END HEADER TOP -->
    <!-- BEGIN HEADER MENU -->
    <div class="page-header-menu">
        <div class="container">

            <!-- BEGIN MEGA MENU -->
            <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
            <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
           <?php $firmaId = session()->get('firma_id'); ?>
            <div class="hor-menu  ">
                <ul class="nav navbar-nav">
                    <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown active">
                        <a href="{{URL::to('firmaIslemleri', array($firmaId))}}"><i class=" icon-home"></i>
                        </a>
                    </li>
                    <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown ">
                        <a href="javascript:;"><i class="icon-globe"></i> Firma İşlemleri
                            <span class="arrow"></span>
                        </a>
                        <ul class="dropdown-menu pull-left">
                            <li aria-haspopup="true" class=" ">
                                <a href="{{URL::to('firmaProfili')}}" class="nav-link ">
                                    <i class="icon-like"></i> Firma Profilim
                                </a>
                            </li>
                            <li aria-haspopup="true" class="nav-link ">
                                <a href="{{URL::to('uyelikBilgileri')}}" class="nav-link ">
                                    <i class="icon-info"></i> Üyelik Bilgileri</a>
                            </li>
                            <li aria-haspopup="true" class="dropdown-submenu ">
                                <a href="javascript:;" class="nav-link nav-toggle ">
                                    <i class="icon-globe"></i> Firma Havuzu
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li aria-haspopup="true" class=" ">
                                        <a href="{{URL::to('onayliTedarikcilerim')}}" class="nav-link ">
                                            <i class="icon-star"></i> Onaylı Tedarikçilerim
                                        </a>
                                    </li>
                                    <li aria-haspopup="true" class="nav-link ">
                                        <a href="{{URL::to('firmaHavuzu')}}" class="nav-link ">
                                            <i class="icon-list"></i> Tüm Firmalar</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown ">
                        <a href="javascript:;"><i class="icon-paper-plane"></i> İlan İşlemleri
                            <span class="arrow"></span>
                        </a>
                        <ul class="dropdown-menu pull-left">

                            <li aria-haspopup="true" class=" ">
                                <a href="{{URL::to('ilanlarim', array($firmaId))}}" class="nav-link ">
                                    <i class="icon-list"></i> İlanlarım
                                </a>
                            </li>
                            <li aria-haspopup="true" class=" ">
                                <a href="{{URL::to('ilanOlustur', array($firmaId))}}" class="nav-link ">
                                    <i class="icon-plus"></i> İlan Oluştur
                                </a>
                            </li>
                            <li aria-haspopup="true" class=" ">
                                <a href="{{URL::to('davetEdildigim')}}" class="nav-link ">
                                    <i class="icon-call-in"></i> Davet Edildiğim İlanlar
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown ">
                        <a href="javascript:;"><i class="icon-size-actual"></i> Başvuru İşlemleri
                            <span class="arrow"></span>
                        </a>
                        <ul class="dropdown-menu pull-left">
                            <li aria-haspopup="true" class=" ">
                                <a href="{{URL::to('basvurularim', array($firmaId))}}" class="nav-link ">
                                    <i class="icon-list"></i> Başvurularım
                                </a>
                            </li>
                            <li aria-haspopup="true" class="nav-link ">
                                <a href="{{url('ilanAra/')}}" class="nav-link ">
                                    <i class="icon-target"></i> Başvur</a>
                            </li>
                        </ul>
                    </li>


                    <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown ">
                        <a href="{{URL::to('kullaniciIslemleri')}}"><i class="icon-users"></i> Kullanıcı İşlemleri
                        </a>
                    </li>

                </ul>
            </div>
            <!-- END MEGA MENU -->

            <div style="float:right" class="hor-menu  ">
                <ul class="nav navbar-nav">
                    <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown active">
                        <a href="#FirmaDavet" data-toggle="modal"><i class="icon-fire"></i> Firma Davet Et!
                        </a>
                    </li>
                </ul>

                <div class="modal fade" id="FirmaDavet" tabindex="-1" role="basic" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div style="" class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <h4 style="font-size:14px;" class="modal-title" id="myModalLabel"><img src="{{asset('images/arrow.png')}}">&nbsp;<strong>Firma Davet Et</strong></h4>
                            </div>
                            {!! Form::open(array('id'=>'davetFirma','url'=>'firmaDavet','method'=>'POST', 'files'=>true)) !!}
                            <div class="modal-body">
                                <div class='row'>
                                    <div class=" form-group">
                                        <label class="col-lg-4 control-label">Davet Edeceğiniz Firmanın İsmi:</label>
                                        <div class='col-lg-8'>
                                            <input type="text" class="form-control" id="isim" name="isim" placeholder="Firma İsmi" value="" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                            <input type="hidden" class="form-control" id="firma_id" name="firma_id" value='{{$firmaId}}'>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class='row'>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Davet Edeceğiniz Firmanın Mail Adresi:</label>
                                        <div class="col-sm-8">
                                            <input type="mail" class="form-control" id="mailAdres" name="mailAdres" placeholder="Mail Adres" value="" data-validation="required"  data-validation-error-msg="Lütfen bu alanı doldurunuz!">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                {!! Form::submit('Davet Et', array('url'=>'firmaProfili/iletisimAdd/'.$firmaId,'style'=>'float:right','class'=>'btn btn-danger')) !!}
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- END HEADER MENU -->
</div>

<script>
    var selected;
    var click=0;

    $( document ).ready(function() {
        @if(!Auth::guest())
            selected='{{$kullanicifirma->id}}';
        funcLocations();
        @endif
    });

    $('.firmaSec').on('click', function() {
        selected = $(this).attr('name');
        click=1;
        funcLocations();
    });

    function funcLocations(){
        if (click === 1) { //// sayfa her yüklendiğinde çalışmasın diye bu kontrol gerekli
            if("{{session()->get('firma_id')}}" != selected) {//zaten seçilmiş firma linkine tıklanırsa boşuna session setlememesi icin
                $.ajax({
                    type: "GET",
                    url: "{{asset('set_session')}}",
                    data: {role: selected},
                }).done(function (data) {
                    click = 0;
                    location.href = "{{asset('firmaIslemleri')}}" + "/" + selected;

                }).fail(function () {
                    alert('Yüklenemiyor !!!  ');
                });
            }
            else{
                location.href = "{{asset('firmaIslemleri')}}" + "/" + selected;
            }
        }
    }

    $("#davetFirma").submit(function(e)
    {
        var postData = $(this).serialize();
        var formURL = $(this).attr('action');
        $.ajax(
            {
                beforeSend: function(){
                    $('.ajax-loader').css("visibility", "visible");
                },
                url : formURL,
                type: "POST",
                data : postData,
                success:function(data, textStatus, jqXHR)
                {
                    alert(data);
                    $('#FirmaDavet').modal('hide');

                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    alert(textStatus + "," + errorThrown);
                }
            });
        e.preventDefault(); //STOP default action
    });




</script>
<!-- END HEADER -->
