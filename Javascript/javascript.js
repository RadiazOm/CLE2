window.addEventListener('load', init);
let menu;
let button

function init() {
    button = document.getElementById('menu-button')
    button.addEventListener('click', buttonClickHandler)
    menu = document.getElementById('mobile-menu')
}


function buttonClickHandler() {
    if (menu.className === 'show') {
        menu.classList.remove('show')
    } else {
        menu.classList.add('show')
    }
}