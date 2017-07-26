var csrf_token = $('input[name="_token"]').val();
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