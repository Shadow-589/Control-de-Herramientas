document.querySelectorAll(".btnDevolver").forEach((btn) => {
    btn.addEventListener("click", function () {
        const id = this.dataset.id;
        const persona = this.dataset.persona;
        const herramienta = this.dataset.herramienta;
        const cantidad = this.dataset.cantidad;

        document.getElementById("dev_persona").textContent = persona;
        document.getElementById("dev_herramienta").textContent = herramienta;
        document.getElementById("dev_cantidad").textContent = cantidad;

        document.getElementById("formDevolucion").action =
            "/prestamos/completar/" + id;
    });
});
