@extends('layouts.fe.feMaster')
<!-- navbar-->
@include('FrontEnd.ustMenu')

@section('content')

<section id="intro" class="text-intro no-padding-bottom">
  <div class="container banne-con">
    <div class="row">
      <div class="col-md-12">
        <h1 class="banner-h1">Al Kazan Sat Kazan <!--span class="rotate">startup intro site, landing page, bootstrap template</span--> </h1>
        <h3 class="weight-300 banner-h3"><b>tamrekabet.com</b> Nedir?</h3>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <p class="banner-p"><b>tamrekabet.com</b> mal, hizmet veya yapım işi ihtiyacı olan firmaların teklif toplama süreçlerinde destek vererek <br/> bu ihtiyaçları karşılayabilecek satıcı firmalar ile buluşturur.</p>
        <a href="{{url('/firmaKayit')}}" class="btn navbar-btn btn-white banner-btn"><b>HEMEN ÜYE OLUN</b></a>
        <!--form class="form-inline margin-top sign-up-form">
          <input id="email_intro" type="email" placeholder="name@company.com" class="form-control">
          <input id="submit_intro" type="submit" value="Get started for FREE" class="btn btn-primary">
        </form-->
      </div>

    </div>
  </div>
</section>
<!--   *** CUSTOMERS ***-->
<!--section id="customers" class="section background-gray-lightest padding--small">
  <div class="container">
    <div class="row">
      <div class="col-sm-4 col-md-2 col-xs-6">
        <div class="customer"><img src="{{asset('images_fe/customers/kofola.png')}}" title="Kofola" data-placement="bottom" data-toggle="tooltip" alt="" class="img-responsive"></div>
      </div>
      <div class="col-sm-4 col-md-2 col-xs-6">
        <div class="customer"><img src="{{asset('images_fe/customers/evian.png')}}" title="Evian" data-placement="bottom" data-toggle="tooltip" alt="" class="img-responsive"></div>
      </div>
      <div class="col-sm-4 col-md-2 col-xs-6">
        <div class="customer"><img src="{{asset('images_fe/customers/cslink.png')}}" title="CS Link" data-placement="bottom" data-toggle="tooltip" alt="" class="img-responsive"></div>
      </div>
      <div class="col-sm-4 col-md-2 col-xs-6">
        <div class="customer"><img src="{{asset('images_fe/customers/botas66.png')}}" title="Botas 66 Concept store" data-placement="bottom" data-toggle="tooltip" alt="" class="img-responsive"></div>
      </div>
      <div class="col-sm-4 col-md-2 col-xs-6">
        <div class="customer"><img src="{{asset('images_fe/customers/mdfc.png')}}" title="MediaFabríca" data-placement="bottom" data-toggle="tooltip" alt="" class="img-responsive"></div>
      </div>
      <div class="col-sm-4 col-md-2 col-xs-6">
        <div class="customer"><img src="{{asset('images_fe/customers/vanek.png')}}" title="VANĚK Strojírenská výroba" data-placement="bottom" data-toggle="tooltip" alt="" class="img-responsive"></div>
      </div>
    </div>
  </div>
</section--!>
<!--   *** CUSTOMERS END ***-->
<!--   *** FEATURES ***-->

