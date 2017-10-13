@if (count($comments) > 0)
    <div id="comments" class="comments-area">
        <h5 class="comments-title title-element-blog">
            Відгуки <span>({{ $comments->total() }})</span>
        </h5>
        <ol class="comment-list">
            @foreach ($comments as $item)
                <li class="comment">
                    <div class="comment-item">
                        <div class="comment-author">
                            <img width="auto" height="100" class="avatar" src="{{asset('assets/images/user_default.png')}}" alt="">
                        </div>
                        <div class="comment-body">
                            <h6 class="author">{{$item->name}}</h6>
                            <div class="date-reply-comment">
                                <span class="date-comment">{{$item->created_at}}</span>

                            </div>
                            <div class="comment-content">
                                {{ $item->text }}
                            </div>
                        </div>

                    </div>
                </li>
            @endforeach
        </ol>
    </div>
@endif
