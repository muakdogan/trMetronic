<!-- begin::Header -->
<header class="m-grid__item		m-header "  data-minimize="minimize" data-minimize-offset="200" data-minimize-mobile-offset="200" >
    <div class="m-header__top">
        <div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
            <div class="m-stack m-stack--ver m-stack--desktop">
                <!-- begin::Brand -->
                <div class="m-stack__item m-brand">
                    <div class="m-stack m-stack--ver m-stack--general m-stack--inline">
                        <div class="m-stack__item m-stack__item--middle m-brand__logo">
                            <a href="index.html" class="m-brand__logo-wrapper">
                                <img alt="" src="{{asset('MetronicFiles/menu/demo/demo5/media/img/logo/logo.png')}}"/>
                            </a>
                        </div>
                        <div class="m-stack__item m-stack__item--middle m-brand__tools">
                            <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-left m-dropdown--align-push" data-dropdown-toggle="click" aria-expanded="true">
                                <a href="#" class="dropdown-toggle m-dropdown__toggle btn btn-outline-metal m-btn  m-btn--icon m-btn--pill">
												<span>
													Ana Menü
												</span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--left m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav">
                                                    <li class="m-nav__section m-nav__section--first m--hide">
																	<span class="m-nav__section-text">
																		Quick Menu
																	</span>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-share"></i>
                                                            <span class="m-nav__link-text">
																			İlan Ara
																		</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- begin::Responsive Header Menu Toggler-->
                            <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                                <span></span>
                            </a>
                            <!-- end::Responsive Header Menu Toggler-->
                            <!-- begin::Topbar Toggler-->
                            <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                                <i class="flaticon-more"></i>
                            </a>
                            <!--end::Topbar Toggler-->
                        </div>
                    </div>
                </div>
                <!-- end::Brand -->
                <!-- begin::Topbar -->
                <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                    <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                        <div class="m-stack__item m-topbar__nav-wrapper">
                            <ul class="m-topbar__nav m-nav m-nav--inline">

                                <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="click">
                                    <a href="#" class="m-nav__link m-dropdown__toggle">
													<span class="m-topbar__welcome">
														Merhaba,&nbsp;
													</span>
                                        <span class="m-topbar__username">
														{{session()->get('kullanici_adi') }} / {{session()->get('firma_adi')}}
													</span>
                                        <span class="m-topbar__userpic">
														<img src="{{asset('MetronicFiles/menu/app/media/img/users/user4.jpg')}}" class="img-circle m--img-rounded m--marginless m--img-centered" alt=""/>
													</span>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__header m--align-center" style="background: url({{asset('MetronicFiles/menu/app/media/img/misc/user_profile_bg.jpg')}}); background-size: cover;">
                                                <div class="m-card-user m-card-user--skin-dark">
                                                    <div class="m-card-user__pic">
                                                        <img src="{{asset('MetronicFiles/menu/app/media/img/users/user4.jpg')}}" class="m--img-rounded m--marginless img-circle" alt=""/>
                                                    </div>
                                                    <div class="m-card-user__details">
																	<span class="m-card-user__name m--font-weight-500">
																		{{session()->get('kullanici_adi') }} / {{session()->get('firma_adi')}}
																	</span>
                                                        <a href="" class="m-card-user__email m--font-weight-300 m-link">
                                                            mark.andre@gmail.com
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav m-nav--skin-light">
                                                        <li class="m-nav__section m--hide">
																		<span class="m-nav__section-text">
																			Section
																		</span>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" class="m-nav__link">
                                                                <i class="m-nav__link-icon fa fa-tachometer"></i>
                                                                <span class="m-nav__link-title">
																				<span class="m-nav__link-wrap">
																					<span class="m-nav__link-text">
																						Firma İşlemleri
																					</span>
																				</span>
																			</span>
                                                            </a>
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
                                                        <li class="m-nav__item">
                                                            <a href="{{url('yeniFirmaKaydet/')}}" class="m-nav__link">
                                                                <i class="m-nav__link-icon icon-plus"></i>
                                                                <span class="m-nav__link-text">
																				Yeni Firma Ekle
																			</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="{{URL::to('kullaniciBilgileri')}}" class="m-nav__link">
                                                                <i class="m-nav__link-icon icon-info"></i>
                                                                <span class="m-nav__link-text">
																				Bilgilerim
																			</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" class="m-nav__link">
                                                                <i class="m-nav__link-icon icon-question"></i>
                                                                <span class="m-nav__link-text">
																				Yardım
																			</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__separator m-nav__separator--fit"></li>
                                                        <li class="m-nav__item">
                                                            <a href="{{url('/sessionKill')}}" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
                                                                Çıkış Yap
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <!-- end::Topbar -->
            </div>
        </div>
    </div>
    <div class="m-header__bottom">
        <div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
            <div class="m-stack m-stack--ver m-stack--desktop">
                <!-- begin::Horizontal Menu -->
                <div class="m-stack__item m-stack__item--middle m-stack__item--fluid">
                    <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-light " id="m_aside_header_menu_mobile_close_btn">
                        <i class="la la-close"></i>
                    </button>
                    <?php $firmaId = session()->get('firma_id'); ?>
                    <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-dark m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light "  >
                        <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
                            <li class="m-menu__item  m-menu__item--active"  aria-haspopup="true">
                                <a href="{{URL::to('firmaIslemleri', array($firmaId))}}" class="m-menu__link ">
                                    <span class="m-menu__item-here"></span>
                                    <span class="m-menu__link-text">
													<i class=" icon-home"></i>
												</span>
                                </a>
                            </li>
                            <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="click" aria-haspopup="true">
                                <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                                    <span class="m-menu__item-here"></span>
                                    <span class="m-menu__link-text"><i class="icon-globe"></i>
													Firma İşlemleri
												</span>
                                    <i class="m-menu__hor-arrow la la-angle-down"></i>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </a>
                                <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                                    <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                    <ul class="m-menu__subnav">
                                        <li class="m-menu__item "  aria-haspopup="true">
                                            <a  href="{{URL::to('firmaProfili')}}" class="m-menu__link ">
                                                <i class="m-menu__link-icon icon-like"></i>
                                                <span class="m-menu__link-text">
                                                    Firma Profilim
                                                </span>
                                            </a>
                                        </li>
                                        <li class="m-menu__item" aria-haspopup="true">
                                            <a  href="{{URL::to('uyelikBilgileri')}}" class="m-menu__link">
                                                <i class="m-menu__link-icon icon-info"></i>
                                                <span class="m-menu__link-text">
                                                    Üyelik Bilgileri
                                                </span>
                                            </a>
                                        </li>
                                        <li class="m-menu__item" aria-haspopup="true">
                                            <a  href="{{URL::to('onayliTedarikcilerim')}}" class="m-menu__link">
                                                <i class="m-menu__link-icon icon-star"></i>
                                                <span class="m-menu__link-text">
                                                    Onaylı Tedarikçilerim
                                                </span>
                                            </a>
                                        </li>
                                        <li class="m-menu__item" aria-haspopup="true">
                                            <a  href="{{URL::to('firmaHavuzu')}}" class="m-menu__link">
                                                <i class="m-menu__link-icon icon-list"></i>
                                                <span class="m-menu__link-text">
                                                    Firma Havuzu
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="click" aria-haspopup="true">
                                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                    <span class="m-menu__item-here"></span>
                                    <span class="m-menu__link-text"><i class="icon-paper-plane"></i>
													İlan İşlemleri
												</span>
                                    <i class="m-menu__hor-arrow la la-angle-down"></i>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </a>
                                <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                                    <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                    <ul class="m-menu__subnav">
                                        <li class="m-menu__item "  aria-haspopup="true">
                                            <a href="{{URL::to('ilanlarim', array($firmaId))}}" class="m-menu__link ">
                                                <i class="m-menu__link-icon icon-like"></i>
                                                <span class="m-menu__link-text">
                                                    İlanlarım
                                                </span>
                                            </a>
                                        </li>
                                        <li class="m-menu__item" aria-haspopup="true">
                                            <a href="{{URL::to('ilanOlustur', array($firmaId))}}" class="m-menu__link">
                                                <i class="m-menu__link-icon icon-plus"></i>
                                                <span class="m-menu__link-text">
                                                    İlan Oluştur
                                                </span>
                                            </a>
                                        </li>
                                        <li class="m-menu__item" aria-haspopup="true">
                                            <a href="{{URL::to('davetEdildigim')}}" class="m-menu__link">
                                                <i class="m-menu__link-icon icon-call-in"></i>
                                                <span class="m-menu__link-text">
                                                    Davet Edildiğim İlanlar
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="click" aria-haspopup="true">
                                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                    <span class="m-menu__item-here"></span>
                                    <span class="m-menu__link-text"><i class="icon-size-actual"></i>
													Başvuru İşlemleri
												</span>
                                    <i class="m-menu__hor-arrow la la-angle-down"></i>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </a>
                                <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                                    <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                    <ul class="m-menu__subnav">
                                        <li class="m-menu__item "  aria-haspopup="true">
                                            <a href="{{URL::to('basvurularim', array($firmaId))}}" class="m-menu__link ">
                                                <i class="m-menu__link-icon icon-list"></i>
                                                <span class="m-menu__link-text">
                                                    Başvurularım
                                                </span>
                                            </a>
                                        </li>
                                        <li class="m-menu__item" aria-haspopup="true">
                                            <a href="{{url('ilanAra/')}}" class="m-menu__link">
                                                <i class="m-menu__link-icon icon-plus"></i>
                                                <span class="m-menu__link-text">
                                                    Başvur
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="click" aria-haspopup="true">
                                <a href="{{URL::to('kullaniciIslemleri')}}" class="m-menu__link">
                                    <span class="m-menu__item-here"></span>
                                    <span class="m-menu__link-text"><i class="icon-users"></i>
                                        Kullanıcı İşlemleri
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- end::Horizontal Menu -->
                <!--begin::Search-->
                <div class="m-stack__item m-stack__item--middle m-dropdown m-dropdown--arrow m-dropdown--large m-dropdown--mobile-full-width m-dropdown--align-right m-dropdown--skin-light m-header-search m-header-search--expandable m-header-search--skin-" id="m_quicksearch" data-search-type="default">

                    <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
                        <li class="m-menu__item  m-menu__item--active"  aria-haspopup="true">
                            <a  href="index.html" class="m-menu__link ">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">
												Hoops
											</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!--end::Search-->
            </div>
        </div>
    </div>
</header>
<!-- end::Header -->
				