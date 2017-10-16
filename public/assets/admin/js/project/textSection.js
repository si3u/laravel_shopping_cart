var textSection = {
    'save': function () {
        var form = $('#form_save_text_section');
        $.ajax({
            method: "POST",
            url: '/admin/text_section/update',
            data: form.serialize(),
            dataType: 'JSON',
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                insertErrorArray(
                    $('#form_save_text_section'),
                    XMLHttpRequest.responseJSON.errors,
                    $('#group_errors'),
                    $('#errors_list')
                );
                callToast.error('Ошибка', 'при изменении данных');
                return false;
            },
            success: function (result) {
                if (result.status == 'success') {
                    callToast.success('Данные', 'успешно изменены');
                    return true;
                }
            }
        });
    }
};
