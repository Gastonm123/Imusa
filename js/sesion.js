$(function(){
    $("#registroB").click(function() {
        location.href = "./registrarse.html"
    });
    $("#sesionB").click(function() {
        var user = $('#user').val();
        var pass = $('#pass').val();
        
        $.post(
            '../sesion.php',
            {user: user, pass: pass},
            function(data, status, jqXHR){
                console.log('Request status: ' + status);
                alert(data);
            }
        )
    });
});
