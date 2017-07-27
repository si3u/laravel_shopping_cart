var category = {
    'add': function () {
        var form = $('#form_add');
        var data = form.serializeArray();
        data.push({ name: "description", value: $('#description').summernote('code')});
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: data,
            dataType: 'JSON',
            success: function (result) {
                console.log(result);
                if (result.errors != undefined) {
                    insertErrorArray(
                        $('#form_add'),
                        result.errors,
                        $('#group_errors'),
                        $('#errors_list')
                    );
                    callToast.error('Ошибка', 'при добавлении категории');
                    return false;
                }
                var item_id = $('#item_id');
                item_id.val(result.item_id);
                $('#btn_add').hide();
                $('#btn_update').show();
                callToast.success('Категория', 'успешно создана');
            }
        });
    },
    'update': function () {
        var form = $('#form_add');
        var data = form.serializeArray();
        data.push({ name: "description", value: $('#description').summernote('code')});
        data.push({ name: "id", value: $('#item_id').val()});
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: data,
            dataType: 'JSON',
            success: function (result) {
                console.log(result);
                if (result.errors != undefined) {
                    insertErrorArray(
                        $('#form_add'),
                        result.errors,
                        $('#group_errors'),
                        $('#errors_list')
                    );
                    callToast.error('Ошибка', 'при изменении данных категории');
                    return false;
                }
                callToast.success('Данные о категории', 'успешно изменены');
            }
        });
    }
}
$(document).ready(function () {

});