<div class="form-group">
    <label class="control-label col-md-3"><span class="text-danger">*</span> Наименование</label>
    <div class="col-md-9">
        <input value="{{ old('name_ua') }}" id="name_ua" name="name_ua" class="form-control" placeholder="Введите наименование">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3">Мета-Title</label>
    <div class="col-md-9">
        <input value="{{ old('meta_title_ua') }}" id="meta_title_ua" name="meta_title_ua" class="form-control" placeholder="Введите Мета-Title">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3">Мета-Description</label>
    <div class="col-md-9">
        <textarea id="meta_description_ua" name="meta_description_ua" class="form-control" placeholder="Введите Мета-Description">{{ old('meta_description_ua') }}</textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3">Мета-Keywords</label>
    <div class="col-md-9">
        <textarea id="meta_keywords_ua" name="meta_keywords_ua" class="form-control" placeholder="Введите Мета-Keywords">{{ old('meta_keywords_ua') }}</textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3">Теги</label>
    <div class="col-md-9">
        <input value="{{ old('tags_ua') }}" id="tags_ua" name="tags_ua" class="form-control" placeholder="Введите теги">
    </div>
</div>