@extends('layouts.appUser')

@section('baslik') Üyelik Bilgileri @endsection

@section('aciklama') @endsection

@section('content')
<div class="container">
    <div>
        <ul>
            <li>Üyelik başlangıç tarihi: {{$firma->uyelik_baslangic_tarihi}}</li>
            <li>Üyelik bitiş tarihi: {{$firma->uyelik_bitis_tarihi}}</li>
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
@endsection