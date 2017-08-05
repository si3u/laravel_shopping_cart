<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">
        <div id="sidebar-menu">
            <ul class="metisMenu nav" id="side-menu">
                <li>
                    <a href="javascript: void(0);" aria-expanded="true">
                        <i class="dripicons-tags"></i>
                        <span> Кателог </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level nav" aria-expanded="true">
                        <li><a href="{{route('admin/categories')}}">Категории</a></li>
                        <li><a href="{{route('admin/products')}}">Товары</a></li>
                        <li><a href="{{route('admin/modular_images')}}">Модули</a></li>
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
                        <li><a href="{{route('admin/prices')}}"> Цены</a></li>
                        <li><a href="javascript:;" onclick="activeLocalization.get()"> Локализаций</a></li>
                        <li><a href="{{route('admin/default_sizes')}}"> Размеров картин</a></li>
                        <li>
                            <a href="javascript: void(0);" aria-expanded="true">Фильтры <span class="menu-arrow"></span></a>
                            <ul class="nav-third-level nav" aria-expanded="true">
                                <li><a href="{{route('admin/filter_colors')}}">По цвету</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
        <div class="clearfix"></div>
    </div>
</div>