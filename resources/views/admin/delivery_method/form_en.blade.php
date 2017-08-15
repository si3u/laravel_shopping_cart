<div class="form-group">
    <label class="col-md-3 control-label"><span class="text-danger">*</span> Наименование</label>
    <div class="col-md-9">
        <input @isset($page->data->en->name)
               value="{{$page->data->en->name}}"
               @endisset
               id="name_en" name="name_en" type="text" class="form-control" placeholder="Введите наименование">
    </div>
</div>