/**
 * EDITAR PERSONAS
 */
document.querySelectorAll(".btnEditarPersona").forEach((btn) => {
    btn.addEventListener("click", function () {
        let id = this.dataset.id;

        document.getElementById("edit_nombre").value = this.dataset.nombre;
        document.getElementById("edit_apaterno").value = this.dataset.apaterno;
        document.getElementById("edit_amaterno").value = this.dataset.amaterno;
        document.getElementById("edit_tipo").value = this.dataset.tipo;
        document.getElementById("edit_telefono").value = this.dataset.telefono;
        document.getElementById("edit_correo").value = this.dataset.correo;

        document.getElementById("formEditarPersona").action = "/personas/" + id;

        let modal = new bootstrap.Modal(
            document.getElementById("modalEditarPersona"),
        );
        modal.show();
    });
});
/**
 * ELIMINAR PERSONA
 */
let idPersonaEliminar = null;

document.querySelectorAll(".btnEliminarPersona").forEach((btn) => {
    btn.addEventListener("click", function () {
        idPersonaEliminar = this.dataset.id;

        let modal = new bootstrap.Modal(
            document.getElementById("modalEliminarPersona"),
        );
        modal.show();
    });
});

document
    .getElementById("confirmarEliminarPersona")
    .addEventListener("click", function () {
        if (idPersonaEliminar) {
            let form = document.getElementById("formEliminarPersona");
            form.action = "/personas/" + idPersonaEliminar;
            form.submit();
        }
    });