<!-- ***NASIL ÇALIŞIR ***-->
<section id="nasil" class="section testimonails background-gray-lighter">
  <div class="container">
    <h2 class="text-center">Nasıl Çalışır?</h2>
    <div class="row">
      <div class="col-md-12">
        <ul class="owl-carousel testimonials same-height-row">
          <li class="item">
            <div class="testimonial same-height-always">
              <div class="text" style="text-align:center">
                <span class="numbers">1</span>
                <div class="circle-avatar" style="background-image:url(images/fe/nasilCalisir1.png)"></div>
                <h5>İHTİYACINIZI OLUŞTURUN</h5>
                <p>Alıcı firma mal, hizmet veya yapım işi ihtiyacı için ilan oluşturur.</p>
              </div>
            </div>
          </li>
          <li class="item">
            <div class="testimonial same-height-always">
              <div class="text" style="text-align:center">
                <span class="numbers">2</span>
                <div class="circle-avatar" style="background-image:url(images/fe/nasilCalisir2.png)"></div>
                <h5>İHTİYACINIZI DUYURUN</h5>
                <p>İhtiyacınızı sadece onaylı tedarikçilerinizle ya da seçeceğiniz firmalar ile paylaşabileceğiniz gibi sektördeki kayıtlı tüm firmalarla da paylaşabilirsiniz. Seçiminize göre sistem firmalara bildirim gönderecektir.</p>
              </div>
            </div>
          </li>
          <li class="item">
            <div class="testimonial same-height-always">
              <div class="text" style="text-align:center">
                <span class="numbers">3</span>
                <div class="circle-avatar" style="background-image:url(images/fe/nasilCalisir3.png)"></div>
                <h5>TEKLİFLERİ TOPLAYIN</h5>
                <p>Belirlediğiniz satıcı firmalar teklif vererek rekabet ederler.</p>
              </div>
            </div>
          </li>
          <li class="item">
            <div class="testimonial same-height-always">
              <div class="text" style="text-align:center">
                <span class="numbers">4</span>
                <div class="circle-avatar" style="background-image:url(images/fe/nasilCalisir4.png)"></div>
                <h5>KAZANANI BELİRLEYİN</h5>
                <p>Alıcı firma teklifleri ve firma profillerini karşılaştırır ve kazananı belirler.</p>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>
<style>
div.circle-avatar{
  /* make it responsive */
  max-width: 100%;
  width:100%;
  height:auto;
  display:block;
  /* div height to be the same as width*/
  padding-top:100%;

  /* make it a cirkle */
  border-radius:50%;

  /* Centering on image`s center*/
  background-position-y: center;
  background-position-x: center;
  background-repeat: no-repeat;

  /* it makes the clue thing, takes smaller dimention to fill div */
  background-size: cover;

  /* it is optional, for making this div centered in parent*/
  margin: 0 auto;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  }
</style>
<!-- ***AVANTAJLARIMIZ ***-->
<section id="avantaj" class="section-gray">
  <div class="container clearfix">
    <h2 class="text-center">Avantajlarımız</h2>
    <div class="row services">
      <div class="row">
        <div class="col-md-6">
          <div class="flex-row">
            <div class="flex-80-col">
              <h4 style="text-align:right">Maliyet</h4>
              <p style="text-align:right">Etkin rekabet ortamı yaratarak satın alma maliyetlerinizi düşürebilir, Satışını yaptığınız ürün veya hizmet taleplerine kolayca ulaşarak satış ve tanıtım harcamalarınızı azaltabilirsiniz.</p>
            </div>
            <div class="flex-20-col">
              <div class="icon"><i class="pe-7s-cash"></i></div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="flex-row">
            <div class="flex-20-col">
              <div class="icon"><i class="pe-7s-diamond"></i></div>
            </div>
            <div class="flex-80-col">
              <h4 style="text-align:left">Kalite</h4>
              <p style="text-align:left">Piyasadaki birçok firmaya daha hızlı ulaşabilir, ihtiyacınıza en uygun ürüne, hizmete veya yapım işine karar vererek toplam kalitenizi arttırırsınız.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="flex-row">
            <div class="flex-80-col">
              <h4 style="text-align:right">Şeffaflık</h4>
              <p style="text-align:right">Birçok kullanıcı tanımlayarak satın alma ve satış süreçlerinizi şeffaflaştırabilir ve standartlara uygun hale getirebilirsiniz.</p>
            </div>
            <div class="flex-20-col">
              <div class="icon"><i class="pe-7s-users"></i></div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="flex-row">
            <div class="flex-20-col">
              <div class="icon"><i class="pe-7s-alarm"></i></div>
            </div>
            <div class="flex-80-col">
              <h4 style="text-align:left">Zaman</h4>
              <p style="text-align:left">Teklif toplama ve rekabet süreçlerinizi dijital ortama taşıyarak zaman tasarrufu sağlayabilirsiniz.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="flex-row">
            <div class="flex-80-col">
              <h4 style="text-align:right">Firma ve Piyasa Bilgisi</h4>
              <p style="text-align:right">Piyasa bilgisi ve geri bildirim sayesinde satıcı firmalar hakkında doğru bilgiye ulaşabilir ve firmanızın bulunduğu sektöre dair bilgi edinebilirsiniz.</p>
            </div>
            <div class="flex-20-col">
              <div class="icon"><i class="pe-7s-graph2"></i></div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="flex-row">
            <div class="flex-20-col">
              <div class="icon"><i class="pe-7s-display1"></i></div>
            </div>
            <div class="flex-80-col">
              <h4 style="text-align:left">Talep Bilgisi ve Yenilikçi Satış Kanalı</h4>
              <p style="text-align:left">Alıcı firmaların taleplerinden haberdar olarak yeni ve kolay bir satış kanalı oluşturabilirsiniz.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ***NEDEN TAM REKABET ***-->
