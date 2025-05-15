document.getElementById("buscador").addEventListener("keyup", function () {
    const filtro = this.value.toLowerCase();
    const filas = document.querySelectorAll("table tr");

    filas.forEach((fila, index) => {
        if (index === 0) return;

        const nombreProducto = fila.cells[1]?.textContent.toLowerCase() || "";
        if (nombreProducto.includes(filtro)) {
            fila.style.display = "";
        } else {
            fila.style.display = "none";
        }
    });
});