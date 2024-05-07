$(function() {
    document.cookie = "time_zone = " + moment.tz.guess();
});

$(document).on('click', '#signInBtn', function (e) {
    e.preventDefault();
    var form = $('#frontend-login-form')
    if(form.valid()) {
        elementEnableDisabled('#signInBtn',true);
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function (response)
            {
                if(response.success){
                    successToaster(response.message);
                    setTimeout(function () {
                        window.location.href = response.redirectionUrl;
                    }, 1000);
                }else{
                    errorToaster(response.message,'Login');
                }
            }, error: function (err) {

                handleError(err);
            }, complete : function (){
                elementEnableDisabled('#signInBtn',false);
            }
        });
    }
});
