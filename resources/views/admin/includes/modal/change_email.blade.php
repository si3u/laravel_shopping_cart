
<div id="modal_change_email" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Изменить E-mail</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="form_change_email" onclick="return false;">
                        <div class="col-md-12">
                            <p class="text-muted font-14 m-b-20">
                                На этот E-mail будет отправлено письмо с ссылкой по которой Вы сможете изменить пароль, если Вы его забудете.
                            </p>
                            <div class="form-group" id="group_now_pass">
                                <input value="{{Auth::user()->email}}" type="text" class="form-control" id="change_email" placeholder="Введите E-mail">
                            </div>
                            <div class="form-group" style="display: none;" id="group_errors_change_email">
                                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                    <div class="text-left" id="change_email_error_list">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success" id="btn_change_email">
                    <i class="dripicons-checkmark"></i> Изменить
                </button>
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                    <i class="dripicons-cross"></i> Закрыть
                </button>
            </div>
        </div>
    </div>
</div>