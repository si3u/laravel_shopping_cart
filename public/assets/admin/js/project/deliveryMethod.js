var deliveryMethod = {
    'add': function () {
        var form = $('#form');
        $.ajax({
            method: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'JSON',
            success: function (response) {
                console.log(response);
                if (response.errors != undefined) {
                    insertErrorArray(form, response.errors, $('#group_errors'), $('#errors_list'));
                    return false;
                }
                if (response.status == 'success') {
                    form.attr('action', '/admin/delivery_method/update');
                    $('input[name="item_id"]').val(response.item_id);
                    $('#btn_add').hide(); $('#btn_update').show();
                    callToast.success('Метод доставки', 'успешно создан');
                    return true;
                }
                callToast.error('Ошибка', 'при добавлении метода доставки');
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
            success: function (response) {
                console.log(response);
                if (response.errors != undefined) {
                    insertErrorArray(form, response.errors, $('#group_errors'), $('#errors_list'));
                    return false;
                }
                if (response.status == 'success') {
                    callToast.success('Метод доставки', 'успешно изменен');
                    return true;
                }
                callToast.error('Ошибка', 'при обновлении метода доставки');
            }
        });
    },
    'delete': function (id) {
        $('#href_delete').attr('href', '/admin/delivery_method/delete/'+id);
        $('#modal_delivery_method_delete').modal('show');
    }
};