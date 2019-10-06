// FUNCIONES USADAS EN LAS VISTAS DE PERRO
function crear_perro() {
    var values = {};
    var user_data = $('.form-slot');

    for (let i = 0; i < user_data.length; i++) {
        field = user_data[i];
        values[field.name] = field.value;
    }

    var data = {
        'comando': 'create',
        'tabla': 'perros',
        'values': values 
    };

    $.post('api.php', data,
        function(a,b,c) {
            if (a['error']) {
                alert(a['error']);
            } else {
                var id = a['value'];
                location.href = './sesion.php?view=perro&id='+id;
            }
    })
}

function actualizar_perro(id) {
    var values = {};
    var user_data = $('.form-slot');

    for (let i = 0; i < user_data.length; i++) {
        field = user_data[i];
        values[field.name] = field.value;
    }

    var data = {
        'comando': 'update',
        'tabla': 'perros',
        'values': values,
        'restricciones': {'id': id}
    };

    $.post('api.php', data,
        function(a,b,c) {
            if (a['error']) {
                alert(a['error']);
            } else {
                location.href = './sesion.php?view=perro&id='+id;
            }
    })
}

var modo = "normal";
var cambios = [];

function cambiar_modo() {
    if (modo == 'normal') {
        var guardar = document.createElement('button');
        var normal = document.createElement('button');

        guardar.onclick = aplicar_cambios;
        guardar.classList = 'w3-btn w3-blue';
        guardar.innerHTML = '<i id="waiting-spinner" class="fa fa-spinner"></i>\
        <span id="terminar-text">Guardar</span>';

        normal.onclick = cambiar_modo;
        normal.classList = 'w3-btn w3-blue';
        normal.innerHTML = 'Volver';

        var button_pad = document.getElementById('button_pad');
        button_pad.innerHTML = '';
        button_pad.appendChild(guardar);
        button_pad.appendChild(document.createTextNode(' '));
        button_pad.appendChild(normal);

        $('tbody tr').each(function (index, element) {
            // element == this
            var trash = document.createElement('td');

            trash.style = "width:20px; padding:0px"
            trash.innerHTML = "<button class='w3-btn' style='padding:0px'>\
            <i class='fa fa-trash'></button>";
            
            element.onclick = null;
            element.append(trash);
        });

        $('tbody tr button').each(function(a,b){
            b.onclick=function(e){
                e.stopPropagation();

                // conseguir id
                fila = b.parentNode.parentNode;
                id = +fila.children[0].innerHTML;

                // agregar la eliminacion a la lista de cambios
                cambios.push(id);

                // eliminar la fila
                fila.style = "display:none";
            }
        });

        modo = "eliminacion";
    } else {
        location.href = './sesion.php?view=perroTree';
    }
}

function aplicar_cambios() {
    // mandar los cambios a la api
    cambios.forEach(element => {
        var data = {
            'comando': 'delete',
            'tabla': 'perros',
            'restricciones': {
                'id': element
            }
        };
    
        $.post('api.php', data,
            function(a,b,c) {
                if (a['error']) {
                    alert(a['error']);
                } else {
                    console.log('Completado eliminacion de id ' + element);
                }
        })
    });

    $("#waiting-spinner").css('display', 'inline-block');
    $("#terminar-text").css('display', 'none');
    $("#waiting-spinner").addClass('w3-spin');

    // forma de parchear el q las funciones asincronicas no se puedan esperar
    // para llamar a otra funcion
    window.setTimeout(cambiar_modo, 1000);
}
