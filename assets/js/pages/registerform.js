$(function() {

    $('.input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "yyyy-mm-dd",
        language: "es",
        todayHighlight: true
    });

    let registerForm = $('#registerForm');
    registerForm.submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: 'register',
            method: 'POST',
            data: registerForm.serialize(),

            success: function(response) {
                console.log(response);
                let responseJSON = JSON.parse(response);
                console.log(responseJSON);
               
                if (responseJSON.error == false) {
                    toastr.success(responseJSON.message, 'Realizado', {timeOut: 5000});
                    registerForm.trigger("reset");
                }else if (responseJSON.error == true){
                    toastr.error(responseJSON.message, 'Error', {timeOut: 5000});
                }
                
               
               
            },
            error: function(error) {
                alert('No se pudo completar la operación. #' + error.status + ' ' + error.statusText, '. Intentelo mas tarde.');
            },
            complete: function(data) {
                
            }

            });

    })

});