<section class="section background-gray-lightest">
  <div class="container">
    <h2 class="text-center">Neden tamrekabet.com?</h2>
    <div class="row text-center-mobile">
      <div class="col-md-6">
        <p><img alt="" src="{{asset('images/fe/nedenTR.jpg')}}" class="img-responsive"></p>
      </div>
      <div class="col-md-6">
        <div class="col-md-4">
        </div>
        <div class="flex-row" style="align-self:center">
            <ul>
              <br><br><br>
              <li><h5 style="text-align:left">Kolay kullanım</h4></li>
              <li><h5 style="text-align:left">Her yerden erişim</h4></li>
              <li><h5 style="text-align:left">Uygun fiyat</h4></li>
              <li><h5 style="text-align:left">Güvenli Sistem</h4></li>
              <li><h5 style="text-align:left">Kurulum yok</h4></li>
              <li><h5 style="text-align:left">7/24 Destek</h4></li>
            </ul>

        </div>
      </div>
    </div>
  </div>
</section>
<!-- *** NELER VAR ***-->
<section id="neler" class="section">
  <div class="container clearfix">
    <h2 class="text-center">tamrekabet.com'da Neler Var?</h2>
    <div class="row services">
      <div class="col-md-12">
        <div class="row">
          <div class="col-sm-4">
            <div class="box box-services">
              <div class="icon"><i class="pe-7s-cash"></i></div>
              <h4 class="heading">İlan Yayınlama</h4>
              <p>Etkin rekabet ortamı yaratarak satın alma maliyetlerinizi düşürebilir, Satışını yaptığınız ürün veya hizmet taleplerine kolayca ulaşarak satış ve tanıtım harcamalarınızı azaltabilirsiniz.</p>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="box box-services">
              <div class="icon"><i class="pe-7s-diamond"></i></div>
              <h4 class="heading">Detaylı Firma Tanıtım Profili</h4>
              <p>Piyasadaki birçok firmaya ulaşabilir, ihtiyacınıza en uygun ürüne veya hizmete karar vererek toplam kalitenizi arttırırsınız.</p>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="box box-services">
              <div class="icon"><i class="pe-7s-users"></i></div>
              <h4 class="heading">Teklif Verme</h4>
              <p>Birçok kullanıcı tanımlayarak satın alma ve satış süreçlerinizi şeffaflaştırabilir ve standartlara uygun hale getirebilirsiniz.</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">
          </div>
          <div class="col-sm-4">
            <div class="box box-services">
              <div class="icon"><i class="pe-7s-alarm"></i></div>
              <h4 class="heading">Firma Havuzu</h4>
              <p>Teklif toplama ve rekabet süreçlerinizi dijital ortama taşıyarak zaman tasarrufu sağlayabilirsiniz.</p>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="box box-services">
              <div class="icon"><i class="pe-7s-graph2"></i></div>
              <h4 class="heading">Tedarikçi Havuzu</h4>
              <p>Piyasa bilgisi ve geri bildirim sayesinde satıcı firmalar hakkında doğru bilgiye ulaşabilir ve firmanızın bulunduğu sektöre dair bilgi edinebilirsiniz.</p>
            </div>
          </div>
          <div class="col-sm-2">
          </div>
      </div>
    </div>
  </div>
