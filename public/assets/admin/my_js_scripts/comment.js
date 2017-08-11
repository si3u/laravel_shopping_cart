var comment = {
    'delete': function (id) {
        $('#href_delete').attr('href', '/admin/comment/delete/'+id);
        $('#modal_comment_delete').modal('show');
    }
};
$(document).ready(function () {
    $('#form_work_on').submit(function () {
        var form = $('#form_work_on');
        $.ajax({
            method: "POST",
            url: '/admin/comment/update',
            data: form.serialize(),
            dataType: 'JSON',
            success: function (response) {
                if (response.errors != undefined) {
                    insertErrorArray(form, response.errors, $('#group_errors'), $('#errors_list'));
                    return false;
                }
                if (response.status == 'success') {
                    callToast.success('Данные', 'успешно изменены');
                    return true;
                }
                callToast.error('Ошибка', 'при изменении данных');
            }
        });
    });
});