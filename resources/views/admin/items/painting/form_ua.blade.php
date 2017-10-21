<div class="form-group">
    <label class="control-label col-md-3"><span class="text-danger">*</span> Наименование</label>
    <div class="col-md-9">
        <input @isset($page->data->ua->name) value="{{$page->data->ua->name}}" @endisset id="name_ua" name="name_ua" class="form-control" placeholder="Введите наименование">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3">Мета-Title</label>
    <div class="col-md-9">
        <input @isset($page->data->ua->meta_title) value="{{$page->data->ua->meta_title}}" @endisset id="meta_title_ua" name="meta_title_ua" class="form-control" placeholder="Введите Мета-Title">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3">Мета-Description</label>
    <div class="col-md-9">
        <textarea id="meta_description_ua" name="meta_description_ua" class="form-control" placeholder="Введите Мета-Description">@isset($page->data->ua->meta_description) {{$page->data->ua->meta_description}} @endisset</textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3">Мета-Keywords</label>
    <div class="col-md-9">
        <textarea id="meta_keywords_ua" name="meta_keywords_ua" class="form-control" placeholder="Введите Мета-Keywords">@isset($page->data->ua->meta_keywords) {{$page->data->ua->meta_keywords}} @endisset</textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3">Теги</label>
    <div class="col-md-9">
        <input @isset($page->data->ua->tags) value="{{$page->data->ua->tags}}" @endisset id="tags_ua" name="tags_ua" class="form-control" placeholder="Введите теги">
    </div>
</div>