@if ($paginator->lastPage() > 1)
    <div class="pagation col-sm-12">
        <ul class="page-numbers">
            @if($paginator->currentPage() == 1)
            @else
                <li class="prev">
                    <a href="{{ $paginator->url(1) }}" class=" page-number">
                        {{ __('paginate.previous_page') }}
                    </a>
                </li>
            @endif

            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                @if (($paginator->currentPage() == $i))
                    <li><span class="page-numbers current">{{$i}}</span></li>
                @else
                    <li><a href="{{ $paginator->url($i) }}" class="page-number">{{$i}}</a></li>
                @endif
            @endfor

            @if ($paginator->currentPage() == $paginator->lastPage())
            @else
                <li class="next">
                    <a href="{{ $paginator->url($paginator->currentPage()+1) }}" class=" page-number">
                        {{ __('paginate.next_page') }}
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endif
