
<div id="modal_edit_pass" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Изменить пароль</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="form_edit_pass" onclick="return false;">
                        <div class="col-md-12">
                            <p class="text-muted font-14 m-b-20">
                                Доступны только буквы латинского алфавита и цифры.
                            </p>
                            <div class="form-group" id="group_now_pass">
                                <input type="password" class="form-control" id="now_pass" placeholder="Введите нынешний пароль">
                                <div id="errors" style="display: none;">

                                </div>
                            </div>
                            <div class="form-group" id="group_new_pass1">
                                <input type="password" class="form-control" id="new_pass1" placeholder="Введите новый пароль">
                                <div id="errors" style="display: none;">

                                </div>
                            </div>
                            <div class="form-group" id="group_new_pass2">
                                <input type="password" class="form-control" id="new_pass2" placeholder="Повторите новый пароль">
                                <div id="errors" style="display: none;">

                                </div>
                            </div>
                            <div class="form-group" style="display: none;" id="group_errors_edit_pass">
                                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                    <div class="text-left" id="edit_pass_error_list">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success" id="btn_edit_pass">
                    <i class="dripicons-checkmark"></i> Изменить
                </button>
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                    <i class="dripicons-cross"></i> Закрыть
                </button>
            </div>
        </div>
    </div>
</div>