</section>
<!-- ***BİZ KİMİZ ***-->
<section id="biz" class="section background-gray-lighter">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-8 col-lg-offset-2 text-center">
        <h2>Biz Kimiz?</h2>
        <p>Kurucularının Ocak 2016'da çalışmalarına başladığı tamrekabet.com ‘’Bilgi ve İletişim Teknolojilerinin Rekabet Üzerindeki Etkileri’’ konulu akademik bir çalışmanın uygulaması olarak doğmuştur. tamrekabet.com bünyesindeki firmalara, bir yandan satın alma süreçlerinde maliyetlerini düşürmek, diğer yandan da yeni pazarlara ve firmalara kolayca ulaşıp satışlarını arttırmak gibi önemli avantajlar sunmaktadır. Merkezi Dokuz Eylül Üniversitesi Teknoloji Geliştirme Bölgesi - İzmir’de bulunan ve 59 sektörde binlerce kalem mal, hizmet ve yapım işi içeren tamrekabet.com günden güne büyüyen firma havuzu, yenilikçi ürün ve hizmetleri ile en kaliteli işletmeler arası ticaret platformunu sunmak için sürekli olarak kendisini yenilemektedir.</p>
        <!--p>Kurucularının Dokuz Eylül Üniversitesi Bilgisayar Mühendisliği Bölümü Akademisyeni ve İktisat Bölümü Yüksek Linsans Öğrencisi olduğu tamrekabet.com Ocak 2016’da çalışmalarına başlamıştır. İlk aşamada ‘’Bilgi ve İletişim Teknolojilerinin Rekabet Üzerindeki Etkileri’’ konulu yüksek lisans tezinin uygulaması olan tamrekabet.com firmalar ile yapılan görüşmeler ve gelen talepler sonucunda aslında firmaların önemli bir ihtiyacına çözüm olduğu anlaşıldı.</p>
        <p>Günümüzde gelişen rekabet koşulları, maliyetlerin sürekli düşürülmesini ve yeni müşterilere ulaşarak satış hacimlerinin sürekli arttırılmasını firmalar için vazgeçilmez çabalar haline getirmiştir. Tamrekabet.com bünyesindeki firmalara bir yandan satın alma süreçlerinde maliyetlerini düşürerek diğer yandan da yeni pazarlara ve firmalara kolayca ulaşıp satışlarını arttırarak önamli avantajlar sunuyor/ önemli bir değer yaratıyor.</p>
        <p>59 sektörde binlerce kalem mal, hizmet ve yapım işi içeren tamrekabet.com günden güne büyüyen firma havuzu, yenilikçi ürün ve hizmetleri ile en kaliteli işletmeler arası ticaret platformunu sunmak için sürekli kendisini yenilemektedir.</p>
        <p>Merkezi Dokuz Eylül Teknoloji Geliştirme Bölgesi İzmir’de bulunan tamrekabet.com genç ekibiyle, yeni teknolojileri sürekli takip ederek müşterilerine en iyi deneyimi sunmak için tüm gücüyle çalışmaya devam ediyor.</p-->
      </div>
    </div>
  </div>
