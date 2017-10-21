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
                        <li>
                            <a href="javascript: void(0);" aria-expanded="true">
                                Картины
                                @if($all_notifications_catalog > 0)
                                    <span class="badge badge-success pull-right">
                                        {{$all_notifications_catalog}}
                                    </span>
                                @else
                                    <span class="menu-arrow"></span>
                                @endif
                            </a>
                            <ul class="nav-third-level nav" aria-expanded="true">
                                <li><a href="{{route('admin/categories')}}">Категории</a></li>
                                <li><a href="{{route('admin/paintings')}}">Просмотреть</a></li>
                                <li><a href="{{route('admin/recommend_paintings')}}">Рекомендуемые</a></li>
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
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" aria-expanded="true">
                        <i class="mdi mdi-cart-outline"></i>
                        <span>
                            Заказы
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
                                Картины
                                @if($count_new_orders > 0)
                                    <span class="badge badge-success pull-right">
                                        {{$count_new_orders}}
                                    </span>
                                @endif
                            </a>
                        </li>
                        <li><a href="{{route('admin/orders/print_pictures')}}">
                                На печать
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
                    <a href="javascript: void(0);" aria-expanded="true">
                        <i class="mdi mdi-newspaper"></i>
                        <span>
                            Новости
                        </span>
                        @if($count_new_news_comments > 0)
                            <span class="badge badge-success pull-right">
                                {{$count_new_news_comments}}
                            </span>
                        @else
                            <span class="menu-arrow"></span>
                        @endif
                    </a>
                    <ul class="nav-second-level nav" aria-expanded="true">
                        <li>
                            <a href="{{route('admin/news')}}">
                                Список новостей
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin/news/comments')}}">
                                Комментарии
                                @if($count_new_news_comments > 0)
                                    <span class="badge badge-success pull-right">
                                        {{$count_new_news_comments}}
                                    </span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin/text_section/update_page', ['section' => 'quote_of_day'])}}">
                                Цитата дня
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" aria-expanded="true">
                        <i class="dripicons-align-justify"></i>
                        <span> Страницы </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level nav" aria-expanded="true">
                        <li><a href="/admin/text_page/1">Оплата</a></li>
                        <li><a href="/admin/text_page/2">Доставка</a></li>
                        <li><a href="/admin/text_page/3">Сотрудничество</a></li>
                    </ul>
                </li>
                <li>
                    <a href="/admin/file_manager">
                        <i class="mdi mdi-file-outline"></i>
                        <span> Файловый менеджер </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin/analytics')}}">
                        <i class="icon-chart"></i>
                        <span> Аналитика </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin/contacts') }}">
                        <i class="dripicons-mail"></i>
                        <span> Контакты </span>
                    </a>
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
                        <li><a href="javascript:;" onclick="activeLocalization.get()"> Локализации</a></li>
                    </ul>
                </li>
            </ul>

        </div>
        <div class="clearfix"></div>
    </div>
</div>
