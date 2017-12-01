@extends('layouts.appUser')

@section('baslik') Üyelik Bilgileri @endsection

@section('aciklama') @endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption caption-md">
                        <i class="icon-note theme-font"></i>
                        <span class="caption-subject theme-font bold uppercase">Üyelik Bilgilerim</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <ul>
                        <li>Üyelik başlangıç tarihi: {{date("d-m-Y", strtotime($firma->uyelik_baslangic_tarihi))}}</li>
                        <li>Üyelik bitiş tarihi: {{date("d-m-Y", strtotime($firma->uyelik_bitis_tarihi))}}</li>
                        <li>Ödemeler:
                            <ul>
                                @foreach($firma->odemeler as $odeme)
                                    <li>Miktar: {{$odeme->miktar}}</li>
                                    <li>Üyelik süresi: {{$odeme->sure}} ay</li>
                                    <li>Teklif geçerlilik süresi: {{$odeme->gecerlilik_sure}} ay</li>
                                    <li>Ödeme durumu: {{$odeme->odeme_durumu}}</li>

                                    <?php if ($odeme->odeme_tarihi)
                                    {echo "<li>Ödeme tarihi: {{$odeme->odeme_tarihi}}</li>";}
                                    ?>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection