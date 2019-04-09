function check(lista){
    /* hace un and a toda la lista dsp de mapear una funcion que devuelve true
     * si el elemento no es un string vacio
     * OSEA devuelve 1 si ningun elemento es un string vacio
     */
    lista.map((a) => (a != ''))
    return lista.reduce((ant, act) => (act && ant));
}

function checkMail(mail){
    var pos1 = mail.indexOf(".com");
    var pos2 = mail.indexOf("@");
    var diff = pos1 - pos2;

    /* para que un mail sea correcto debe respetarse el patron [..]@[..].com
     * OSEA por el funcionamiento de indexOf, ambas posiciones deben ser distintas a
     * -1(estan en el string) y el .com debe estar a mas de 1 de distancia 
     * del @(no estan pegados)
     */
    return (pos1 != -1 && pos2 != -1 && diff > 1);
}

$(function(){
    function same_password(){
        var password = $("input:password[name=password]");
        var confirm = $("#confirm");
    
        return (password.val() == confirm.val() && password.val() != '');
    }

    $("#confirm")
        .keyup(function(){
            if(!same_password())
                $("#confirm").css("background-color", "#ff9999");
            else
                $("#confirm").css("background-color", "#fff");
    });

    $("input:password[name=password]")
        .keyup(function(){
            $("#confirm").keyup();
    });

    $("input:submit")
        .mouseover(function(){
            var camposObligatorios = [
                $("input:text[name=nombre]"),
                $("input:text[name=apellido]"),
                $("input:text[name=mail]"),
                $("input:password[name=password]"),
                $("#dni").val()
            ];

            if (check(camposObligatorios) && same_password())
                $("input:submit").css("background-color", "#9c9");
            else{
                $("input:submit").css("background-color", "#b99");
                $("input:submit").attr("disabled", "disabled");
            }
        })
        .mouseleave(function(){
            $("input:submit").css("background-color", "#999");
            $("input:submit").removeAttr("disabled");
    });

    $("input:text[name=mail]")
        .keyup(function(){
            var email = $("input:text[name=mail]");

            if(!checkMail(email.val()))
                email.css("background-color", "#ff9999");
            else
                email.css("background-color", "#fff");
    });

    $("input:text[name=nombre]")
        .keyup(function(){
            var nombre = $("input:text[name=nombre]");

            if(nombre.val() == '')
                nombre.css("background-color", "#ff9999");
            else
                nombre.css("background-color", "#fff");
    });

    $("input:text[name=apellido]")
        .keyup(function(){
            var apellido = $("input:text[name=apellido]");

            if(apellido.val() == '')
                apellido.css("background-color", "#ff9999");
            else
                apellido.css("background-color", "#fff");
    });

});