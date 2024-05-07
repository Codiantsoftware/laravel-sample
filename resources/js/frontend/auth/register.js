
/*for validate second step of user signup and save user*/
$("#signupBtn").on('click', (function (e) {
    e.preventDefault();
    let frm = $('#signupForm1');
    let btn = $('#signupBtn');
    let btnName = btn.text();
    let url = route('user.signup');

    if (frm.valid()) {
        $.ajax({
            url: url,
            type: "POST",
            data: $('#signupForm1').serialize(),
            beforeSend: function() {
                showButtonLoader(btn, btnName, true);

            },
            success: function(response) {

                if (response.success) {
                    successToaster(response.message);
                }
            },
            error: function(errorResponse) {
                handleError(errorResponse);

            },
            complete: function() {
                showButtonLoader(btn, btnName, false);
            }
        });
    }
}));

