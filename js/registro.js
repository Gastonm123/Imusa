$(function () {
    function checkInput() {
        var nombre = $("input[name=nombre]");
        var apellido = $("input[name=apellido]");
        var mail = $("input[name=mail]");
        var username = $("input[name=username]");
        var password = $("input[name=password]");
        var nacimiento = $("input[name=nacimiento]");
        var nacionalidad = $("input[name=nacionalidad]");
        var dni = $("input[name=dni]");
        var descripcion = $("textarea[name=descripcion]");

        var temp = [nombre, apellido, mail, username, password, nacimiento, dni, nacionalidad];
        var band = true;
        temp.map(function (el, _, _) {
            if (el.val() == '') {
                el.css('border', '2px solid red');
                band = false;
            }
        })

        var confirm = $("#confirm")
        if (confirm.val() != password.val()) {
            confirm.css('border', '2px solid red')
            band = false;
        }

        if (!band)
            return false
        else {
            return {
                nombre: nombre.val(),
                apellido: apellido.val(),
                mail: mail.val(),
                username: username.val(),
                password: password.val(),
                nacimiento: nacimiento.val(),
                nacionalidad: nacionalidad.val(),
                dni: dni.val(),
                descripcion: descripcion.val()
            }
        }
    }

    $("#finalizar").click(function () {
        var input = checkInput();

        if (input) {
            $.post(
                '../registro.php',
                input,
                function (data, status, xhr) {
                    console.log('Request status: ' + status);
                    alert(data);
                }
            );
        }
    })
});