$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
});
var getParam = {
    'set': function(prmName,val) {
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
    },
    'get': function(key) {
        var s = window.location.search;
        s = s.match(new RegExp(key + '=([^&=]+)'));
        return s ? s[1] : false;
    },
    'clearAll': function() {
        var query = window.location.search.substring(1)
        if(query.length) {
            if(window.history != undefined && window.history.pushState != undefined) {
                window.history.pushState({}, document.title, window.location.pathname);
            }
        }
    }
}

function insertAlertsArray(form, dataAlerts, blockView, insertInto, option) {
    var div = $('#ajax_alert_div');
    switch (option) {
        case 'error':
            div.attr('class', 'alert alert-danger alert-dismissible fade in');
            break;
        case 'success':
            div.attr('class', 'alert alert-success alert-dismissible fade in');
            break;
        default:
    }

    blockView.show();
    var keys = Object.keys(dataAlerts);
    for (var i in keys) {
        for (var j in dataAlerts[keys[i]]) {
            insertInto.append(
                '<p>'+
                dataAlerts[keys[i]][j]+
                '</p>'
            );
        }
    }
    form.click(function () {
        blockView.hide();
        insertInto.html(null);
    })
}
