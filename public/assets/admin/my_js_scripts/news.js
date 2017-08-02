var news = {
    'add': function () {
        var formData = new FormData();
        if ($('#image')[0].files[0] != undefined) {
            formData.append('image', $('#image')[0].files[0]);
        }
        for (var i in local) {
            var topic = $('#topic_' + local[i].lang).val();
            var value = $('#text_' + local[i].lang).summernote('code');
            if (topic.length > 0 && value.length > 0) {
                formData.append('topic_' + local[i].lang, topic);
                formData.append('text_' + local[i].lang, $('#text_' + local[i].lang).summernote('code'));
            }
            else {
                callToast.error('Заполните все поля', 'На активных вкладках должны быть заполнены обязательные поля');
                return false;
            }
        }

        $.ajax({
            method: "POST",
            url: '/admin/news/add',
            data: formData,
            contentType: false,
            processData: false,
            success: function (result) {
                console.log(result);
                $('#image').val(null);
                if (result.errors != undefined) {
                    insertErrorArray(
                        $('#form_work_on'),
                        result.errors,
                        $('#group_errors'),
                        $('#errors_list')
                    );
                    return false;
                }
                if (result.status == 'success') {
                    $('input[name="item_id"]').val(result.item_id);
                    $('#btn_add').hide();
                    $('#btn_update').show();
                    if (result.image != undefined) {
                        $('#group_now_image').show();
                        $('#now_image').attr('src', '/assets/images/news/'+result.image);
                    }
                    callToast.success('Новость', 'успешно создана');
                    return true;
                }
            }
        });
    },
    'update': function () {
        var formData = new FormData();
        formData.append('item_id', $('input[name="item_id"]').val());
        if ($('#image')[0].files[0] != undefined || $('#image')[0].files[0] != null) {
            formData.append('image', $('#image')[0].files[0]);
        }
        for (var i in local) {
            var topic = $('#topic_' + local[i].lang).val();
            var value = $('#text_' + local[i].lang).summernote('code');
            if (topic.length > 0 && value.length > 0) {
                formData.append('topic_' + local[i].lang, topic);
                formData.append('text_' + local[i].lang, $('#text_' + local[i].lang).summernote('code'));
            }
            else {
                callToast.error('Заполните все поля', 'На активных вкладках должны быть заполнены обязательные поля');
                return false;
            }
        }

        $.ajax({
            method: "POST",
            url: '/admin/news/update',
            data: formData,
            contentType: false,
            processData: false,
            success: function (result) {
                console.log(result);
                $('#image').val(null);
                if (result.errors != undefined) {
                    insertErrorArray(
                        $('#form_work_on'),
                        result.errors,
                        $('#group_errors'),
                        $('#errors_list')
                    );
                    return false;
                }
                if (result.status == 'success') {
                    if (result.image != undefined) {
                        $('#group_now_image').show();
                        $('#now_image').attr('src', '/assets/images/news/'+result.image);
                    }
                    callToast.success('Новость', 'успешно обновлена');
                    return true;
                }
            }
        });
    }
}