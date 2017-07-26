var category = {
    'add': function () {
        var form = $('#form_add');
        var data = form.serializeArray();
        data.push({ name: "description", value: $('#description').summernote('code')});
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: data,
            success: function (response) {
                console.log(response);
                if (response.errors != undefined) {
                    insertErrorArray(
                        $('#form_add'),
                        response.errors,
                        $('#group_errors'),
                        $('#errors_list')
                    );
                    callToast.error('Ошибка', 'при добавлении категории');
                    return false;
                }
            }
        });
    }
}
$(document).ready(function () {
    console.log('ready');
});