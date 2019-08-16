$(function () {
    function checkInput() {
        // var nombre = $("input[name=nombre]");
        // var apellido = $("input[name=apellido]");
        var mail = $("input[name=mail]");
        var username = $("input[name=username]");
        var password = $("input[name=password]");
        // var nacimiento = $("input[name=nacimiento]");
        // var nacionalidad = $("input[name=nacionalidad]");
        // var dni = $("input[name=dni]");
        // var descripcion = $("textarea[name=descripcion]");

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
                // nombre: nombre.val(),
                // apellido: apellido.val(),
                email: mail.val(),
                password: password.val(),
                usuario: username.val(),
                // nacimiento: nacimiento.val(),
                // nacionalidad: nacionalidad.val(),
                // dni: dni.val(),
                // descripcion: descripcion.val()
            }
        }
    }

    $("#finalizar").click(function () {
        var input = checkInput();

        if (input) {
            $.post('../php/registrarse.php', input,
                function (data, status, xhr) {
                    console.log('Request status: ' + status);
                    alert(data);
                }
            );
        }
    })
});