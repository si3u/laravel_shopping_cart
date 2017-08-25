$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
});
//получаем get параметр
function $_GET(key) {
    var s = window.location.search;
    s = s.match(new RegExp(key + '=([^&=]+)'));
    return s ? s[1] : false;
}
//добавляет get параметр в адресную строку
function setAttr(prmName,val){
    var res = '';
    var d = location.href.split("#")[0].split("?");
    var base = d[0];
    var query = d[1];
    if(query) {
        var params = query.split("&");
        for(var i = 0; i < params.length; i++) {
            var keyval = params[i].split("=");
            if(keyval[0] != prmName) {
                res += params[i] + '&';
            }
        }
    }
    res += prmName + '=' + val;
    window.history.pushState(null, null, base + '?' + res);
    return false;
}
//очищаем все параметры get
function cleanGetParam() {
    var query = window.location.search.substring(1)
    if(query.length) {
        if(window.history != undefined && window.history.pushState != undefined) {
            window.history.pushState({}, document.title, window.location.pathname);
        }
    }
}
var callToast = {
    'error': function (textHead, textError) {
        $.toast({
            heading: textHead,
            text:textError,
            position:"top-right",
            loaderBg:"#bf441d",
            icon:"error",
            hideAfter:3e3,stack:1
        });
    },
    'success': function (textHead, textSuccess) {
        $.toast({
            heading:textHead,
            text:textSuccess,
            position:"top-right",
            loaderBg:"#5ba035",
            icon:"success",
            hideAfter:3e3,stack:1
        });
    },
    'info': function (textHead, textSuccess) {
        $.toast({
            heading:textHead,
            text:textSuccess,
            position:"top-right",
            loaderBg:"#3767a0",
            icon:"info",
            hideAfter:3e3,stack:1
        });
    }
};
var contacts = {
    'get': function () {
        var form = $('#form_contacts');
        $.ajax({
            method: form.attr('method'),
            url: '/admin/contacts/get',
            dataType: 'JSON',
            success: function (response) {
                form[0].reset();
                $('#form_contacts #email').val(response.email);
                $('#form_contacts #tel').val(response.tel);
                $('textarea#address').val(response.addresses);
                $('#modal_contacts').modal('show');
            }
        });
    },
    'update': function () {
        var form = $('#form_contacts');
        $.ajax({
            method: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'JSON',
            success: function (response) {
                if (response.errors != undefined) {
                    insertErrorArray(form, response.errors, $('#group_errors'), $('#errors_list'));
                    return false;
                }
                if (response.status == 'success') {
                    callToast.success('Контактная информация', 'успешно изменена');
                    return true;
                }
            }
        });
    }
};
function insertErrorArray(form, errorData, blockView, insertInto) {
    blockView.show();
    var keys = Object.keys(errorData);
    for (var i in keys) {
        for (var j in errorData[keys[i]]) {
            insertInto.append(
                '<p>'+
                errorData[keys[i]][j]+
                '</p>'
            );
        }
    }
    form.click(function () {
        blockView.hide();
        insertInto.html(null);
    })
}
var local=$.ajax({
    method: 'POST',
    url: '/admin/active_localization/get_active',
    dataType: 'JSON',
    async: false
}).responseJSON;
var activeLocalization = {
    'get': function () {
        $.ajax({
            method: 'POST',
            url: '/admin/active_localization/get',
            dataType: 'JSON',
            success: function (result) {
                console.log(result);
                var form = $('#form_update_localization');
                form.html(null);
                for (var i in result) {
                    if (result[i].status == true) {
                        form.append('<div class="checkbox checkbox-primary">' +
                            '            <input id="'+result[i].lang+'" name="'+result[i].lang+'" type="checkbox" checked>' +
                            '            <label for="checkbox2">'
                                            +result[i].name+
                            '            </label>' +
                            '        </div>');
                    }
                    else {
                        form.append('<div class="checkbox checkbox-primary">' +
                            '            <input id="'+result[i].lang+'" name="'+result[i].lang+'" type="checkbox">' +
                            '            <label for="checkbox2">'
                                            +result[i].name+
                            '            </label>' +
                            '        </div>')
                    }
                }
                $('#modal_setting_active_localization').modal('show');
            }
        });
    },
    'update': function () {
        var form = $('#form_update_localization');
        $.ajax({
            method: 'POST',
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'JSON',
            success: function (result) {
                if (result.error != undefined) {
                    callToast.error('Ошибка', result.error);
                    return false;
                }
                if (result.status == 'success') {
                    local=$.ajax({
                        method: 'POST',
                        url: '/admin/active_localization/get',
                        dataType: 'JSON',
                        async: false
                    }).responseJSON;
                    callToast.success('Активные локализации', 'Успешно изменены');
                    return true;
                }
                callToast.error('Ошибка', 'при изменении данных');
                return false;
            }
        });
    }
};

$(document).ready(function () {
    console.log('ready');
    $('*.editor').css('height', '350');
    var config = {
        autosubmit: false,
        images : {
            editing : {
                enabled : false
            },
            upload : {
                handler: function (data, success, failure) {
                    var formData = new FormData();
                    formData.append('image', data.blob());
                    $.ajax({
                        method: "POST",
                        url: '/admin/upload_file/',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            success(response);
                        }
                    });
                }
            }
        },
        codeview: {
            enabled : false
        },
        basePath : '/assets/admin/js/textboxio/'
    };
    var editor = textboxio.replaceAll('.editor', config);
});
