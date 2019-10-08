function actualizar_mensaje(id) {
    var values = {};

    $('.form-slot').each(function (index, field) {
        // element == this
        values[field.name] = field.value;
    });

    var data = {
        'comando': 'update',
        'tabla': 'mensajes',
        'values': values,
        'restricciones': {'id': id}
    };

    $.post('api.php', data,
        function(a,b,c) {
            if (a['error']) {
                alert(a['error']);
            } else {
                if (location.href.indexOf('&id') != -1) {
                    location.href = './sesion.php?view=mensaje&id='+a['value'];
                } else {                    
                    location.href = './sesion.php?view=mensajeEdit';
                }
            }
    });
}

function crear_mensaje() {
    var values = {};

    $("#waiting-spinner").css('display', 'inline-block');
    $("#terminar-text").css('display', 'none');
    $("#waiting-spinner").addClass('w3-spin');

    $('.form-slot').each(function (index, field) {
        // element == this
        values[field.name] = field.value;
    });

    var data = {
        'comando': 'create',
        'tabla': 'mensajes',
        'values': values 
    };

    $.post('api.php', data,
        function(a,b,c) {
            if (a['error']) {
                alert(a['error']);
            } else {
                let newLocation;

                if (location.href.indexOf('&id') != -1) {
                    newLocation = './sesion.php?view=mensaje&id='+a['value'];
                } else {                    
                    newLocation = './sesion.php?view=mensajeEdit';
                }
                
                $("#btn-container").removeClass('w3-blue');
                $("#btn-container").addClass('w3-green');

                window.setTimeout(function(){
                    location.href = newLocation;
                }, 400);
            }
    });
}