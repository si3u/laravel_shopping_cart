$(document).ready(function($) {
    Dropzone.options.add_modular_images = {
        maxFilesize: 2,
        acceptedFiles: "image/*",
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            insertErrorArray(
                $('#add_modular_images'),
                XMLHttpRequest.responseJSON.errors,
                $('#group_errors'),
                $('#errors_list')
            );
            callToast.error('Ошибка', 'при добавлении обного с модульных изображений');
            return false;
        },
        success: function (file, response) {
            if (response.status == 'success') {
                callToast.success('Модуль', 'успешно загружен');
            }
        }
    };
});
