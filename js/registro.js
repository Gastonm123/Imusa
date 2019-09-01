$(function () {
    function checkInput() {
        var mail = $("input[name=mail]");
        var username = $("input[name=username]");
        var password = $("input[name=password]");

        var temp = [mail, username, password];
        var band = true;
        var classes = 'w3-border-left w3-border-red w3-pale-red invalid-input'
        temp.map(function (el, _, _) {
            if (el.val() == '') {
                el.addClass(classes)
                el.click({this: el}, function(event){
                    event.data.this.removeClass(classes)
                })
                band = false;
            }
        }) 

        var confirm = $("#confirm")
        if (confirm.val() != password.val()) {
            confirm.addClass(classes)
            confirm.click({this: confirm}, function(event){
                event.data.this.removeClass(classes)
            })
            band = false;
        }

        if (!band)
            return false
        else {
            return {
                email: mail.val(),
                password: password.val(),
                username: username.val(),
            }
        }
    }

    $("#finalizar").click(function () {
        var input = checkInput();

        $("#btn-text").css('display', 'none');
        $("#waiting-spinner").css('display', 'inline-block');
        $("#waiting-spinner").addClass('w3-spin');

        if (input) {
            $.post('../php/registrarse.php', input,
                function (data, status, xhr) {
                    location.href = '/php/sesion.php'
                }
            );
        }
    })
});