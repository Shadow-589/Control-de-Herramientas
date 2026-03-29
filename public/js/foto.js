document.getElementById("inputFoto").addEventListener("change", function (e) {
    const file = e.target.files[0];
    const preview = document.getElementById("previewFoto");

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = "block";
        };

        reader.readAsDataURL(file);
    } else {
        preview.style.display = "none";
    }
});
