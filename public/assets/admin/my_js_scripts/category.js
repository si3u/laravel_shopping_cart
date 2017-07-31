var category = {
    'add': function () {
        var requiredFields = [];
        for (var i in local) {
            if (local[i].status == true) {
                requiredFields.push('name_'+local[i].lang);
                requiredFields.push('sorting_order_'+local[i].lang);
            }
        }
        for (var i in local) {
            if (local[i].status == true) {
                for (var j in requiredFields) {
                    if ($('#form_add #'+requiredFields[j]).val().length < 1) {
                        callToast.error('Вы не заполнили обязательные поля', 'Они должны быть заполнены во всех формах активных локализаций');
                        return false;
                    }
                }
            }
        }

        var form = $('#form_add');

        var data = form.serializeArray();
        for (var i in local) {
            if (local[i].status == true) {
                data.push({ name: 'description_'+local[i].lang, value: $('#description_'+local[i].lang).summernote('code')});
            }
        }
        $.ajax({
            method: 'POST',
            url: form.attr('action'),
            data: data,
            dataType: 'JSON',
            success: function (result) {
                if (result.errors != undefined) {
                    insertErrorArray(form, result.errors, $('#group_errors'), $('#errors_list'));
                    callToast.error('Ошибка', 'при добавлении категории');
                    return false;
                }
                if (result.status == 'success') {
                    $('input[name=item_id]').val(result.item_id);
                    form.attr('action', result.url_update)

                    $('#btn_add').hide();
                    $('#btn_update').show();

                    callToast.success('Категориия', 'успешно добавлена');
                    return true;
                }
            }
        });
    },
    'update': function () {
        var itemId = $('input[name=item_id]').val();
        var form = $('#form_add');
        var data = form.serializeArray();

        var requiredFields = [];
        for (var i in local) {
            if (local[i].status == true) {
                requiredFields.push('name_'+local[i].lang);
                requiredFields.push('sorting_order_'+local[i].lang);
            }
        }
        for (var i in local) {
            if (local[i].status == true) {
                for (var j in requiredFields) {
                    if ($('#form_add #'+requiredFields[j]).val().length < 1) {
                        callToast.error('Вы не заполнили обязательные поля', 'Они должны быть заполнены во всех формах активных локализаций');
                        return false;
                    }
                }
            }
        }

        for (var i in local) {
            if (local[i].status == true) {
                data.push({ name: 'description_'+local[i].lang, value: $('#description_'+local[i].lang).summernote('code')});
            }
        }

        $.ajax({
            method: 'POST',
            url: form.attr('action'),
            data: data,
            dataType: 'JSON',
            success: function (result) {
                if (result.error != undefined) {
                    callToast.success('Ошибка', result);
                    return false;
                }
                if (result.status == 'success') {
                    callToast.success('Данные', 'успешно обновлены');
                }
            }
        });
    }
}
$(document).ready(function () {
    $('* #parent_id').change(function () {
        $("* #parent_id").val($(this).val());
    });
    $('[id^="sorting_order_"]').change(function () {
        $('[id^="sorting_order_"]').val($(this).val());
    });
});