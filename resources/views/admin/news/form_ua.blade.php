<div class="form-group">
    <label class="control-label col-md-3"><span class="text-danger">*</span> Наименование</label>
    <div class="col-md-9">
        <input class="form-control" @isset($page->data->ua->topic) value="{{$page->data->ua->topic}}" @endisset id="topic_ua" name="topic_ua" placeholder="Введите наименование">
    </div>
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5 class="m-t-0 header-title text-center"><span class="text-danger">*</span> Текст новости</h5>
        <div class="editor" id="text_ua">@isset($page->data->ua->topic) {!! $page->data->ua->text !!} @endisset</div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3"> Мета-тег Title</label>
    <div class="col-md-9">
        <input class="form-control"
               @isset($page->data->ru->meta_title) value="{{$page->data->ru->meta_title}}" @endisset
               id="meta_title_ua" name="meta_title_ua"
               placeholder="Введите Мета-тег Title">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3"> Мета-тег Description</label>
    <div class="col-md-9">
        <textarea class="form-control"
                id="meta_description_ua" name="meta_description_ua"
                placeholder="Введите Мета-тег Description">@isset($page->data->ua->meta_description){{$page->data->ua->meta_description}}@endisset</textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3"> Мета-тег Keywords</label>
    <div class="col-md-9">
        <textarea class="form-control"
                id="meta_keywords_ua" name="meta_keywords_ua"
                placeholder="Введите Мета-тег Keywords">@isset($page->data->ua->meta_keywords){{$page->data->ua->meta_keywords}}@endisset</textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3"> Теги</label>
    <div class="col-md-9">
        <input class="form-control"
               @isset($page->data->ua->tags) value="{{$page->data->ua->tags}}" @endisset
               id="tags_ua" name="tags_ua"
               placeholder="Введите теги">
        <small>Через запятую</small>
    </div>
</div>
