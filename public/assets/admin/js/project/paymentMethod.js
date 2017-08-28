var paymentMethod = {
    'add': function () {
        var form = $('#form');
        $.ajax({
            method: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'JSON',
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                insertErrorArray(form, XMLHttpRequest.responseJSON.errors, $('#group_errors'), $('#errors_list'));
                callToast.error('Ошибка', 'при добавлении Метода оплаты');
                return false;
            },
            success: function (response) {
                if (response.status == 'success') {
                    form.attr('action', '/admin/payment_method/update');
                    $('input[name="item_id"]').val(response.item_id);
                    $('#btn_add').hide(); $('#btn_update').show();
                    callToast.success('Метод оплаты', 'успешно добавлен');
                    return true;
                }
            }
        });
    },
    'update': function () {
        var form = $('#form');
        $.ajax({
            method: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'JSON',
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                insertErrorArray(form, XMLHttpRequest.responseJSON.errors, $('#group_errors'), $('#errors_list'));
                callToast.error('Ошибка', 'при обновлении данных Метода оплаты');
                return false;
            },
            success: function (response) {
                if (response.status == 'success') {
                    callToast.success('Метод оплаты', 'успешно изменен');
                    return true;
                }
            }
        });
    },
    'delete': function (id) {
        $('#href_delete').attr('href', '/admin/payment_method/delete/'+id);
        $('#modal_payment_method_delete').modal('show');
    }
};