var textPage = {
    'save': function () {
        var form = $('#form_save_text_page');
        var id = $('input[name="item_id"]').val();
        var value = $('#value').summernote('code');
        $.ajax({
            method: "POST",
            url: form.attr('action'),
            data: {'id': id, 'value': value},
            dataType: 'JSON',
            success: function (result) {
                if (result.errors != undefined) {
                    insertErrorArray(
                        form,
                        result.errors,
                        $('#group_errors'),
                        $('#errors_list')
                    );
                    return false;
                }
                if (result.status == 'success') {
                    callToast.success('Данные', 'успешно сохранены');
                    return true;
                }
            }
        });
    }
}