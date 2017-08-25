$(document).ready(function($) {
    Dropzone.options.add_modular_images = {
        maxFilesize: 2,
        acceptedFiles: "image/*",
        success: function (file, response) {
            console.log(file);
            console.log(response);
            if (response.errors != undefined) {
                insertErrorArray(
                    $('#add_modular_images'),
                    response.errors,
                    $('#group_errors'),
                    $('#errors_list')
                );
            }
            if (response.status == 'success') {
                callToast.success('Модуль', 'успешно загружен');
            }
        }
    };
});
