let scanner;

function abrirScanner() {
    const modal = new bootstrap.Modal(document.getElementById("modalQR"));
    modal.show();

    scanner = new Html5Qrcode("reader");

    scanner.start(
        { facingMode: "environment" },
        {
            fps: 10,
            qrbox: 250,
        },
        onScanSuccess,
    );
}

function onScanSuccess(decodedText) {
    if (decodedText.startsWith("PERSONA-")) {
        let id = decodedText.split("-")[1];

        document.querySelector("select[name='id_persona']").value = id;
    }

    if (decodedText.startsWith("HERRAMIENTA-")) {
        let id = decodedText.split("-")[1];

        document.querySelector("select[name='id_herramienta']").value = id;
    }

    cerrarScanner();
}

function cerrarScanner() {
    if (scanner) {
        scanner.stop().then(() => {
            document.getElementById("reader").innerHTML = "";
        });
    }

    const modal = bootstrap.Modal.getInstance(
        document.getElementById("modalQR"),
    );
    modal.hide();
}
