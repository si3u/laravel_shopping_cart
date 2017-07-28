<form id="form_add_ua" action="{{route('admin/category/add')}}" class="form-horizontal" role="form" onclick="return false;">
    <input type="hidden" id="update_id_ua" value="null">
    <div class="form-group">
        <label class="col-md-2 control-label"><span class="text-danger">*</span> Наименование</label>
        <div class="col-md-10">
            <input id="name" name="name" type="text" class="form-control" placeholder="Введите наименование">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label"><span class="text-danger">*</span> Порядок сортировки</label>
        <div class="col-md-10">
            <input id="sorting_order" value="0" name="sorting_order" type="text" class="form-control" placeholder="Порядок сортировки">
            <span class="help-block">
                <small>Целочисленное значение. По этому значению сортируются категории.</small>
            </span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label"> SEO URL</label>
        <div class="col-md-10">
            <input id="slug" name="slug" type="text" class="form-control" placeholder="Введите SEO URL">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">Описание</label>
        <div class="col-md-10">
            <div id="description_ua" name="description_ua" class="summernote"></div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label"><span class="text-danger">*</span> Выберите родительскую категорию</label>
        <div class="col-md-10">
            <div id="parents_block_ua">
                {!! $page->parents !!}
            </div>
            <span class="help-block">
                <small>Не определено - если хотите чтобы это была родительская категория</small>
            </span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">Мета-тег Title</label>
        <div class="col-md-10">
            <input id="meta_title" name="meta_title" type="text" class="form-control" placeholder="Мета-тег Title">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">Мета-тег Description</label>
        <div class="col-md-10">
            <textarea id="meta_description" name="meta_description" rows="5" type="text" class="form-control" placeholder="Мета-тег Description"></textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">Мета-тег Keywords</label>
        <div class="col-md-10">
            <textarea id="meta_keywords" name="meta_keywords" rows="5" type="text" class="form-control" placeholder="Мета-тег Keywords"></textarea>
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

    <div class="form-group" style="display: none;" id="group_errors_ua">
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
            <div class="text-left" id="errors_list_ua">

            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-2"></label>
        <div class="col-md-10">
            @if ($page->route_name == 'admin/categories/add')
                <div class="pull-right" id="btn_add_ua">
                    <button onclick="category.add('ua', 2);" class="btn btn-success btn-lg">Добавить</button>
                </div>
                <div class="pull-right" id="btn_update_ua" style="display: none;">
                    <button onclick="category.update('ua', 2);" class="btn btn-success btn-lg">Обновить данные</button>
                </div>
            @endif
            @if ($page->route_name == 'admin/categories/update')
                <div class="pull-right" id="btn_update_ua">
                    <button onclick="category.update('ua', 2);" class="btn btn-success btn-lg">Обновить данные</button>
                </div>
            @endif
        </div>
    </div>
</form>