</section>
<!-- *** SSS ***-->
<section class="section">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-8 col-lg-offset-2 text-center">
        <h2>Sıkça Sorulan Sorular</h2>
        <button class="accordion">Tamrekabet.com’a kimler üye olabilir?</button>
        <div class="panel">
          <p>Tamrekabet.com işletmelere hizmet veren bir platformdur. Bu yüzden tüzel kişiliği bulunan firmalar tamrekabet.com’a üye olabilir. Tüketiciler yani gerçek kişiler tamrekabet.com’a üye olamazlar.</p>
        </div>
        <button class="accordion">Tamrekabet.com’da üyeliğim neden hemen aktive olmuyor?</button>
        <div class="panel">
          <p>Tamrekabet.com üyelik aşamalarında girilen firma bilgilerinin doğruluğu adminlerimiz tarafından kontrol  edilir. Bu sebeple üyelik talebi alındıktan sonra belirli bir zamana ihtiyaç duyulmaktadır.</p>
        </div>
        <button class="accordion">Tamrekabet.com ne kadar güvenli?</button>
        <div class="panel">
          <p>Tamrekabet.com'da verileriniz 128 bit şifreleme ile güvenlik altına alındıktan sonra transfer edilmektedir.</p>
        </div>
        <button class="accordion">Tamrekabet.com bilgilerimi paylaşır mı?</button>
        <div class="panel">
          <p>Tamrekabet.com firmanıza dair gizli kalması gereken hiçbir bilgiyi üçüncü şahıslarla paylaşmaz. Ayrıca firmanıza ait stratejik öneme sahip teklif fiyatları ve toplam maliyet bilgileri tamrekabet.com çalışanları ile dahi paylaşılmamaktadır.</p>
        </div>
        <button class="accordion">Tamrekabet.com tam olarak nedir?</button>
        <div class="panel">
          <p>tamrekabet.com satınalma ve satış süreçlerinde yenilikçi bir anlayışla/teknolojilerle alıcı ve satıcı firmaları internet ortamında bir araya getiren çevrimiçi bir yazılımdır. Tamrekabet.com’da ihtiyacınız olan ürün ve hizmetler için alım ilanı oluşturarak satıcı firmalardan kolayca teklif toplayabilir, faaliyet gösterdiğiniz sektörde alım ilanlarına teklif verebilir, detaylı bir firma profili hazırlayarak diğer firmaların firmanıza ürün ve hizmetlerinize ulaşmasını sağlayabilir aynı zamanda firma havuzu modülü ile birçok firmya ulaşabilir inceleyebilir ve tedarikçilerinizi yönetebilirsiniz. </p>
        </div>
        <button class="accordion">Bilgisayarıma program veya yazılım kurmam gerekiyor mu?</button>
        <div class="panel">
          <p>Tamrekabet.com bulut tabanlı bir sistemdir. Bilgisayarınıza bir program veya ayzılım yükelemeniz gerekmez. Tamrekbet.com’a ulaşmanız için gerekli olan bir internet bağlantısı ve bir internet tarayıcısıdır. Kurulum yapılan yazılımlar gibi işletim sistemine, sürümüne veya donanımına ihtiyacınız yoktur.</p>
        </div>
        <button class="accordion">Tamrekabet.com işletmeler arası anlaşmada çıkabilecek sorunlarda taraf olur mu?</button>
        <div class="panel">
          <p>Tamrekabet.com alıcı ve satıcıyı buluşturan teklif alma ve teklif verme süreçlerinin yönetildiği bir platformdur. Alıcı ve satıcının yapacağı sözlü ve/veya yazılı anlaşma bu platformun dışında gerçekleşir. Bu sebeple tamrekabet.com’un firmaların yapacağı anlaşmalardan doğan uyuşmazlıkta bir sorumluluğu yoktur.</p>
        </div>
        <button class="accordion">Tamrekabet.com hizmetlerini nasıl satın alabilirim?</button>
        <div class="panel">
          <p>Tamrekabet.com hizmetlerini internet sitemiz üzerinden ’’üye ol’’ butonuna tıklayarak ve üyelik aşamaları için gerekli birlgileri doldurarak hizmetlerimizi satın alabilir ve hizmetlerimizden faydalanabilirsiniz.</p>
        </div>
        <button class="accordion">Bazı ilanlara teklif veremiyorum neden?</button>
        <div class="panel">
          <p>Tamrekabet.com’da sadece faaliyet gösterdiğiniz sektörlerdeki yayınlanan alım ilanlarına başvurabilirsiniz. Ayrıca faaliyet gösterdiğinniz sektöre dair bir ilan için de alıcı firma ilanı oluştutrurken katılımcıları belirleme alanında ilana başvurmasını istediği firmalar arasında firmanız bulunmuyor ise o ilana başvuramazsınız.</p>
        </div>
        <button class="accordion">Tamrekabet.com’da neler yapabilirim?</button>
        <div class="panel">
          <p>tamrekabet.com’a sürekli yeni özellikler eklemekle birlikte şu anda faydalanabileceğiniz özellikler şu şekildedir:
          <ul style="text-align:left">
            <li>Alım ilanı yayınlama</li>
            <li>Detaylı firma tanıtım profili</li>
            <li>Teklif verme</li>
            <li>Firma havuzu</li>
            <li>Tedarikçi firma yönetimi</li>
          </ul>
          </p>
        </div>

      </div>
    </div>
  </div>
