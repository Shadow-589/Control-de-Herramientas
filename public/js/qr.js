let nombreHerramienta = "";
let idHerramienta = "";

document.querySelectorAll(".btnQR").forEach((boton) => {
    boton.addEventListener("click", function () {
        idHerramienta = this.dataset.id;
        nombreHerramienta = this.dataset.nombre;

        let qrHTML = `<img src="/herramienta/${idHerramienta}/qr">`;

        document.getElementById("qrContainer").innerHTML = qrHTML;

        let modal = new bootstrap.Modal(document.getElementById("modalQR"));
        modal.show();
    });
});

/**
 * Descargar QR
 */

document.getElementById("descargarQR").addEventListener("click", function () {
    let img = document.querySelector("#qrContainer img").src;

    let nombreArchivo = `QR_${nombreHerramienta}_ID${idHerramienta}.png`;

    let link = document.createElement("a");
    link.href = img;
    link.download = nombreArchivo;
    link.click();
});
