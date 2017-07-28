var category = {
    'add': function (lang_name, lang_id) {
        var requiredFields = ['name', 'sorting_order'];
        for (var i in local) {
            if (local[i].status == true) {
                for (var j in requiredFields) {
                    console.log()
                    if ($('#form_add_'+local[i].lang+' #'+requiredFields[j]).val().length < 1) {
                        callToast.error('Вы не заполнили обязательные поля', 'Они должны быть заполнены во всех формах активных локализаций');
                        return false;
                    }
                }
            }
        }
        var item_id = $('#item_id');
        var form = $('#form_add_'+lang_name);

        var data = form.serializeArray();
        data.push({ name: 'lang_id', value: lang_id});
        data.push({ name: "description", value: $('#description_'+lang_name).summernote('code')});
        if (item_id.val() != 'null') {
            data.push({ name: 'item_id', value: item_id.val()});
        }
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: data,
            dataType: 'JSON',
            success: function (result) {
                console.log(result);
                if (result.errors != undefined) {
                    insertErrorArray(
                        $('#form_add_'+lang_name),
                        result.errors,
                        $('#group_errors_'+lang_name),
                        $('#errors_list_'+lang_name)
                    );
                    callToast.error('Ошибка', 'при добавлении категории');
                    return false;
                }
                item_id.val(result.item_id);
                $('#update_id_'+lang_name).val(result.update_id);
                var parentsBlock = $('* #parents_block');
                parentsBlock.html(null);
                parentsBlock.html(result.parents);

                $('#btn_add_'+lang_name).hide();
                $('#btn_update_'+lang_name).show();

                callToast.success('Категория', 'успешно создана');
            }
        });
    },
    'update': function (lang_name, lang_id) {
        var form = $('#form_add_'+lang_name);
        var data = form.serializeArray();
        data.push({ name: 'lang_id', value: lang_id});
        data.push({ name: "description", value: $('#description_'+lang_name).summernote('code')});
        data.push({ name: "id", value: $('#update_id_'+lang_name).val()});

    }
}
$(document).ready(function () {
    $('* #parent_id').change(function () {
        console.log('change');
        $("* #parent_id").val($(this).val());
    });

});