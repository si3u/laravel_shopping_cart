var product = {
    'add': function () {
        var data = $('#form_work_on').serializeArray();
        var requiredFields = [];

        for (var i in local) {
            requiredFields.push('name_'+local[i].lang);
        }

        /*for (var j in requiredFields) {
            if ($('#form_work_on #'+requiredFields[j]).val().length < 1) {
                callToast.error('Вы не заполнили обязательные поля', 'Они должны быть заполнены во всех формах активных локализаций');
                return false;
            }
        }*/

        if ($('#image')[0].files[0] != undefined) {
            data.push({name: 'image', value:$('#image')[0].files[0]});
        }
        /*else {
            callToast.error('Изображение', 'Не выбрано. Товар без изображение добавить нельзя');
            return false;
        }*/

        /*if ($('#min_width').val() === null || $('#max_width').val() === null || $('#min_height').val() === null ||
            $('#max_height').val() === null || $('#vendor_code').val() === null ||
            $('#category').val() === null || $('#size').val() === null) {
            callToast.error('Вы не заполнили обязательные поля', 'Они должны быть заполнены во всех формах активных локализаций');
            return false;
        }*/

        $.ajax({
            method: "POST",
            url: '/admin/product/add',
            data: data,
            success: function (result) {
                console.log(result);
                if (result.errors != undefined) {
                    insertErrorArray(
                        $('#form_work_on'),
                        result.errors,
                        $('#group_errors'),
                        $('#errors_list')
                    );
                    return false;
                }
            }
        });
    }
};

$(document).ready(function () {
    $('#form_work_on').submit(function() {
        var formData = new FormData($(this)[0]);
        $.ajax({
            method: "POST",
            url: "/admin/product/add",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                if (response.errors !== undefined) {
                    insertErrorArray(
                        $('#form_work_on'),
                        response.errors,
                        $('#group_errors'), $('#errors_list')
                    );
                    return false;
                }
            }
        });
        return false;
    });
});