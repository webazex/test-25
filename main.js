$(document).ready(function () {
    $('.form').submit(function (e) {
        e.preventDefault();
        let thisForm = $(this);
        let formDataArray = thisForm.serializeArray();
        $.ajax({
            type: "POST",
            url: "send.php",
            data: formDataArray,
            beforeSend: function () {
                thisForm.find('button[type="submit"]').prop("disabled", true);
                $('.result-area__message').text("Sending. Wait...");
            },
            success: function (response) {
                if(response.error === true){
                    $('.result-area__message').removeClass('success');
                    $('.result-area__message').addClass('error');
                    if('field' in response){
                        $('input[name="'+response.field+'"]').css({'border-bottom': '2px solid red'});
                        setTimeout(function (){
                            $('input[name="'+response.field+'"]').css({'border-bottom': '1px solid blue'});
                        }, 2000);
                    }
                }else{
                    $('.result-area__message').removeClass('error');
                    $('.result-area__message').addClass('success');
                }
                $('.result-area__message').text(response.msg);
            },
            error: function (error) {
                console.error("AJAX Error: ", error);
            },
            complete: function () {
                thisForm.find('button[type="submit"]').prop("disabled", false);
                thisForm[0].reset();
            }
        });
    });
});