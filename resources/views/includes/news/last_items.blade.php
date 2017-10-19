@if (count($last_news) > 0)
    <div class="widget widget_latest_post">
        <h4 class="title-sidebar">{{__('news.last_news')}}</h4>
        <ul class="recent_posts_list">
            @foreach ($last_news as $item)
                <?php $created = \Carbon\Carbon::parse($item->created_at)->formatLocalized('%d %b %Y'); ?>
                <li>
                    <figure class="post-img">
                        <a href="{{ route('public.show_news', ['id' => $item->id]) }}">
                            <img width="120"   alt="imgs"  src="{{ asset('/assets/images/news/'.$item->image_preview) }}">
                        </a>
                    </figure>
                    <div class="recent_posts_content">
                        <h5 class="title-post"><a href="{{ route('public.show_news', ['id' => $item->id]) }}" class="title-post">{{ $item->topic }}</a></h5>
                        <span class="ts-post-time">{{ $created }}</span>
                        <a href="{{ route('public.show_news', ['id' => $item->id]) }}" class="readmore-link">{{__('news.to_read')}} <i class="flaticon-arrow-pointing-to-right"></i></a>
                    </div>
                </li>
            @endforeach
         </ul>
    </div>
@endif
