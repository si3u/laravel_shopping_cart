<div class="form-group">
    <label class="col-md-2 control-label"><span class="text-danger">*</span> Наименование</label>
    <div class="col-md-10">
        <input @isset($page->data->ru->name)
               value="{{$page->data->ru->name}}"
               @endisset
               id="name_ru" name="name_ru" type="text" class="form-control" placeholder="Введите наименование">
    </div>
</div>