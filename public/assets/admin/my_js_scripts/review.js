var review = {
    'delete': function (id) {
        $('#href_delete').attr('href', '/admin/review/delete/'+id);
        $('#modal_review_delete').modal('show');
    }
};
$(document).ready(function () {
    var score = 0;
    var nowRating = $('input[name=now_rating]').val();
    if ($.isNumeric(nowRating)) {
        score = nowRating;
    }
    $("#rating").raty({
        score: score,
        starOff:"fa fa-star-o text-muted",
        starOn:"fa fa-star text-danger"
    });

    $('#form_work_on').submit(function () {
        var form = $('#form_work_on');
        $.ajax({
            method: "POST",
            url: '/admin/review/update',
            data: form.serialize(),
            dataType: 'JSON',
            success: function (response) {
                if (response.errors != null) {
                    insertErrorArray(form, response.errors, $('#group_errors'), $('#errors_list'));
                    return false;
                }
                if (response.status == 'success') {
                    callToast.success('Данные', 'успешно обновлены');
                    return true;
                }
                callToast.error('Ошибка', 'что-то пошло не так');
            }
        });
    });
});