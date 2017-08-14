var modularSize = {
    'add': function () {
        var form = $('#form');
        var number = $('input[name="number"]').val();
        var width = $('input[name="width"]').val();
        var height = $('input[name="height"]').val();
        if (!$.isNumeric(width) || !$.isNumeric(height)) {
            form[0].reset();
            callToast.error('Ошибка', 'Значение высоты и ширены должны быть целочисленными');
            return false;
        }
        $.ajax({
            method: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'JSON',
            success: function (result) {
                console.log(result);
                if (result.error != undefined) {
                    callToast.error('Ошибка', result.error);
                    return false;
                }
                if (result.errors != undefined) {
                    insertErrorArray(form, result.errors, $('#group_errors'), $('#errors_list'));
                    return false;
                }
                if (result.status == 'success') {
                    $('<tr class="success" id="item_'+result.item_id+'">\n' +
                        '     <td class="text-center">Картина '+number+'</td>\n' +
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
                        $('[id^="item_"]').removeClass('success');
                    }, 2000);
                    callToast.success('Размер', 'Успешно добавлен');
                    return true;
                }
            }
        });
    },
    'delete': function (id) {
        $.ajax({
            method: "POST",
            url: '/admin/size_modular_image/delete',
            data: {'id': id},
            dataType: 'JSON',
            success: function (response) {
                if (response.status == 'success') {
                    $('#item_'+id).remove();
                    callToast.success('Размер модуля', 'успешно удален');
                    return true;
                }
                callToast.success('Ошибка', 'при удалении размера модуля');
            }
        })
    }
};