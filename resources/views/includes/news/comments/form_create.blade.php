<div class="comment-respond" id="respond" style="margin-bottom: 0px;">
    <form action="javascript:void(0);" novalidate="" class="comment-form" id="form_comment" method="post">
        <input type="hidden" id="form_action" value="{{ route('public.news.comment.create') }}">
        <h5 class="title-element-blog">{{__('news.comment.form.header')}}</h5>
        <input type="hidden" value="{{ $news->id }}" name="news_id" id="news_id">
        <div class="row">
            <div class="col-sm-6">
                <input type="text" value="{{ old('name') }}" placeholder="{{__('news.comment.form.name')}}" class="input-form" id="name" name="name" @if (Session::has('autofocus')) autofocus @endif>
            </div>
            <div class="col-sm-6">
                <input type="text" value="{{ old('email') }}" placeholder="{{__('news.comment.form.email')}}" class="input-form" id="email" name="email">
            </div>
        </div>
        <div class="message-comment">
            <textarea placeholder="Ваш відгук!" class="textarea-form" rows="3" id="{{__('news.comment.form.message')}}" name="message">{{ old('message') }}</textarea>
        </div>

        @include('includes.alerts.ajax')

        <p class="form-submit">
            <input type="submit" value="{{__('news.comment.form.submit')}}" class="button-submit" id="submit" name="submit">
            {{ csrf_field() }}
        </p>
    </form>
</div>
