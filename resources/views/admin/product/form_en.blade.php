<div class="form-group">
    <label class="control-label col-md-3"><span class="text-danger">*</span> Наименование</label>
    <div class="col-md-9">
        <input @isset($page->data->en->name) value="{{$page->data->en->name}}" @endisset id="name_en" name="name_en" class="form-control" placeholder="Введите наименование">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3">Мета-Title</label>
    <div class="col-md-9">
        <input @isset($page->data->en->meta_title) value="{{$page->data->en->meta_title}}" @endisset id="meta_title_en" name="meta_title_en" class="form-control" placeholder="Введите Мета-Title">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3">Мета-Description</label>
    <div class="col-md-9">
        <textarea id="meta_description_en" name="meta_description_en" class="form-control" placeholder="Введите Мета-Description">@isset($page->data->en->meta_description) {{$page->data->en->meta_description}} @endisset</textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3">Мета-Keywords</label>
    <div class="col-md-9">
        <textarea id="meta_keywords_en" name="meta_keywords_en" class="form-control" placeholder="Введите Мета-Keywords">@isset($page->data->en->meta_keywords) {{$page->data->en->meta_keywords}} @endisset</textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3">Теги</label>
    <div class="col-md-9">
        <input @isset($page->data->en->tags) value="{{$page->data->en->tags}}" @endisset id="tags_en" name="tags_en" class="form-control" placeholder="Введите теги">
    </div>
</div>