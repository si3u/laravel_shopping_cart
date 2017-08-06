<div class="form-group">
    <label class="control-label col-md-3"><span class="text-danger">*</span> Наименование</label>
    <div class="col-md-9">
        <input value="{{ old('name_ru') }}" id="name_ru" name="name_ru" class="form-control" placeholder="Введите наименование">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3">Мета-Title</label>
    <div class="col-md-9">
        <input value="{{ old('meta_title_ru') }}" id="meta_title_ru" name="meta_title_ru" class="form-control" placeholder="Введите Мета-Title">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3">Мета-Description</label>
    <div class="col-md-9">
        <textarea id="meta_description_ru" name="meta_description_ru" class="form-control" placeholder="Введите Мета-Description">{{ old('meta_description_ru') }}</textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3">Мета-Keywords</label>
    <div class="col-md-9">
        <textarea id="meta_keywords_ru" name="meta_keywords_ru" class="form-control" placeholder="Введите Мета-Keywords">{{ old('meta_keywords_ru') }}</textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3">Теги</label>
    <div class="col-md-9">
        <input value="{{ old('tags_ru') }}" id="tags_ru" name="tags_ru" class="form-control" placeholder="Введите теги">
    </div>
</div>