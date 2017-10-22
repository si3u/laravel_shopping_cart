<div class="form-group">
    <label class="col-md-2 control-label"><span class="text-danger">*</span> Наименование</label>
    <div class="col-md-10">
        <input @if($page->route_name == 'wallpaper_categories/update')
               @isset($page->data_local->ru->name)
               value="{{$page->data_local->ru->name}}"
               @endisset
               @endif
               id="name_ru" name="name_ru" type="text" class="form-control" placeholder="Введите наименование">
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><span class="text-danger">*</span> Порядок сортировки</label>
    <div class="col-md-10">
        <input @if($page->route_name == 'wallpaper_categories/update')
               value="{{$page->category->sorting_order}}"
               @else
               value="0"
               @endif
               id="sorting_order_ru" name="sorting_order_ru" type="text" class="form-control" placeholder="Порядок сортировки">
        <span class="help-block">
            <small>Целочисленное значение. По этому значению сортируются категории.</small>
        </span>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Описание</label>
    <div class="col-md-10">
        <div id="description_ru" name="description_ru" class="editor">@if($page->route_name == 'categories/update') @isset($page->data_local->ru->description){!!$page->data_local->ru->description!!}@endisset @endif</div>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><span class="text-danger">*</span> Выберите родительскую категорию</label>
    <div class="col-md-10">
        <div id="parents_block">
            {!! $page->parents !!}
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Мета-тег Title</label>
    <div class="col-md-10">
        <input @if($page->route_name == 'wallpaper_categories/update')
               @isset($page->data_local->ru->meta_title)
               value="{{$page->data_local->ru->meta_title}}"
               @endisset
               @endif
               id="meta_title_ru" name="meta_title_ru" type="text" class="form-control" placeholder="Мета-тег Title">
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Мета-тег Description</label>
    <div class="col-md-10">
        <textarea id="meta_description_ru" name="meta_description_ru" rows="5" type="text" class="form-control" placeholder="Мета-тег Description">@if($page->route_name == 'categories/update') @isset($page->data_local->ru->meta_description) {{$page->data_local->ru->meta_description}} @endisset @endif</textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Мета-тег Keywords</label>
    <div class="col-md-10">
        <textarea id="meta_keywords_ru" name="meta_keywords_ru" rows="5" type="text" class="form-control" placeholder="Мета-тег Keywords">@if($page->route_name == 'categories/update') @isset($page->data_local->ru->meta_keywords) {{$page->data_local->ru->meta_keywords}} @endisset @endif</textarea>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-2"></label>
    <div class="col-md-10">
        <p class="text-muted m-b-30 font-14">
            * - отмечены обязательные для заполнения поля.
        </p>
    </div>
</div>
