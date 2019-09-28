function mandar_user_data(id) {
    var data = {};
    var user_data = $('.form-slot');

    // diff entre la data local y la data del servidor
    for (let i = 0; i < user_data.length; i++) {
        let field = user_data[i];
        if (field.value != server_values[field.name] && field.value != '') {
            data[field.name] = field.value;
        }
    }

    data['uid'] = id;
    data['table'] = 'users_info';

    console.log(data);
    
    $("#waiting-spinner").css('display', 'inline-block');
    $("#terminar-text").css('display', 'none');
    $("#waiting-spinner").addClass('w3-spin');
    $.post('update_user_data.php', data,
        function (a,b,c) {
            console.log(a)
            if (a['error']) {
                alert(a['error']);
            } else  {
                location.href = './sesion.php?view=user';
            }
    })
}