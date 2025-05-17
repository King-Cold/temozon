let idDetalleSeleccionado = null;
let filaSeleccionada = null;

function seleccionarFila(fila, idDetalle) {
    if (filaSeleccionada) {
        filaSeleccionada.classList.remove('seleccionado');
    }
    fila.classList.add('seleccionado');
    filaSeleccionada = fila;
    idDetalleSeleccionado = idDetalle;
}

function mostrarDetalles() {
    if (!idDetalleSeleccionado || idDetalleSeleccionado === 'null' || idDetalleSeleccionado === '') {
        alert("Primero selecciona una fila con un detalle válido.");
        return;
    }

    fetch(`../server/detalles_pedido.php?id=${idDetalleSeleccionado}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('detalleContenido').innerHTML = data;
            document.getElementById('detalleModal').style.display = "block";
        })
        .catch(error => {
            document.getElementById('detalleContenido').innerHTML = "Error al cargar detalles.";
        });
}

function cerrarModal() {
    document.getElementById('detalleModal').style.display = "none";
}