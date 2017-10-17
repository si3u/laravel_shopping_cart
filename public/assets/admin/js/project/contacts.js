var contacts = {
    'save': function() {
        var form = $('#form_save_contacts');
        $.ajax({
            url: '/admin/contacts/update',
            type: "POST",
            dataType: 'JSON',
            data: form.serialize(),
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                insertErrorArray(form, XMLHttpRequest.responseJSON.errors, $('#group_errors'), $('#errors_list'));
                callToast.error('Ошибка', 'при изменении данных');
                return false;
            },
            success: function(response) {
                if (response.status === 'success') {
                    callToast.success('Контактная информация', 'успешно обновена');
                    return true;
                }
            }
        })
    }
};
