$(document).ready(function() {
    $("#phone").mask("+38(999) 999-99-99");

    function bs_input_file() {
    	$(".input-file").before(
    		function() {
    			if ( ! $(this).prev().hasClass('input-ghost') ) {
    				var element = $("<input id='file' type='file' class='input-ghost' style='visibility:hidden; height:0'>");
    				element.attr("name",$(this).attr("name"));
    				element.change(function(){
    					element.next(element).find('input').val((element.val()).split('\\').pop());
    				});
    				$(this).find("button.btn-choose").click(function(){
    					element.click();
    				});
    				$(this).find("button.btn-reset").click(function(){
    					element.val(null);
    					$(this).parents(".input-file").find('input').val('');
    				});
    				$(this).find('input').css("cursor","pointer");
    				$(this).find('input').mousedown(function() {
    					$(this).parents('.input-file').prev().click();
    					return false;
    				});
    				return element;
    			}
    		}
    	);
    }

    bs_input_file();

    $('*#size_radio').change(function() {
        $('#width').val($(this).attr('data-width'));
        $('#height').val($(this).attr('data-height'));
    });
    $('#form_print_create').submit(function() {
        var form = $('#form_print_create');
        var formData = new FormData();
        if ($('#file')[0].files[0] != undefined) {
           formData.append('file', $('#file')[0].files[0]);
        }

        formData.append('width', $('#width').val());
        formData.append('height', $('#height').val());
        formData.append('tel', $('#phone').val());

        $.ajax({
            url: $('#form_action').attr('value'),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest.responseJSON.errors);
                insertAlertsArray(
                    form,
                    XMLHttpRequest.responseJSON.errors,
                    $('#ajax_alert_group'),
                    $('#ajax_alert_list'),
                    'error'
                );
            },
            success: function(response) {
                console.log(response);
            }
        })
        .done(function() {
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

    });
});
