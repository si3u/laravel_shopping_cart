var comment = {
    'delete': function (id) {
        $('#href_delete').attr('href', '/admin/news/comment/delete/'+id);
        $('#modal_news_comment_delete').modal('show');
    }
};
$(document).ready(function () {
    $('#form_work_on').submit(function () {
        var form = $('#form_work_on');
        $.ajax({
            method: "POST",
            url: '/admin/news/comment/update',
            data: form.serialize(),
            dataType: 'JSON',
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                insertErrorArray(form, XMLHttpRequest.responseJSON.errors, $('#group_errors'), $('#errors_list'));
                callToast.error('Ошибка', 'при обновлении комментария');
                return false;
            },
            success: function (response) {
                if (response.status == 'success') {
                    callToast.success('Данные', 'успешно изменены');
                    return true;
                }
                callToast.error('Ошибка', 'при изменении данных');
            }
        });
    });
});
