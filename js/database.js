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

            if (location.href.indexOf('&id') != -1) {
                location.href = './sesion.php?view=user&id=' + id;
            } else {
                location.href = './sesion.php?view=user';
            }
    })
}

// FUNCIONES USADAS EN EL DROPDOWN DE USUARIO
function setear(usuario, permiso, rol) {
    var accounts = $('.account');
    var account_id = +accounts[usuario].children[0].innerHTML;

    var tr_permiso = accounts[usuario].children[rol];

    tr_permiso.children[0].innerHTML = permiso;

    cambios[account_id] = permiso; 

    //mostrar el boton de guardar
    $(".guardar-btn:first-child").css('visibility', 'visible');
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

    $(".guardar-btn:first-child").css('visibility', 'hidden');
}