var defaultSize = {
    'add': function () {
        var form = $('#form_default_size_add');
        var width = $('input[name="width"]').val();
        var height = $('input[name="height"]').val();
        /*if (!$.isNumeric(width) || !$.isNumeric(height)) {
            form[0].reset();
            callToast.error('Ошибка', 'Значение высоты и ширены должны быть целочисленными');
            return false;
        }*/
        $.ajax({
            method: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'JSON',
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest.responseJSON.errors);
            }
        });
        /* success: function (result) {
                console.log(result);
                if (result.status == 'success') {
                    $('<tr class="success" id="item_'+result.item_id+'">\n' +
                    '     <td class="text-center">'+width+'</td>\n' +
                    '     <td class="text-center">'+height+'</td>\n' +
                    '     <td class="text-center">\n' +
                    '         <button class="btn btn-danger" onclick="defaultSize.delete('+result.item_id+')">' +
                    '             <i class="dripicons-trash"></i>'+
                    '         </button>\n' +
                    '     </td>\n' +
                    '  </tr>').insertAfter('#row_add');
                    form[0].reset();
                    setTimeout(function () {
                        console.log('item: remove class success');
                        $('[id^="item_"]').removeClass('success');
                    }, 2000);
                    callToast.success('Размер', 'Успешно добавлен');
                    return true;
                }
            }*/
    },
    'delete': function (id) {
        $.ajax({
            method: "POST",
            url: '/admin/default_size/delete',
            data: {'id': id},
            dataType: 'JSON',
            success: function (result) {
                if (result.status == 'success') {
                    $('#item_'+id).remove();
                    callToast.success('Размер', 'успешно удален');
                    return true;
                }
            }
        });
    }
}