</section>

<!--  ***İLETİŞİM ***-->
<section id="iletisim" class="section background-gray-lightest">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="box-simple">
          <div class="icon"><i class="pe-7s-map-2"></i></div>
          <h3>Adresimiz</h3>
          <p>Depark Beta Binası<br>No:B111<br>Dokuz Eylül Üni. Tınaztepe Kampüsü <br><strong>Buca / İzmir</strong></p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="box-simple">
          <div class="icon"><i class="pe-7s-phone"></i></div>
          <h3>Telefonlarımız</h3>
          <p class="text-muted">Soru veya sorunlarınız için destek hattımızdan bize 7/24 ulaşabilirsiniz.</p>
          <p><strong>+33 555 444 333</strong></p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="box-simple">
          <div class="icon"><i class="pe-7s-mail-open-file"></i></div>
          <h3>Elektronik destek</h3>
          <p class="text-muted">Bize dilediğiniz zaman E-posta yoluyla ulaşarak destek alabilirsiniz.</p>
          <p><strong><a href="mailto:">info@tamrekabet.com</a></strong></p>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  var acc = document.getElementsByClassName("accordion");
  var i;

  for (i = 0; i < acc.length; i++) {
    acc[i].onclick = function() {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight){
        panel.style.maxHeight = null;
      }else{
        panel.style.maxHeight = panel.scrollHeight + "px";
      }
    }
  }
</script>
<footer class="footer">
  <div class="footer__copyright">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <p>&copy;2018 tamrekabet</p>
        </div>
        <div class="col-md-6">
        </div>
      </div>
    </div>
  </div>
</footer>
@endsection
@section('javaScripts')
  @if(session('modal_message_info'))
    <script type="text/javascript">
      $(document).ready(function () {
      $('#popupmodal').modal({show:true});
    });
    </script>
    <div id="popupmodal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4>Kaydınız alınmıştır</h4>
          </div>
          <div class="modal-body">
              <p> Teşekkürler <b>{{Session::get('modal_message_info')}}</b>,</p>
              <p>
                Girdiğin e-posta hesabına bir doğrulama e-postası gönderdik. E-posta'daki
                butona tıklayarak bu işlemi gerçekleştirebilir ve firma profilindeki bilgileri doldurmaya başlayabilirsin.
              </p>
          </div>
          <div class="modal-footer">
              <button class="btn navbar-btn btn-ghost" data-dismiss="modal" aria-hidden="true">Kapat</button>
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection
