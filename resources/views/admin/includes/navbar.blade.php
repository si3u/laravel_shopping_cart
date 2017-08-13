<div class="topbar">
    <div class="topbar-left">
        <a href="/admin" class="logo">
            <span class="text-info">
                Админ.панель
            </span>
            <i class="text-info">
                Админ.панель
            </i>
        </a>
    </div>

    <div class="navbar navbar-default" role="navigation">
        <ul class="nav navbar-nav navbar-left nav-menu-left">
            <li>
                <button type="button" class="button-menu-mobile open-left waves-effect">
                    <i class="dripicons-menu"></i>
                </button>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="#" class="right-menu-item dropdown-toggle" data-toggle="dropdown">
                    <i class="dripicons-bell"></i>
                    <span class="badge badge-success">{{$count_notifications}}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-right dropdown-lg user-list notify-list">
                    <li class="list-group notification-list m-b-0">
                        <div class="slimscroll">
                            @if($count_new_comments>0)
                                <a href="{{route('comments/search', ['read_status' => 1])}}" class="list-group-item">
                                    <div class="media">
                                        <div class="media-left p-r-10">
                                            <em class="mdi mdi-comment-multiple-outline bg-custom"></em>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="media-heading text-custom">Комментарии</h5>
                                            <p class="m-0">
                                                Новых комментариев: {{$count_new_comments}}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @endif

                            <a href="{{route('reviews/search', ['read_status' => 1])}}" class="list-group-item">
                                <div class="media">
                                    <div class="media-left p-r-10">
                                        <em class="mdi mdi-comment-processing-outline bg-warning"></em>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading text-warning">Отзывы</h5>
                                        <p class="m-0">
                                            Новых отзывов: {{$count_new_reviews}}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="dropdown user-box">
                <a href="#" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="false">
                    <img src="{{asset('assets/admin/images/user_default.jpg')}}" alt="user-img" class="img-circle user-img">
                </a>
                <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                    <li class="divider"></li>
                    <li>
                        <a href="/admin/exit"><span> Выйти </span></a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>