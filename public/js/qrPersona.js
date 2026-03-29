let nombrePersona = "";
let idPersona = "";

document.querySelectorAll(".btnQRPersona").forEach((boton) => {
    boton.addEventListener("click", function () {
        idPersona = this.dataset.id;
        nombrePersona = this.dataset.nombre;

        let qrHTML = `<img src="/persona/${idPersona}/qr">`;

        document.getElementById("qrContainerPersona").innerHTML = qrHTML;

        let modal = new bootstrap.Modal(document.getElementById("QRPersona"));
        modal.show();
    });
});

/**
 * DESCARGAR QR
 */

document
    .getElementById("descargarQRPersona")
    .addEventListener("click", function () {
        let img = document.querySelector("#qrContainerPersona img").src;

        let nombreArchivo = `QR_${nombrePersona}_ID${idPersona}.png`;

        let link = document.createElement("a");
        link.href = img;
        link.download = nombreArchivo;
        link.click();
    });
