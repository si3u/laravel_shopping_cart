var textPage = {
    'save': function () {
        var data = {};
        for (var i in local) {
            data['value_'+local[i].lang] = textboxio.replace('#value_'+local[i].lang).content.get();
        }
        var form = $('#form_save_text_page');
        data['id'] = $('input[name="item_id"]').val();
        $.ajax({
            method: "POST",
            url: '/admin/text_page/update',
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
};