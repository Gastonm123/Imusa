var dropdowns = $(".permissions-dropdown");
var cambios = [];
// configuramos un onclick para cada cuenta

for (let i = 0; i < dropdowns.length; i++) {
    const dropdown = dropdowns[i];
    
    $(dropdown).hover(
    function () {
        var content = dropdown.children[1];
        if (content.className.indexOf("w3-show") == -1) {
            content.className += " w3-show";
        }
    }, function () {
        var content = dropdown.children[1];
        if (content.className.indexOf("w3-show") != -1) {
            content.className = content.className.replace(" w3-show", "");
        }
    });
}

var usuarios = $('.account');

usuarios.each((index, usuario) => {
    usuario.onclick = function(){
        location.href = './sesion.php?view=user&id=' + usuario.id;
    }
});

let dropdownDiv = $('.account .w3-dropdown-content');

dropdownDiv.each((index, div) => {
    div.onclick = function(e) {
        e.stopPropagation();
    }
});