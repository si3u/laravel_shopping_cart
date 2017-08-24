<div id="modal_setting_active_localization" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Настройка локализации</h4>
            </div>
            <div class="modal-body">
                <p class="text-muted font-13 m-b-30">
                    Выберите активные локализации. Эти локализации будут учитываться при добавлении данных.
                </p>
                <form action="{{route('active_localization/update')}}" class="form-horizontal" id="form_update_localization">

                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" onclick="activeLocalization.update()">
                    <i class="dripicons-checkmark"></i> Изменить
                </button>
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                    <i class="dripicons-cross"></i> Закрыть
                </button>
            </div>
        </div>
    </div>
</div>