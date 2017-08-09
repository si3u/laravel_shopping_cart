var product = {
    'delete': function (id) {
        console.log(id);
        $('#href_delete').attr('href', '/admin/product/delete/'+id);
        $('#modal_product_delete').modal('show');
    }
};
$(document).ready(function () {
    $('#form_work_on').submit(function() {
        var formData = new FormData($(this)[0]);
        var itemId = $('input[name="item_id"]');
        if (itemId.val().length === 0) {
            $.ajax({
                method: "POST",
                url: "/admin/product/add",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    if (response.error !== undefined) {
                        callToast.error('Ошибка', response.error);
                        return false;
                    }
                    if (response.errors !== undefined) {
                        insertErrorArray(
                            $('#form_work_on'),
                            response.errors,
                            $('#group_errors'), $('#errors_list')
                        );
                        return false;
                    }
                    if (response.status == 'success') {
                        $('#image').val(null);
                        itemId.val(response.item_id);
                        $('#btn_submit').text('Обновить');
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
                url: "/admin/product/update",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    if (response.error !== undefined) {
                        callToast.error('Ошибка', response.error);
                        return false;
                    }
                    if (response.errors !== undefined) {
                        insertErrorArray(
                            $('#form_work_on'),
                            response.errors,
                            $('#group_errors'), $('#errors_list')
                        );
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