// FUNCIONES USADAS EN LAS VISTAS DE USER
function mandar_user_data(id) {
    var values = {};
    var user_data = $('.form-slot');

    for (let i = 0; i < user_data.length; i++) {
        field = user_data[i];
        values[field.name] = field.value;
    }

    var data = {
        'comando': 'update',
        'tabla': 'users_info',
        'values': values,
        'restricciones': {'uid':id}
    };

    $("#waiting-spinner").css('display', 'inline-block');
    $("#terminar-text").css('display', 'none');
    $("#waiting-spinner").addClass('w3-spin');
    $.post('api.php', data,
        function (a,b,c) {
            if (a['error']) {
                alert(a['error']);
            } else {
                console.log(a['value']);
            }

            location.href = './sesion.php?view=user';
        })
}

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

// FUNCIONES USADAS EN EL DROPDOWN DE USUARIO
function setear(usuario, permiso, rol) {
    var accounts = $('.account');
    var account_id = +accounts[usuario].children[0].innerHTML;

    var posicion_permiso = rol;

    var tr_permiso = accounts[usuario].children[posicion_permiso];

    tr_permiso.children[0].innerHTML = permiso;

    cambios[account_id] = permiso; 

    //mostrar el boton de guardar
    var guardar_btn = $(".guardar-btn")[0];
    if (guardar_btn.className.indexOf('w3-hide') != -1) {
        guardar_btn.className = guardar_btn.className.replace("w3-hide", "");
    }
}

function guardar() {
    cambios.forEach((element, index) => {
        var data = {
            'comando': 'update',
            'tabla': 'users_info',
            'values': {'rol': element},
            'restricciones': {'uid': index}
        };

        $.post('api.php', data, function(a,b,c){
            if (a['error']) {
                alert(a);
            } else {
                console.log(a['value']);
            }
        })
    });

    cambios = [];

    var guardar_btn = $(".guardar-btn")[0];
    guardar_btn.className = 'w3-hide' + guardar_btn.className; 
}