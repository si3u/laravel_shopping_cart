<div class="comment-respond" id="respond" style="margin-bottom: 0px;">
    <form action="{{ route('public.news.comment.create') }}" novalidate="" class="comment-form" id="commentform" method="post">
        <h5 class="title-element-blog">Залишити відгук!</h5>
        <input type="hidden" value="{{ $news->id }}" name="news_id" id="news_id">
        <div class="row">
            <div class="col-sm-6">
                <input type="text" value="{{ old('name') }}" placeholder="Ім'я" class="input-form" id="name" name="name" @if (Session::has('autofocus')) autofocus @endif>
            </div>
            <div class="col-sm-6">
                <input type="text" value="{{ old('email') }}" placeholder="Email" class="input-form" id="email" name="email">
            </div>
        </div>
        <div class="message-comment">
            <textarea placeholder="Ваш відгук!" class="textarea-form" rows="3" id="message" name="message">{{ old('message') }}</textarea>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger fade in alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
            </div>
        @endif
        @if (Session::has('success'))
            <div class="alert alert-success fade in alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                <p>{{ Session::get('success') }}</p>
            </div>
        @endif
        <p class="form-submit">
            <input type="submit" value="Надіслати" class="button-submit" id="submit" name="submit">
            {{ csrf_field() }}
        </p>
    </form>
</div>
