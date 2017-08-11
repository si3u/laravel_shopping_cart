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
    url: '/admin/active_localization/get',
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
}