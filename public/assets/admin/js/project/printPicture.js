var printPicture = {
    'delete': function (id) {
        $('#href_delete').attr('href', '/admin/order/print_picture/delete/'+id);
        $('#modal_order_print_picture_delete').modal('show');
    }
};

$(document).ready(function() {
    $('#form_work_on').submit(function() {
        $.ajax({
            url: '/admin/order/print_picture/update',
            type: "POST",
            dataType: 'JSON',
            data: $(this).serialize(),
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest.responseJSON);
                insertErrorArray(
                    $('#form_work_on'),
                    XMLHttpRequest.responseJSON.errors,
                    $('#group_errors'),
                    $('#errors_list')
                );
                callToast.error('Ошибка', 'при изменении данных');
                return false;
            },
            success: function(response) {
                if (response.status === 'success') {
                    callToast.success('Данные о заказе', 'успешно изменены');
                    return true;
                }
            }
        });
    });
});
