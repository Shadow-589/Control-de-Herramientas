/**
 * INICIA EL MODAL EDITAR
 */
document.addEventListener("DOMContentLoaded", function () {
    const botonesEditar = document.querySelectorAll(".btnEditar");
    const formEditar = document.getElementById("formEditar");

    botonesEditar.forEach((boton) => {
        boton.addEventListener("click", function () {
            let id = this.dataset.id;

            // Llenar inputs
            document.getElementById("edit_nombre").value = this.dataset.nombre;
            document.getElementById("edit_tipo").value = this.dataset.tipo;
            document.getElementById("edit_cantidad").value =
                this.dataset.cantidad;
            document.getElementById("edit_estado").value = this.dataset.estado;
            document.getElementById("edit_datos").value = this.dataset.datos;

            // Cambiar action dinámicamente
            formEditar.action = `/herramientas/${id}`;

            // Mostrar modal
            let modal = new bootstrap.Modal(
                document.getElementById("modalEditar"),
            );
            modal.show();
        });
    });
});
/**
 * INICIO DEL JS DE MODAL ELIMINAR
 */
// -------- ELIMINAR --------

let formAEliminar = null;

document.querySelectorAll(".btnEliminar").forEach((boton) => {
    boton.addEventListener("click", function () {
        formAEliminar = this.closest("form");

        let modal = new bootstrap.Modal(
            document.getElementById("modalEliminar"),
        );
        modal.show();
    });
});

document
    .getElementById("confirmarEliminar")
    .addEventListener("click", function () {
        if (formAEliminar) {
            formAEliminar.submit();
        }
    });
