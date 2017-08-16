<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">
        <div id="sidebar-menu">
            <ul class="metisMenu nav" id="side-menu">
                <li>
                    <a href="javascript: void(0);" aria-expanded="true">
                        <i class="dripicons-tags"></i>
                        <span>
                            Кателог
                        </span>
                        @if($all_notifications_catalog > 0)
                            <span class="badge badge-success pull-right">
                                {{$all_notifications_catalog}}
                            </span>
                        @else
                            <span class="menu-arrow"></span>
                        @endif
                    </a>
                    <ul class="nav-second-level nav" aria-expanded="true">
                        <li><a href="{{route('admin/categories')}}">Категории</a></li>
                        <li><a href="{{route('admin/products')}}">Товары</a></li>
                        <li><a href="{{route('admin/recommend_products')}}">Рекомендуемые товары</a></li>
                        <li>
                            <a href="{{route('admin/comments')}}">
                                Комментарии
                                @if($count_new_comments>0)
                                    <span class="badge badge-success pull-right">{{$count_new_comments}}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{route('products/reviews')}}">
                                Отзывы
                                @if($count_new_reviews>0)
                                    <span class="badge badge-success pull-right">{{$count_new_reviews}}</span>
                                @endif
                            </a>
                        </li>
                        <li><a href="{{route('admin/modular_images')}}">Модули</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" aria-expanded="true">
                        <i class="mdi mdi-cart-outline"></i>
                        <span>
                            Продажи
                        </span>
                        @if($count_new_orders > 0)
                            <span class="badge badge-success pull-right">
                                {{$count_new_orders}}
                            </span>
                        @else
                            <span class="menu-arrow"></span>
                        @endif
                    </a>
                    <ul class="nav-second-level nav" aria-expanded="true">
                        <li><a href="{{route('admin/orders')}}">
                                Заказы
                                @if($count_new_orders > 0)
                                    <span class="badge badge-success pull-right">
                                        {{$count_new_orders}}
                                    </span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{route('admin/news')}}">
                        <i class="mdi mdi-newspaper"></i>
                        <span> Новости </span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" aria-expanded="true">
                        <i class="dripicons-align-justify"></i>
                        <span> Страницы </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level nav" aria-expanded="true">
                        <li><a href="/admin/text_page/1">Оплата и доставка</a></li>
                        <li><a href="/admin/text_page/2">О нас</a></li>
                        <li><a href="/admin/text_page/3">Сотрудничество</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" aria-expanded="true">
                        <i class="dripicons-gear"></i>
                        <span> Настройки </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level nav" aria-expanded="true">
                        <li><a href="{{route('admin/default_sizes')}}"> Размеры картин</a></li>
                        <li>
                            <a href="javascript: void(0);" aria-expanded="true"> Заказ <span class="menu-arrow"></span></a>
                            <ul class="nav-third-level nav" aria-expanded="true">
                                <li><a href="{{route('admin/prices')}}"> Цены </a></li>
                                <li><a href="{{route('setting/order_statuses')}}"> Статусы заказов </a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" aria-expanded="true"> Оплата/Доставка <span class="menu-arrow"></span></a>
                            <ul class="nav-third-level nav" aria-expanded="true">
                                <li><a href="{{route('admin/payment_methods')}}"> Методы оплаты </a></li>
                                <li><a href="{{route('admin/delivery_methods')}}"> Методы доставки </a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" aria-expanded="true">Фильтры <span class="menu-arrow"></span></a>
                            <ul class="nav-third-level nav" aria-expanded="true">
                                <li><a href="{{route('admin/filter_colors')}}">По цвету</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0);" onclick="contacts.get()"> Контакты </a></li>
                        <li><a href="javascript:;" onclick="activeLocalization.get()"> Локализации</a></li>
                    </ul>
                </li>
            </ul>

        </div>
        <div class="clearfix"></div>
    </div>
</div>