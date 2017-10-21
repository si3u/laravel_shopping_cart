var product = {
    'delete': function (id) {
        console.log(id);
        $('#href_delete').attr('href', '/admin/painting/delete/'+id);
        $('#modal_product_delete').modal('show');
    }
};
function checkProducts(option) {
    var form = $('#form_check');
    var action = '';
    if (option == 1) {
        action = '/admin/recommend_painting/add';
    }
    $.ajax({
        method: "POST",
        url: action,
        data: form.serialize(),
        dataType: 'JSON',
        success: function (response) {
            console.log(response);
            if (response.status == 'success') {
                callToast.success('Товар', 'успешно добавлен в рекомендуемые');
                return true;
            }
        }
    });
}
$(document).ready(function () {
    $('#form_work_on').submit(function() {
        var spinner = $('#spinner');
        var formData = new FormData($(this)[0]);
        var itemId = $('input[name="item_id"]');
        var btnSubmit = $('#btn_submit');
        spinner.show();
        btnSubmit.addClass('disabled');
        if (itemId.val().length === 0) {
            $.ajax({
                method: "POST",
                url: "/admin/painting/add",
                data: formData,
                contentType: false,
                processData: false,
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    insertErrorArray(
                        $('#form_work_on'),
                        XMLHttpRequest.responseJSON.errors,
                        $('#group_errors'),
                        $('#errors_list')
                    );
                    callToast.error('Ошибка', 'при добавлении товара');
                    spinner.hide();
                    btnSubmit.removeClass('disabled');
                    return false;
                },
                success: function(response) {
                    spinner.hide();
                    btnSubmit.removeClass('disabled');
                    if (response.error !== undefined) {
                        callToast.error('Ошибка', response.error);
                        return false;
                    }
                    if (response.status == 'success') {
                        $('#image').val(null);
                        itemId.val(response.item_id);
                        btnSubmit.html('Обновить <i id="spinner" class="fa fa-spinner fa-spin" style="display: none; font-size:18px"></i>');
                        if (response.preview_image != undefined) {
                            $('#group_now_image').show();
                            $('#now_image').attr('src', '/assets/images/products/'+response.preview_image);
                        }
                        callToast.success('Товар', 'успешно добавлен');
                        return true;
                    }
                }
            });
        }
        else {
            $.ajax({
                method: "POST",
                url: "/admin/painting/update",
                data: formData,
                contentType: false,
                processData: false,
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    insertErrorArray(
                        $('#form_work_on'),
                        XMLHttpRequest.responseJSON.errors,
                        $('#group_errors'),
                        $('#errors_list')
                    );
                    callToast.error('Ошибка', 'при обновлении данных о товара');
                    spinner.hide();
                    btnSubmit.removeClass('disabled');
                    return false;
                },
                success: function(response) {
                    spinner.hide();
                    btnSubmit.removeClass('disabled');
                    if (response.error !== undefined) {
                        callToast.error('Ошибка', response.error);
                        return false;
                    }
                    if (response.status == 'success') {
                        $('#image').val(null);
                        if (response.new_image != undefined) {
                            $('#now_image').attr('src', '/assets/images/products/'+response.new_image);
                        }
                        callToast.success('Товар', 'успешно обновлен');
                        return true;
                    }
                }
            });
        }
        return false;
    });
});
