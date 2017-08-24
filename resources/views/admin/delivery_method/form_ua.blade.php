<div class="form-group">
    <label class="col-md-3 control-label"><span class="text-danger">*</span> Наименование</label>
    <div class="col-md-9">
        <input @isset($page->data->ua->name)
               value="{{$page->data->ua->name}}"
               @endisset
               id="name_ua" name="name_ua" type="text" class="form-control" placeholder="Введите наименование">
    </div>
</div>