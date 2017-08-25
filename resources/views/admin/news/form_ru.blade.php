<div class="form-group">
    <label class="control-label col-md-3"><span class="text-danger">*</span> Наименование</label>
    <div class="col-md-9">
        <input class="form-control" @isset($page->data->ru->topic) value="{{$page->data->ru->topic}}" @endisset id="topic_ru" name="topic_ru" placeholder="Введите наименование">
    </div>
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5 class="m-t-0 header-title">Текст новости:</h5>
        <div class="editor" id="text_ru">@isset($page->data->ru->topic) {!! $page->data->ru->text !!} @endisset</div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3"> Мета-тег Title</label>
    <div class="col-md-9">
        <input class="form-control"
               @isset($page->data->ru->meta_title) value="{{$page->data->ru->meta_title}}" @endisset
               id="meta_title_ru" name="meta_title_ru"
               placeholder="Введите Мета-тег Title">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3"> Мета-тег Description</label>
    <div class="col-md-9">
        <textarea class="form-control"
                id="meta_description_ru" name="meta_description_ru"
                placeholder="Введите Мета-тег Description">@isset($page->data->ru->meta_description){{$page->data->ru->meta_description}}@endisset</textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3"> Мета-тег Keywords</label>
    <div class="col-md-9">
        <textarea class="form-control"
                id="meta_keywords_ru" name="meta_keywords_ru"
                placeholder="Введите Мета-тег Keywords">@isset($page->data->ru->meta_keywords){{$page->data->ru->meta_keywords}}@endisset</textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3"> Теги</label>
    <div class="col-md-9">
        <input class="form-control"
               @isset($page->data->ru->tags) value="{{$page->data->ru->tags}}" @endisset
               id="tags_ru" name="tags_ru"
               placeholder="Введите теги">
        <small>Через запятую</small>
    </div>
</div>
