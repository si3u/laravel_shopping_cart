var orderStatus = {
    'add': function () {
        var form = $('#form');
        var name = $('input[name="name"]').val();
        $.ajax({
            method: "POST",
            url: '/admin/setting/order_status/add',
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
                    $('<tr id="item_'+result.item_id+'" class="success">\n' +
                        '     <td class="text-center">'+name+'</td>\n' +
                        '     <td class="text-center">\n' +
                        '       <div class="btn-group m-b-10">'+
                        '           <a href="/admin/setting/order_status/upon_receipt/'+result.item_id+'" class="btn btn-custom">'+
                        '               <i class="dripicons-paperclip"></i>'+
                        '            </a>'+
                        '            <a href="/admin/setting/order_status/delete/'+result.item_id+'" class="btn btn-danger">' +
                        '               <i class="dripicons-trash"></i>'+
                        '            </a>' +
                        '       </div>'+
                        '     </td>\n' +
                        '  </tr>').insertAfter('#row_add');
                    form[0].reset();
                    setTimeout(function () {
                        $('[id^="item_"]').removeClass('success');
                    }, 2000);
                    callToast.success('Статус', 'Успешно добавлен');
                    return true;
                }
            }
        });
    }
};