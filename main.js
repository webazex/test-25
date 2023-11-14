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
            },
            success: function (response) {
                console.log(response);
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