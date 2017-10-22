<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <p class="panel-sub-title text-muted">Параметры поиска</p>
                <p class="panel-sub-title text-muted">Ни один с параметров не являтся обязательным параметром для поиска</p>
            </div>
            <div class="panel-body">
                <form action="{{route('admin/paintings/search')}}" method="get" class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Артикул</label>
                                <div class="col-md-9">
                                    <input @isset($page->old_vendor_code) value="{{$page->old_vendor_code}}" @endisset id="vendor_code" name="vendor_code" type="text" class="form-control" placeholder="Артикул товара">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Наименование</label>
                                <div class="col-md-9">
                                    <input @isset($page->old_name) value="{{$page->old_name}}" @endisset id="name" name="name" type="text" class="form-control" placeholder="Наименование товара">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status" class="col-md-3 control-label">Отображение в категор.</label>
                                <div class="col-md-9">
                                    <select id="status" name="status" class="form-control">
                                        <option value=""
                                                @isset($page->old_status)
                                                @if($page->old_status == null)
                                                selected
                                                @endif
                                                @endisset >Не учитывать</option>
                                        <option value="1"
                                                @isset($page->old_status)
                                                    @if($page->old_status)
                                                        selected
                                                    @endif
                                                @endisset >
                                            Да
                                        </option>
                                        <option value="0"
                                                @isset($page->old_status)
                                                @if(!$page->old_status)
                                                    selected
                                                @endif
                                                @endisset >Нет</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status" class="col-md-3 control-label"></label>
                                <div class="col-md-9">
                                    <button type="reset" value="Reset" class="btn btn-lg btn-default">
                                        Сбросить
                                    </button>
                                    <button type="submit" class="btn btn-lg btn-success">
                                        Поиск
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date_start" class="col-md-2 control-label">От</label>
                                            <div class="col-md-10">
                                                <input @isset($page->old_date_start) value="{{$page->old_date_start}}" @endisset type="date" id="date_start" name="date_start" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date_end" class="col-md-2 control-label">До</label>
                                            <div class="col-md-10">
                                                <input @isset($page->old_date_end) value="{{$page->old_date_end}}" @endisset type="date" id="date_end" name="date_end" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <span class="help-block">
                                    <small>
                                        Поиск товаров по дате.
                                    </small>
                                </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! $page->tree !!}
                                    <span class="help-block">
                                        <small>
                                            Категории по которым будет применен поиск. Зажмите Ctrl+ЛКМ чтобы отменить несколько категорий.
                                        </small>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
