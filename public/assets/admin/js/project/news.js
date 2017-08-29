var news = {
    'add': function () {
        var formData = new FormData();
        if ($('#image')[0].files[0] != undefined) {
            formData.append('image', $('#image')[0].files[0]);
        }
        for (var i in local) {
            var topic = $('#topic_' + local[i].lang).val();
            var value = textboxio.replace('#text_'+local[i].lang).content.get();
            var mTitle = $('#meta_title_'+local[i].lang).val();
            var mDescription = $('#meta_description_'+local[i].lang).val();
            var mKeywords = $('#meta_keywords_'+local[i].lang).val();
            var tags = $('#tags_'+local[i].lang).val();
            if (topic.length > 0 && value.length > 0) {
                formData.append('topic_' + local[i].lang, topic);
                formData.append('text_' + local[i].lang, value);

                if (mTitle.length > 0) {
                    formData.append('meta_title_' + local[i].lang, mTitle);
                }
                if (mDescription.length > 0) {
                    formData.append('meta_description_' + local[i].lang, mDescription);
                }
                if (mKeywords.length > 0) {
                    formData.append('meta_keywords_' + local[i].lang, mKeywords);
                }
                if (tags.length > 0) {
                    formData.append('tags_' + local[i].lang, tags);
                }
            }
        }
        $.ajax({
            method: "POST",
            url: '/admin/news/add',
            data: formData,
            contentType: false,
            processData: false,
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest.responseJSON);
                insertErrorArray(
                    $('#form_work_on'),
                    XMLHttpRequest.responseJSON.errors,
                    $('#group_errors'),
                    $('#errors_list')
                );
                callToast.error('Ошибка', 'при добавлении новости');
                return false;
            },
            success: function (result) {
                if (result.status == 'success') {
                    $('#image').val(null);
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
            var value = textboxio.replace('#text_'+local[i].lang).content.get();
            var mTitle = $('#meta_title_'+local[i].lang).val();
            var mDescription = $('#meta_description_'+local[i].lang).val();
            var mKeywords = $('#meta_keywords_'+local[i].lang).val();
            var tags = $('#tags_'+local[i].lang).val();

            if (topic.length > 0 && value.length > 0) {
                formData.append('topic_' + local[i].lang, topic);
                formData.append('text_' + local[i].lang, value);

                if (mTitle.length > 0) {
                    formData.append('meta_title_' + local[i].lang, mTitle);
                }
                if (mDescription.length > 0) {
                    formData.append('meta_description_' + local[i].lang, mDescription);
                }
                if (mKeywords.length > 0) {
                    formData.append('meta_keywords_' + local[i].lang, mKeywords);
                }
                if (tags.length > 0) {
                    formData.append('tags_' + local[i].lang, tags);
                }
            }
        }

        $.ajax({
            method: "POST",
            url: '/admin/news/update',
            data: formData,
            contentType: false,
            processData: false,
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                insertErrorArray($('#form_work_on'), XMLHttpRequest.responseJSON.errors, $('#group_errors_contact'), $('#errors_list_contact'));
                callToast.error('Ошибка', 'при обновлении данных новости');
                return false;
            },
            success: function (result) {
                console.log(result);
                $('#image').val(null);
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
    },
    'delete': function (id) {
        $('#href_delete').attr('href', '/admin/news/delete/'+id);
        $('#modal_news_delete').modal('show');
    }
};