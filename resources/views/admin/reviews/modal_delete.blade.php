<div id="modal_review_delete" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Подтверждение удаления</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-icon alert-white alert-danger alert-dismissible fade in" role="alert">
                    <i class="mdi mdi-information"></i>
                    Вы действительно хотите удалить этот отзыв?
                </div>
            </div>
            <div class="modal-footer">
                @if($page->route_name == 'review/page_update')
                    <a href="{{route('review/delete', ['id' => $page->review->id])}}" class="btn btn-danger">
                        <i class="dripicons-trash"></i> Удалить
                    </a>
                @else
                    <a id="href_delete" href="" class="btn btn-danger">
                        <i class="dripicons-trash"></i> Удалить
                    </a>
                @endif
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                    <i class="dripicons-cross"></i> Отмена
                </button>
            </div>
        </div>
    </div>
</div>