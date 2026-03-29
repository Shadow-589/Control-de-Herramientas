const menu = document.getElementById("userMenu");
const btn = document.querySelector(".user-btn");

function toggleUserMenu() {
    menu.classList.toggle("show");
}

// cerrar al hacer click fuera
document.addEventListener("click", function (e) {
    if (!menu.contains(e.target) && !btn.contains(e.target)) {
        menu.classList.remove("show");
    }
});
/**
 * JS CAMPANITA
 */
function toggleNotiMenu() {
    const menu = document.getElementById("notiMenu");
    menu.classList.toggle("d-none");
}

// cerrar al hacer click afuera
document.addEventListener("click", function (e) {
    const menu = document.getElementById("notiMenu");
    const btn = document.querySelector(".bi-bell");

    if (!menu.contains(e.target) && !btn.contains(e.target)) {
        menu.classList.add("d-none");
    }
});
