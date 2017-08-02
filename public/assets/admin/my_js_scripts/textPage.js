var textPage = {
    'save': function () {
        var data = {};
        for (var i in local) {
            var dataRequired = $('#value_'+local[i].lang).summernote('code');
            data['value_'+local[i].lang] = dataRequired;
            if (dataRequired.length < 10) {
                callToast.error('Заполните все поля', 'На активных вкладках данные должны быть больше 10 символов');
                return false;
            }
        }

        var form = $('#form_save_text_page');
        data['id'] = $('input[name="item_id"]').val();
        $.ajax({
            method: "POST",
            url: form.attr('action'),
            data: data,
            dataType: 'JSON',
            success: function (result) {
                console.log(result);
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