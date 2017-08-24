var filterColor = {
    'add': function () {
        var form = $('#form_add_color');
        $.ajax({
            method: "POST",
            url: '/admin/filter_color/add',
            data: form.serialize(),
            dataType: 'JSON',
            success: function (result) {
                if (result.errors != undefined) {
                    insertErrorArray(
                        form,
                        result.errors,
                        $('#group_errors_add_color'),
                        $('#errors_list_add_color')
                    );
                    return false;
                }
                if (result.status == 'success') {
                    var hex = $('#hex').val();
                    var name = $('#name').val();
                    if ($("div").is("#alert_empty")) {
                        $('#alert_empty').remove();
                    }
                    $('tbody').prepend(
                        '<tr id="item_'+result.item_id+'">\n' +
                        '    <td class="text-left">'+name+'</td>\n' +
                        '    <td class="text-center text-muted" bgcolor="'+hex+'">'+hex+'</td>\n' +
                        '    <td>\n' +
                        '        <button class="btn btn-danger btn-sm btn-block" onclick="filterColor.delete('+result.item_id+')">\n' +
                        '            <i class="dripicons-trash"></i>\n' +
                        '       </button>\n' +
                        '    </td>\n' +
                        '</tr>'
                    );
                    form[0].reset();
                    callToast.success('Цвет', 'успешно добавлен');
                    return true;
                }
            }
        });
    },
    'delete': function (id) {
        $.ajax({
            method: "POST",
            url: '/admin/filter_color/delete',
            data: {'id': id},
            dataType: 'JSON',
            success: function (result) {
                if (result.status == 'success') {
                    $('#item_'+id).remove();
                    callToast.success('Цвет', 'успешно удален');
                    return true;
                }
            }
        });
    }
};