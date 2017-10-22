var review = {
    'delete': function (id) {
        $('#href_delete').attr('href', '/admin/wallpaper/review/delete/'+id);
        $('#modal_wallpaper_review_delete').modal('show');
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
            url: '/admin/wallpaper/review/update',
            data: form.serialize(),
            dataType: 'JSON',
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                insertErrorArray(form, XMLHttpRequest.responseJSON.errors, $('#group_errors'), $('#errors_list'));
                callToast.error('Ошибка', 'при обновлении данных Отзыва');
                return false;
            },
            success: function (response) {
                if (response.status == 'success') {
                    callToast.success('Данные', 'успешно обновлены');
                    return true;
                }
                callToast.error('Ошибка', 'что-то пошло не так');
            }
        });
    });
});
