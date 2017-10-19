$(document).ready(function() {
    if (getParam.get('page').length > 0) {
        $("html, body").delay(500).animate({
            scrollTop: $('#form_comment').offset().top
        }, 1000);
    }
    $('#form_comment').submit(function() {
        var form = $('#form_comment');
        var action = $('#form_action').attr('value');
        $.ajax({
            url: action,
            type: "POST",
            dataType: 'JSON',
            data: $(this).serialize(),
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                insertAlertsArray(
                    form,
                    XMLHttpRequest.responseJSON.errors,
                    $('#ajax_alert_group'),
                    $('#ajax_alert_list'),
                    'error'
                );
                return false;
            },
            success: function(response) {
                if (response.status === 'success') {
                    var message = {success: [response.message]};
                    insertAlertsArray(
                        form,
                        message,
                        $('#ajax_alert_group'),
                        $('#ajax_alert_list'),
                        'success'
                    );
                    form[0].reset();
                    return true;
                }
            }
        });
    });
});
