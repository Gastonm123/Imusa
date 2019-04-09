function configure(){
}

$(function(){
    $("#submit")
        .mouseover(function(){
            var user = $("#user");
            var pass = $("#pass");
            var acceso = $("input:radio[name=acceso]:checked");

            if (user.val() != "" && pass.val() != "" && acceso.val() != undefined)
                $("#submit").css("background-color", "#9c9");
            else{
                $("#submit").css("background-color", "#b99");
                $("#submit").attr("disabled", "disabled");
            }
        })
        .mouseout(function(){
            $("#submit").css("background-color", "#999");
            $("#submit").removeAttr("disabled");
    });

    $("#registrarse")
        .click(function(){
            window.location.replace("./registrarse.html");
    });
});
