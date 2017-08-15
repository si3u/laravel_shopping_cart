<div id="modal_contacts" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Контактная информация</h4>
            </div>
            <div class="modal-body">
                <form id="form_contacts" action="{{route('contacts/update')}}" method="POST" onclick="return false;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input id="email" name="email" class="form-control" placeholder="Введите E-mail">
                                <span class="help-block">
                                    <small>Этот E-mail будет использоватся для отправки на него: писем обратной связи, заказов</small>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input id="tel" name="tel" class="form-control" placeholder="Введите телефон">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea id="address" name="address" class="form-control" placeholder="Введите адресс"></textarea>
                            </div>
                            @include('admin.includes.alerts.error_ajax')
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success waves-effect" onclick="contacts.update()">
                    Сохранить
                </button>
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                    <i class="dripicons-cross"></i> Закрыть
                </button>
            </div>
        </div>
    </div>
</div>