$(document).ready(function() {
    $('#btn_send_message').click(function() {
        var form = $('#form_support');
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            dataType: 'JSON',
            data: form.serialize(),
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest.responseJSON.errors);
                insertAlertsArray(
                    form,
                    XMLHttpRequest.responseJSON.errors,
                    $('#ajax_alert_group'),
                    $('#ajax_alert_list'),
                    'error'
                );
            },
            success: function(response) {
                if (response.status === 'success') {
                    var alerts = {message: [response.message]};
                    insertAlertsArray(
                        form,
                        alerts,
                        $('#ajax_alert_group'),
                        $('#ajax_alert_list'),
                        'success'
                    );
                    return true;
                }
                return false;
            }
        });
    });
});
