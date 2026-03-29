function editarUsuario(id, nombre, ap, am, tel, correo, tipo, foto) {
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_nombre").value = nombre;
    document.getElementById("edit_ap").value = ap;
    document.getElementById("edit_am").value = am;
    document.getElementById("edit_tel").value = tel;
    document.getElementById("edit_correo").value = correo;
    document.getElementById("edit_tipo").value = tipo;

    document.getElementById("formEditar").action = `/usuarios/${id}`;

    // Mostrar foto actual
    let preview = document.getElementById("previewEditar");

    if (foto) {
        preview.src = `/storage/${foto}`;
    } else {
        preview.src = "";
    }
}
/**
 * Para ver la foto en el modal
 */
document.getElementById("edit_foto").addEventListener("change", function (e) {
    const file = e.target.files[0];
    const preview = document.getElementById("previewEditar");

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
/**
 * Eliminar
 */
let usuarioIdEliminar = null;

function abrirModalEliminar(id) {
    usuarioIdEliminar = id;
}
document
    .getElementById("confirmarEliminar")
    .addEventListener("click", function () {
        if (usuarioIdEliminar) {
            let token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");

            let form = document.createElement("form");
            form.method = "POST";
            form.action = `/usuarios/${usuarioIdEliminar}`;

            let csrf = document.createElement("input");
            csrf.type = "hidden";
            csrf.name = "_token";
            csrf.value = token;

            let method = document.createElement("input");
            method.type = "hidden";
            method.name = "_method";
            method.value = "DELETE";

            form.appendChild(csrf);
            form.appendChild(method);

            document.body.appendChild(form);
            form.submit();
        }
    });

