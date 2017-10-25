@extends('layouts.fe.feMaster')
<!-- navbar-->
@include('FrontEnd.ustMenu')
<!-- *** SIGNUP MODAL ***_________________________________________________________
-->
<div id="get-started" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true" class="modal fade">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">×</button>
        <h4 class="modal-title text-center">Get started</h4>
      </div>
      <div class="modal-body">
        <form action="#" method="post">
          <div class="form-group">
            <input id="email_modal" type="text" placeholder="name@company.com" class="form-control">
          </div>
          <p class="text-center">
            <button class="btn btn-primary"><i class="pe-7s-magic-wand"></i> Sign up</button>
          </p>
        </form>
        <p class="text-center text-muted">Effects present letters inquiry no an removed or friends. Desire behind latter me though in.</p>
      </div>
    </div>
  </div>
</div>
<!-- *** SIGNUP MODAL END ***-->
@section('content')
<section id="intro" class="text-intro no-padding-bottom">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>Al Kazan Sat Kazan <!--span class="rotate">startup intro site, landing page, bootstrap template</span--> </h1>
        <h3 class="weight-300">Tekliflerinizi hala emailla mı topluyorsunuz?</h3>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <p>Onlarca firma TamRekabet ile maliyetlerini azaltıp, yeni pazarlara ulaşıyor...<br />Siz de TamRekabet'in avantajlarına hemen katılın!</p>
        <a href="{{url('/firmaKayit')}}" class="btn navbar-btn btn-white">HEMEN ÜYE OLUN</a>
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

<!-- ***BİZ KİMİZ ***-->
<section id="biz" class="section no-padding-bottom">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-8 col-lg-offset-2 text-center">
        <h2>Biz Kimiz?</h2>
        <p>Kurucularının Dokuz Eylül Üniversitesi Bilgisayar Mühendisliği Bölümü Akademisyeni ve İktisat Bölümü Yüksek Linsans Öğrencisi olduğu tamrekabet.com Ocak 2016’da çalışmalarına başlamıştır. İlk aşamada ‘’Bilgi ve İletişim Teknolojilerinin Rekabet Üzerindeki Etkileri’’ konulu yüksek lisans tezinin uygulaması olan tamrekabet.com firmalar ile yapılan görüşmeler ve gelen talepler sonucunda aslında firmaların önemli bir ihtiyacına çözüm olduğu anlaşıldı.</p>
        <p>Günümüzde gelişen rekabet koşulları, maliyetlerin sürekli düşürülmesini ve yeni müşterilere ulaşarak satış hacimlerinin sürekli arttırılmasını firmalar için vazgeçilmez çabalar haline getirmiştir. Tamrekabet.com bünyesindeki firmalara bir yandan satın alma süreçlerinde maliyetlerini düşürerek diğer yandan da yeni pazarlara ve firmalara kolayca ulaşıp satışlarını arttırarak önamli avantajlar sunuyor/ önemli bir değer yaratıyor.</p>
        <p>59 sektörde binlerce kalem mal, hizmet ve yapım işi içeren tamrekabet.com günden güne büyüyen firma havuzu, yenilikçi ürün ve hizmetleri ile en kaliteli işletmeler arası ticaret platformunu sunmak için sürekli kendisini yenilemektedir.</p>
        <p>Merkezi Dokuz Eylül Teknoloji Geliştirme Bölgesi İzmir’de bulunan tamrekabet.com genç ekibiyle, yeni teknolojileri sürekli takip ederek müşterilerine en iyi deneyimi sunmak için tüm gücüyle çalışmaya devam ediyor.</p>
      </div>
    </div>
  </div>
</section>
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
                <h5>İHTİYACINIZI OLUŞTURUN</h5>
                <p>Alıcı firma mal, hizmet veya yapım işi ihtiyacı için ilan oluşturur.</p>
              </div>
            </div>
          </li>
          <li class="item">
            <div class="testimonial same-height-always">
              <div class="text" style="text-align:center">
                <span class="numbers">2</span>
                <h5>İHTİYACINIZI DUYURUN</h5>
                <p>İhtiyacınızı sadece onaylı tedarikçilerinizle ya da seçeceğiniz firmalar ile paylaşabileceğiniz gibi sektördeki kayıtlı tüm firmalarla da paylaşabilirsiniz. Seçiminize göre sistem firmalara bildirim gönderecektir.</p>
              </div>
            </div>
          </li>
          <li class="item">
            <div class="testimonial same-height-always">
              <div class="text" style="text-align:center">
                <span class="numbers">3</span>
                <h5>TEKLİFLERİ TOPLAYIN</h5>
                <p>Belirlediğiniz satıcı firmalar teklif vererek rekabet ederler.</p>
              </div>
            </div>
          </li>
          <li class="item">
            <div class="testimonial same-height-always">
              <div class="text" style="text-align:center">
                <span class="numbers">4</span>
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
<section id="neler" class="section background-gray-lighter">
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
<!-- *** SSS ***-->
<section class="section no-padding-bottom">
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
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
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
          <p class="text-muted">Bize dilediğiniz zaman e-posta yoluyla ulaşarak destek alabilirsiniz.</p>
          <p><strong><a href="mailto:">info@tamrekabet.com</a></strong></p>
        </div>
      </div>
    </div>
  </div>
</section>
<footer class="footer">
  <div class="footer__copyright">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <p>&copy;2017 tamrekabet</p>
        </div>
        <div class="col-md-6">
        </div>
      </div>
    </div>
  </div>
</footer>
@endsection

<script>
  var acc = document.getElementsByClassName("accordion");
  var i;

  for (i = 0; i < acc.length; i++) {
    acc[i].onclick = function() {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight){
        panel.style.maxHeight = null;
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
      }
    }
  }
</script>
