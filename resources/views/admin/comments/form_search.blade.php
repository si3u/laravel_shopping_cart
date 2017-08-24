<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <p class="panel-sub-title text-muted">Параметры поиска</p>
                <p class="panel-sub-title text-muted">Ни один с параметров не являтся обязательным параметром для поиска</p>
            </div>
            <div class="panel-body">
                <form action="{{route('comments/search')}}" method="get" class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Артикул товара</label>
                                <div class="col-md-9">
                                    <input @isset($page->old_vendor_code)
                                           value="{{$page->old_vendor_code}}"
                                           @endisset id="vendor_code" name="vendor_code" class="form-control" placeholder="Введите артикул товара">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">E-mail автора</label>
                                <div class="col-md-9">
                                    <input @isset($page->old_email) value="{{$page->old_email}}" @endisset id="email" name="email" type="text" class="form-control" placeholder="Введите E-mail авттора">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Искать в тексте комментариях</label>
                                <div class="col-md-9">
                                    <input @isset($page->old_text_search) value="{{$page->old_text_search}}" @endisset id="text_search" name="text_search" type="text" class="form-control" placeholder="Введите текст для поиска в комментариях">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="check_status" class="col-md-3 control-label">Статус</label>
                                <div class="col-md-9">
                                    <select id="check_status" name="check_status" class="form-control">
                                        <option value=""
                                                @isset($page->old_check_status)
                                                @if($page->old_check_status == null)
                                                selected
                                                @endif
                                                @endisset >Не учитывать</option>
                                        <option value="1"
                                                @isset($page->old_check_status)
                                                @if($page->old_check_status == '1')
                                                selected
                                                @endif
                                                @endisset >
                                            Только включенные комментарии
                                        </option>
                                        <option value="2"
                                                @isset($page->old_check_status)
                                                @if($page->old_check_status == '2')
                                                selected
                                                @endif
                                                @endisset >
                                            Только выключенные комментарии
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="read_status" class="col-md-3 control-label">Только новые</label>
                                <div class="col-md-9">
                                    <div class="checkbox checkbox-primary checkbox-single">
                                        <input type="checkbox" id="read_status" name="read_status"
                                               @if (isset($page->old_read_status))
                                                   checked
                                               @endif
                                               value="1" aria-label="Только новые">
                                        <label></label>
                                    </div>
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