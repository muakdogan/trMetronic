@extends('layouts.appUser')
@section('baslik') Kullanıcı İşlemleri @endsection

@section('head')
    <style>
        .short{
            color:#FF0000;
        }
        .weak{
            color:#E66C2C;
        }
        .good{
            color:#2D98F3;
        }
        .strong{
            color:#006400;
        }

         .popup, .popup2, .bMulti {
             background-color: #fff;
             border-radius: 10px 10px 10px 10px;
             box-shadow: 0 0 25px 5px #999;
             color: #111;
             display: none;
             min-width: 450px;
             padding: 25px;
             text-align: center;
         }
        .popup, .bMulti {
            min-height: 150px;
        }
        .button.b-close, .button.bClose {
            border-radius: 7px 7px 7px 7px;
            box-shadow: none;
            font: bold 131% sans-serif;
            padding: 0 6px 2px;
            position: absolute;
            right: -7px;
            top: -7px;
        }
        .button {
            background-color: #2b91af;
            border-radius: 10px;
            box-shadow: 0 2px 3px rgba(0,0,0,0.3);
            color: #fff;
            cursor: pointer;
            display: inline-block;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
        }

    </style>
@endsection

@section('content')
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption caption-md">
                <i class="fa fa-pencil theme-font"></i>
                <span class="caption-subject theme-font bold uppercase">Kullanıcı Bilgilerim</span>
            </div>
        </div>
        <div class="portlet-body">
            <p><strong>Adınız:&nbsp;&nbsp;</strong>{{$kullanici->adi}}</p>
            <p><strong>Soyadınız:&nbsp;&nbsp;</strong>{{$kullanici->soyadi}}</p>
            <p><strong>Email:&nbsp;&nbsp;</strong>{{$kullanici->email}}</p>
            <p><strong>Telefon:&nbsp;&nbsp;</strong>{{$kullanici->telefon}}</p>
            <p>
                <button href="#" id="btn-add-kullanici" name="btn-add-kullanici" class="btn purple btn-xs" >Düzenle</button>
                <button href="#" id="btn-add-sifre" name="btn-add-sifre" class="btn purple btn-xs" >Sifre Düzenle</button>
            </p>
            <div class="modal fade" id="myModal-kullanici" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">Kullanıcı Bilgilerini Düzenle</h4>
                        </div>
                        <div class="modal-body">
                            {!! Form::open(array('url'=>'kullaniciBilgileriUpdate/','class'=>'form-horizontal','method'=>'POST', 'files'=>true)) !!}
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Adı</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="adi" name="adi" placeholder="Adı giriniz" value="{{$kullanici->adi}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Soyadı</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="soyadi" name="soyadi" placeholder="Soyadı giriniz" value="{{$kullanici->soyadi}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email giriniz" disabled value="{{$kullanici->email}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Telefon</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="telefon" name="telefon" placeholder="Telefon giriniz" value="{{$kullanici->telefon}}" required>
                                </div>
                            </div>

                            {!! Form::submit('Kaydet', array('url'=>'kullaniciBilgileriUpdate','class'=>'btn btn-danger')) !!}
                            {!! Form::close() !!}
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="myModal-sifre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">Kullanıcı Şifresini Düzenle</h4>
                        </div>
                        <div class="modal-body">
                            {!! Form::open(array('url'=>'kullaniciSifreDegisikligi','class'=>'form-horizontal','method'=>'POST', 'files'=>true)) !!}
                            {!! csrf_field() !!}

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email giriniz" disabled value="{{Auth::user()->email}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Şifre</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control sifre" id="sifre" name="sifre" placeholder="Sifre giriniz" value="" required>
                                    <span id="result"></span>
                                </div>
                            </div>
                            <div class="form-group">

                                <label for="inputEmail3" class="col-sm-3 control-label">Şifre Tekrar</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control  " id="sifre_tekrar" name="sifre_tekrar" placeholder="Sifreyi Tekrar giriniz" onfocusout="Validate()" value="" required>
                                </div>
                            </div>
                            {!! Form::submit('Kaydet', array('url'=>'kullaniciBilgileriSifre/','class'=>'btn btn-danger')) !!}
                            {!! Form::close() !!}
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption caption-md">
                <i class="fa fa-pencil theme-font"></i>
                <span class="caption-subject theme-font bold uppercase">Kullanıcı Listesi</span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table" >
                <thead id="tasks-list" name="tasks-list">
                <tr>
                    <th>Adı:</th>
                    <th>Soyadı:</th>
                    <th>Email:</th>
                    <th>Role:</th>
                    <th>Ünvan</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($firma->kullanicilar as $firmaKullanici)
                    <tr>
                        <td>
                            {{$firmaKullanici->adi}}
                        </td>
                        <td>
                            {{$firmaKullanici->soyadi}}
                        </td>
                        <td>
                            {{$firmaKullanici->email}}
                        </td>
                        <td>
                            {{$firmaKullanici->firma_kullanici->roller->adi}}
                        </td>
                        <td>
                            {{$firmaKullanici->firma_kullanici->unvan}}
                        </td>
                        @if($kullanici->firma_kullanici->roller->adi=='Yönetici' && $kullanici->id != $firmaKullanici->id)
                        <td>
                            <button name="open-modal-kullanici"  value="{{$firmaKullanici->id}}" class="btn purple btn-xs open-modal-kullanici" >Düzenle</button>
                            <div class="modal fade" id="myModal-kullaniciDüzenle-{{$firmaKullanici->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Kullanıcı Düzenle</h4>
                                        </div>
                                        <div class="modal-body">
                                            {!! Form::open(array('url'=>'kullaniciIslemleriGuncelle','class'=>'form-horizontal','method'=>'POST', 'files'=>true)) !!}
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Adı</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="adi" name="adi" placeholder="Adı giriniz" value="{{$firmaKullanici->adi}}" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Soyadı</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="soyadi" name="soyadi" placeholder="Soyadı giriniz" value="{{$firmaKullanici->soyadi}}" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control " id="email" name="email" placeholder="Email giriniz" value="{{$firmaKullanici->email}}" required disabled>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Rol</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="rol" id="rol" required>
                                                        @foreach($roller as $rol)
                                                            @if($firmaKullanici->firma_kullanici->roller->adi == $rol->adi)
                                                                <option selected value="{{$rol->id}}" >{{$rol->adi}}</option>
                                                            @else
                                                                <option value="{{$rol->id}}" >{{$rol->adi}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Ünvan</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="unvan" name="unvan" placeholder="Ünvan giriniz" value="{{$firmaKullanici->firma_kullanici->unvan}}" required>
                                                </div>
                                            </div>
                                            <input type="hidden" name="firma_id"  id="firma_id" value="{{$firma->id}}">
                                            <input type="hidden" name="kullanici_id" value="{{$firmaKullanici->id}}">
                                            {!! Form::submit('Kaydet', array('class'=>'btn btn-danger')) !!}
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                        <td>
                            {{ Form::open(array('url'=>'kullaniciDelete','method' => 'DELETE', 'files'=>true)) }}
                            <input type="hidden" name="kullanici_id"  id="kullanici_id" value="{{$firmaKullanici->id}}">
                            {{ Form::submit('Sil', ['class' => 'btn purple btn-xs']) }}
                            {{ Form::close() }}
                            </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($kullanici->firma_kullanici->roller->adi=='Yönetici')
            <div class="modal fade" id="myModal-kullanici-ekle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">Kullanıcı Ekle</h4>
                        </div>
                        <div class="modal-body">
                            {!! Form::open(array('id'=>'kullanici_add_kayit','url'=>'kullaniciIslemleriEkle/'.$firma->id,'class'=>'form-horizontal','method'=>'POST', 'files'=>true)) !!}
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Adı</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="adi" name="adi" placeholder="Adı giriniz" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Soyadı</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="soyadi" name="soyadi" placeholder="Soyadı giriniz" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control email_control" onfocusout="email_control();" id="email" name="email" placeholder="Email giriniz" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Rol</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="rol" id="rol" required>
                                        <option selected disabled>Seçiniz</option>
                                        @foreach($roller as $rol)
                                            <option  value="{{$rol->id}}" >{{$rol->adi}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Ünvan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="unvan" name="unvan" placeholder="Ünvan giriniz" value="" required>
                                </div>
                            </div>
                            {!! Form::submit('Kaydet', array('url'=>'kullaniciIslemleriEkle/'.$firma->id,'style'=>'float:right','class'=>'btn btn-danger')) !!}
                            {!! Form::close() !!}
                        </div>
                        <br>
                        <br>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
            <button href="{{ url('/password/reset') }}" id="btn-add-kullanici-ekle" name="btn-add-kullanici" class="btn purple btn-xs" >Ekle</button>
            @endif
        </div>
    </div>

    <div id="mesaj" class="popup">
        <span class="button b-close"><span>X</span></span>
        <h2 style="color:red"> Üzgünüz.. !!!</h2>
        <h3>Sistemsel bir hata oluştu.Lütfen daha sonra tekrar deneyin</h3>
    </div>
    <div  id="kayit_msg"  class='popup'>
        <span class="button b-close"><span>X</span></span>
        <p style="color:green;font-size:18px">Bilgilendirme</p>
        <p style="font-size:12px">Kayıdınız Alınmıştır Lütfen E-mailinizi Kontrol ediniz. </p>
    </div>
    <div id="email2"  class='popup'>
        <span class="button b-close"><span>X</span></span>
        <p style="color:red;font-size:18px"> Üzgünüz..!!!</p>
        <p style="font-size:12px">Bu email sistemimize kayıtlıdır.Lütfen başka email ile tekrar deneyiniz.</p>
    </div>
@endsection

@section('sayfaSonu')
    <script src="{{asset('js/jquery.bpopup-0.11.0.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#btn-add-kullanici').click(function () {
                $('#btn-save-kullanici').val("add");
                $('#myModal-kullanici').modal('show');
            });
            $('#btn-add-sifre').click(function () {
                $('#btn-save-sifre').val("add");
                $('#myModal-sifre').modal('show');
            });
        });

        var url = "kullanici";
        $('.open-modal-kullanici').click(function(){
            var kullanici_id = $(this).val();

            $('#myModal-kullaniciDüzenle-'+$(this).val()).modal('show');
/*
            $.ajax({
                type:"GET",
                url:"{{asset('kullanici')}}/"+kullanici_id,
                cache: false,
                success: function(data){
                    $('#kullanici_id').val(data.id);
                    $('#adi').val(data.adi);
                    $('#soyadi').val(data.soyadi);
                    $('#email').val(data.email);
                    $('#rol').val(data.rol_id);
                    $('#unvan').val(data.unvan);
                }
            });*/
        });

        var email;
        function email_control(){
            email= $('.email_control').val();
            email_Get();
        }
        function email_Get(){
            $.ajax({
                type:"GET",
                url:"{{asset('email_girisControl')}}",
                data:{email_giris:email},

                cache: false,
                success: function(data){
                    console.log(data);
                    if(data==1){
                        $('#email2').bPopup({
                            speed: 650,
                            transition: 'slideIn',
                            transitionClose: 'slideBack',
                            autoClose: 5000
                        });

                        $('.email_control').val("");
                    }
                }
            });
        }

        var firmaId='{{$firma->id}}';
        $("#kullanici_up_kayit").submit(function(e)
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
                        console.log(data);
                        $('.ajax-loader').css("visibility", "hidden");
                        if(data=="error"){
                            $('#mesaj').bPopup({
                                speed: 650,
                                transition: 'slideIn',
                                transitionClose: 'slideBack',
                                autoClose: 5000
                            });
                            setTimeout(function(){ location.href="{{asset('kullaniciIslemleri')}}"}, 5000);
                        }
                        else{
                            $('#kayit_msg').bPopup({
                                speed: 650,
                                transition: 'slideIn',
                                transitionClose: 'slideBack',
                                autoClose: 5000
                            });

                            setTimeout(function(){ location.href="{{asset('kullaniciIslemleri')}}"}, 5000);
                        }
                        e.preventDefault();
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        alert(textStatus + "," + errorThrown);
                    }
                });
            e.preventDefault(); //STOP default action
        });

        $("#kullanici_add_kayit").submit(function(e)
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
                        console.log(data);
                        $('.ajax-loader').css("visibility", "hidden");
                        if(data=="error"){
                            $('#mesaj').bPopup({
                                speed: 650,
                                transition: 'slideIn',
                                transitionClose: 'slideBack',
                                autoClose: 5000
                            });
                            setTimeout(function(){ location.href="{{asset('kullaniciIslemleri')}}"}, 5000);
                        }
                        else{
                            $('#kayit_msg').bPopup({
                                speed: 650,
                                transition: 'slideIn',
                                transitionClose: 'slideBack',
                                autoClose: 5000
                            });

                            setTimeout(function(){ location.href="{{asset('kullaniciIslemleri')}}"}, 5000);
                        }
                        e.preventDefault();
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        alert(textStatus + "," + errorThrown);
                    }
                });
            e.preventDefault(); //STOP default action
        });


        $('#btn-add-kullanici-ekle').click(function () {
            $('#myModal-kullanici-ekle').modal('show');
        });
        $('#btn-add-sifre').click(function () {
            $('#myModal-sifre').modal('show');
        });

        function Validate() {
            var password = document.getElementById("sifre").value;
            var confirmPassword = document.getElementById("sifre_tekrar").value;
            if (password != confirmPassword) {

                alert("Şifreler uyuşmuyor.Lütfen Tekrar Kontrol Ediniz");
                return false;
            }
            return true;
        }
        $(document).ready(function()
        {
            $('#sifre').keyup(function()
            {
                $('#result').html(checkStrength($('#sifre').val()))
            })

            function checkStrength(password)
            {
                var strength = 0
                if (password.length < 6) {
                    $('#result').removeClass()
                    $('#result').addClass('short')
                    return 'Şifreniz Kısa Kabul Edilemez!'
                }

                if (password.length > 8) {strength += 1;}

                if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)){  strength += 1;}

                if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) { strength += 1 ;}

                if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)){  strength += 1;}

                if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)){ strength += 1;}

                if (strength < 2 ) {
                    $('#result').removeClass()
                    $('#result').addClass('weak')
                    return 'Zayıf'
                }
                else if (strength == 2 ) {
                    $('#result').removeClass()
                    $('#result').addClass('good')
                    return 'İyi'
                }
                else {
                    $('#result').removeClass()
                    $('#result').addClass('strong')
                    return 'Güçlü'
                }
            }
        });
    </script>
@endsection