<header class="header header-basic header-style_12 menu-no-transparent header-sticky">
    <div class="header-top">
        <div class="container">
            <div class="header-top-content">
                <div class="header-top-left"> <span class="number-phone">+(00) 123 456 789</span></div>
                <div class="header-top-right">
                    <nav class="top-bar-navigation" id="top-bar-navigation">
                        <ul class="top_bar-nav">
                            <li class="menu-item"><a href="checkout.html">Корзина</a></li>
                        </ul>
                    </nav>
                    <div class="language-switcher-wrap">
                        <ul class="language-flag-switcher">
                            @if (app()->getLocale() === 'ru')
                                <li class="current-lang lang-switcher-li">
                                    <a href="/ru">
                                        <img width="18" height="12" alt="ua" src="{{asset('assets/images/ru.png')}}"> Русский <span class="icon-lang"><i class="fa fa-angle-down"></i></span>
                                    <a/>
                                    <ul class="language-switcher-inner">
                                        <li class="lang-switcher-li">
                                            <a href="/ua">
                                                <img width="18" height="12" alt="ua" src="{{asset('assets/images/ua.png')}}"> Українська
                                            <a/>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="current-lang lang-switcher-li">
                                    <a href="/ua">
                                        <img width="18" height="12" alt="ua" src="{{asset('assets/images/ua.png')}}"> Українська <span class="icon-lang"><i class="fa fa-angle-down"></i></span>
                                    <a/>
                                    <ul class="language-switcher-inner">
                                        <li class="lang-switcher-li">
                                            <a href="/ru">
                                                <img width="18" height="12" alt="ua" src="{{asset('assets/images/ru.png')}}"> Русский
                                            <a/>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-5 header-nav-left text-right">
                    <nav id="left-navigation" class="left-navigation head-nav-extra">
                        <div id="main-menu-left" class="main-nav main-menu">
                            <ul class="menu-nav">
                                <li class="menu-item"><a href="index.php">{{ __('header.home') }}</a></li>
                                <li class="menu-item menu-item-has-children megamenu-menu-item">
                                    <a href="shop.html">{{ __('header.paintings') }}</a>
                                    <div class="sub-menu megamenu">
                                        <div class="megamenu-inner">
                                            <div class="megamenu-content ">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <div class="col-md-3 col-sm-6">
                                                                    <div class="widget">
                                                                        <h6 class="widget-title">Галерея</h6>
                                                                        <div class="widget-content">
                                                                            <ul class="menu">
                                                                                <li class="menu-item"><a href="index.php?category">Квіти</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">Арт</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">Природа</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">Архітектура</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">Напої</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">Гори</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">Захід</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">Небо</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 col-sm-6">
                                                                    <div class="widget">
                                                                        <h6 class="widget-title">Наші колекції</h6>
                                                                        <div class="widget-content">
                                                                            <ul class="menu">
                                                                                <li class="menu-item"><a href="index.php?category">Модерн</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">Мінімалізм</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">Місяць</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">Бенкі</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">Ретро-постери</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">Елвіс Преслі</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 col-sm-6">
                                                                    <div class="widget">
                                                                        <h6 class="widget-title">Тип приміщення</h6>
                                                                        <div class="widget-content">
                                                                            <ul class="menu">
                                                                                <li class="menu-item"><a href="index.php?category">В спальню</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">В вітальню</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">В офіс</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">В їдальню</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">В кафе</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">В отель</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">В дитячу</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 col-sm-6">
                                                                    <div class="widget">
                                                                        <h6 class="widget-title">Репродукції</h6>
                                                                        <div class="widget-content">
                                                                            <ul class="menu">
                                                                                <li class="menu-item"><a href="index.php?category">Славетні художники</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">Сучасні художники</a></li>
                                                                                <li class="menu-item"><a href="index.php?category">Художники різних часів</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="menu-item menu-item-has-children">
                                    <a href="#">{{ __('header.wallpapers') }}</a>
                                    <ul class="sub-menu">
                                        <li class="menu-item"><a href="index.php?category">В спальню</a></li>
                                        <li class="menu-item"><a href="index.php?category">В вітальню</a></li>
                                        <li class="menu-item"><a href="index.php?category">В офіс</a></li>
                                        <li class="menu-item"><a href="index.php?category">В їдальню</a></li>
                                        <li class="menu-item"><a href="index.php?category">В кафе</a></li>
                                        <li class="menu-item"><a href="index.php?category">В отель</a></li>
                                        <li class="menu-item"><a href="index.php?category">В дитячу</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item"><a href="index.php?dryk">{{ __('header.printing') }}</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="col-sm-2 header-logo text-center">
                    <div class="logo">
                        <a href="index-2.html">
                            <img src="{{asset('assets/images/logo.png')}}" alt="logo">
                        </a>
                    </div>
                </div>
                <div class="col-sm-5 header-nav-right text-left" >
                        <nav id="right-navigation-right" class="right-navigation head-nav-extra">
                        <div id="main-menu" class="main-nav main-menu">
                            <ul class="menu-nav">
                                <li class="menu-item"><a href="{{ route('public.price') }}">{{ __('header.prices') }}</a></li>
                                <li class="menu-item"><a href="{{route('public.news')}}">{{ __('header.news') }}</a></li>
                                <li class="menu-item menu-item-has-children">
                                    <a href="#">{{ __('header.help.value') }}</a>
                                    <ul class="sub-menu">
                                        <li class="menu-item"><a href="{{ route('public.text_page.payment') }}">{{ __('header.help.payment') }}</a></li>
                                        <li class="menu-item"><a href="{{ route('public.text_page.delivery') }}">{{ __('header.help.delivery') }}</a></li>
                                        <li class="menu-item"><a href="{{ route('public.text_page.cooperation') }}">{{ __('header.help.cooperation') }}</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item"><a href="index.php?contact">{{ __('header.contacts') }}</a></li>
                            </ul>
                        </div>
                    </nav>
                    <div class="header-right">
                        <div class="header-search header-element">
                            <span class="icon-search header-icon" data-togole="header-search"><i class="flaticon-search"></i></span>
                            <div id="header-search" class="header-element-content">
                                <h4 class="title-element">{{ __('header.search.title') }}</h4>
                                <form role="search" method="get" action="">
                                    <input type="text" value="" placeholder="{{ __('header.search.input') }}" class="search" id="s" name="q">
                                    <input type="submit" class="button-light" value="{{ __('header.search.button') }}">
                                </form>
                            </div>
                        </div>
                         <div class="header-cart header-element">
                                <a href="#"><span class="icon-cart header-icon" data-togole="header-cart"><i class="flaticon-bag"></i></span></a>
                                <span class="cart-number-items"> 5 </span>
                                <div id="header-cart" class="header-element-content">
                                    <h4 class="title-element">{{ __('header.cart.head') }}</h4>
                                    <p class="description-cart">{{ __('header.cart.title') }} <span>3 товар(ів)</span></p>
                                    <div class="xshop-cart_list">
                                        <div class="xshop-cart_list-inner content-scrollbar">
                                            <ul class="cart_list product_list_widget">
                                                <li class="mini_cart_item">
                                                    <a class="cart-remove" href="#"></a>
                                                    <a href="#" class="cart-img">
                                                        <img width="100"  src="../assets/images/sfdevelop/b001.jpg" alt="img">
                                                    </a>
                                                    <div class="cart-inner">
                                                        <a href="#">Назва товару</a>
                                                        <div class="quantity">
                                                            <p class="product-price"> 120.00 грн
                                                                <span class="quantity-input"> (x <input type="text" size="1" class="input-text qty text" title="Qty" value="1" disabled="disabled"> ) </span>
                                                            </p>
                                                            <div class="xshop-quantity">
                                                                <div class=" buttons_added">
                                                                    <a class="sign minus" href="#"></a>
                                                                    <a class="sign plus" href="#"></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="mini_cart_item">
                                                    <a class="cart-remove" href="#"></a>
                                                    <a href="#" class="cart-img">
                                                        <img width="100"  src="../assets/images/sfdevelop/b001.jpg" alt="img">
                                                    </a>
                                                    <div class="cart-inner">
                                                        <a href="#">Назва товару</a>
                                                        <div class="quantity">
                                                            <p class="product-price">
                                                                <ins><span class="price-amount amount">80.00 грн</span></ins><br>
                                                                <del><span class="price-amount amount">120.00 грн</span></del>
                                                                <span class="quantity-input"> (x <input type="text" size="1" class="input-text qty text" title="Qty" value="1" disabled="disabled"> ) </span>
                                                            </p>
                                                            <div class="xshop-quantity">
                                                                <div class=" buttons_added">
                                                                    <a class="sign minus" href="#"></a>
                                                                    <a class="sign plus" href="#"></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="mini_cart_item">
                                                    <a class="cart-remove" href="#"></a>
                                                    <a href="#" class="cart-img">
                                                        <img width="100"  src="../assets/images/sfdevelop/b001.jpg" alt="img">
                                                    </a>
                                                    <div class="cart-inner">
                                                        <a href="#">Назва товару</a>
                                                        <div class="quantity">
                                                            <p class="product-price">
                                                                <ins><span class="price-amount amount">80.00 грн</span></ins><br>
                                                                <del><span class="price-amount amount">120.00 грн</span></del>
                                                                <span class="quantity-input"> (x <input type="text" size="1" class="input-text qty text" title="Qty" value="1" disabled="disabled"> ) </span>
                                                            </p>
                                                            <div class="xshop-quantity">
                                                                <div class=" buttons_added">
                                                                    <a class="sign minus" href="#"></a>
                                                                    <a class="sign plus" href="#"></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul><!-- end product list -->
                                        </div>
                                        <div class="mini-cart-bottom">
                                            <p class="total">{{ __('header.cart.total_price') }} <span class="subtotal-price price-amount amount">200.00 грн</span></p>
                                            <p class="buttons">
                                                <a class="button " href="index.php?shipping">{{ __('header.cart.send_button') }}</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <!-- End Cart Element -->
                        <!-- Button Menu Mobile -->
                        <a href="#" class="mobile-navigation">
                            <span class="button-icon">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </span>
                        </a>
                        <!-- End Button Menu Mobile -->
                    </div>
                    <!-- End Header Right -->
                </div>
                <!-- Menu On Mobile -->
                <div class="menu-mobile-extra"></div>
                <!-- End Menu On Mobile -->
            </div>
        </div>
    </div>
</header>
