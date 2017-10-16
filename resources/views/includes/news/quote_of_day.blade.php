@isset($quote_of_day)
    <div class="widget widget_quote">
        <h4 class="title-sidebar">{{__('news.quote_day')}}</h4>
        <div class="blog-quote">
            <span class="flaticon-left-quote"></span>
            <div class="quote-content">
                {{ $quote_of_day }}
            </div>
        </div>
    </div>
@endisset
