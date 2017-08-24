<div class="form-group">
    <label class="control-label col-md-3"><span class="text-danger">*</span> Наименование</label>
    <div class="col-md-9">
        <input class="form-control" @isset($page->data->en->topic) value="{{$page->data->en->topic}}" @endisset id="topic_en" name="topic_en" placeholder="Введите наименование">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3"><span class="text-danger">*</span> Текст</label>
    <div class="col-md-9">
        <div class="summernote" id="text_en">@isset($page->data->en->topic) {!! $page->data->en->text !!} @endisset</div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3"> Мета-тег Title</label>
    <div class="col-md-9">
        <input class="form-control"
               @isset($page->data->en->meta_title) value="{{$page->data->en->meta_title}}" @endisset
               id="meta_title_en" name="meta_title_en"
               placeholder="Введите Мета-тег Title">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3"> Мета-тег Description</label>
    <div class="col-md-9">
        <textarea class="form-control"
                id="meta_description_en" name="meta_description_en"
                placeholder="Введите Мета-тег Description">@isset($page->data->en->meta_description){{$page->data->en->meta_description}}@endisset</textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3"> Мета-тег Keywords</label>
    <div class="col-md-9">
        <textarea class="form-control"
                id="meta_keywords_en" name="meta_keywords_en"
                placeholder="Введите Мета-тег Keywords">@isset($page->data->en->meta_keywords){{$page->data->en->meta_keywords}}@endisset</textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3"> Теги</label>
    <div class="col-md-9">
        <input class="form-control"
               @isset($page->data->en->tags) value="{{$page->data->en->tags}}" @endisset
               id="tags_en" name="tags_en"
               placeholder="Введите теги">
        <small>Через запятую</small>
    </div>
</div>
