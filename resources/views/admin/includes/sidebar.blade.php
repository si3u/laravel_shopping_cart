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
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" aria-expanded="true">
                        <i class="dripicons-gear"></i>
                        <span> Настройки </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level nav" aria-expanded="true">
                        <li><a href="javascript:;" onclick="activeLocalization.get()">Настройки локализаций</a></li>
                        <li><a href="{{route('admin/default_sizes')}}">Настройки размеров картин</a></li>
                    </ul>
                </li>
            </ul>

        </div>
        <div class="clearfix"></div>
    </div>
</div>