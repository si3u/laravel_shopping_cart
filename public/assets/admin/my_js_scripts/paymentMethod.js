var paymentMethod = {
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
        var itemId  = $('input[name="item_id"]').val();
        var form = $('#form');
        console.log(form.serialize());
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