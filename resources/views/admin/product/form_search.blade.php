<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <p class="panel-sub-title text-muted">Поиск</p>
            </div>
            <div class="panel-body">
                <form action="{{route('admin/product/search')}}" method="get" class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Артикул</label>
                                <div class="col-md-9">
                                    <input id="vendor_code" name="vendor_code" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Наименование</label>
                                <div class="col-md-9">
                                    <input id="name" name="name" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status" class="col-md-3 control-label">Отображение в категор.</label>
                                <div class="col-md-9">
                                    <select id="status" name="status" class="form-control">
                                        <option value="">Не учитывать</option>
                                        <option value="1">Да</option>
                                        <option value="0">Нет</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status" class="col-md-3 control-label"></label>
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-lg btn-success">
                                        Поиск
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Дата добавления</label>
                                <div class="col-md-9">
                                    <div>
                                        <div class="input-daterange input-group" id="date-range">
                                            <input type="text" class="form-control" name="date_start" />
                                            <span class="input-group-addon bg-custom text-white b-0">до</span>
                                            <input type="text" class="form-control" name="date_end" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Категория</label>
                                <div class="col-md-9">
                                    {!! $page->tree !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>