$(function () {
    window.onscroll = function () { changeSticky() };

    var navbar = document.getElementById('navbar');

    var sticky = navbar.offsetTop;

    function changeSticky() {
        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky");
        } else {
            navbar.classList.remove("sticky")
        }
    }

    var re = new RegExp(/[A-Za-z]+/)
    var loc_splited = location.href.split('/')
    var page = loc_splited[loc_splited.length - 1]

    for (let i = 0; i < navbar.children.length; i++){
        let tab = navbar.children[i]

        if (tab.innerHTML) {
            let tab_content = re.exec(tab.innerHTML)[0]
            let page_name = re.exec(page)[0]

            if (tab_content == 'INICIO') {
                tab_content = 'index'
            }

            if (tab_content.toLowerCase() == page_name) {
                tab.classList.add('w3-deep-orange')
            }
        }
    }
});