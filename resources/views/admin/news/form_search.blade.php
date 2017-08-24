<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <p class="panel-sub-title text-muted">Параметры поиска</p>
                <p class="panel-sub-title text-muted">Ни один с параметров не являтся обязательным параметром для поиска</p>
            </div>
            <div class="panel-body">
                <form action="{{route('admin/news/search')}}" method="get" class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Текст поиска</label>
                                <div class="col-md-9">
                                    <input @isset($page->old_text) value="{{$page->old_text}}" @endisset id="text" name="text" type="text" class="form-control" placeholder="Введите текст для поиска">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="option" class="col-md-3 control-label">Опции</label>
                                <div class="col-md-9">
                                    <select id="option" name="option" class="form-control">
                                        <option value=""
                                                @isset($page->old_option)
                                                @if($page->old_option == null)
                                                selected
                                                @endif
                                                @endisset >Искать везде</option>
                                        <option value="1"
                                                @isset($page->old_option)
                                                @if($page->old_option == '1')
                                                selected
                                                @endif
                                                @endisset >
                                            В наименовании
                                        </option>
                                        <option value="2"
                                                @isset($page->old_option)
                                                @if($page->old_option == '2')
                                                selected
                                                @endif
                                                @endisset >
                                            В тексте
                                        </option>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>