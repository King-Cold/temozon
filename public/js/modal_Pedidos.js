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


//Agregar un nuevo pedido
function abrirNuevoPedido() {
    document.getElementById("nuevoPedidoModal").style.display = "block";
}

function cerrarNuevoPedido() {
    document.getElementById("nuevoPedidoModal").style.display = "none";
}

function agregarProducto() {
    const container = document.getElementById("productosContainer");
    const item = document.createElement("div");
    item.className = "producto-item";
    item.innerHTML = `
        <label>Producto:</label>
        <select name="productos[]" required>
            ${document.querySelector("select[name='productos[]']").innerHTML}
        </select>
        <label>Cantidad:</label>
        <input type="number" name="cantidades[]" min="1" required>
    `;
    container.appendChild(item);
}

document.getElementById("formNuevoPedido").addEventListener("submit", function(e) {
    e.preventDefault(); 

    const form = e.target;
    const data = new FormData(form);

    fetch("../server/crud_pedidos.php", {
        method: "POST",
        body: data
    })
    .then(response => {
        if (!response.ok) throw new Error("Error al confirmar el pedido.");
        return response.text();
    })
    .then(msg => {
        alert(msg);
        form.reset(); // Limpia el formulario
        cerrarNuevoPedido(); // Cierra el modal
        location.reload(); // Recarga la página
    })
    .catch(error => {
        alert("Hubo un problema: " + error.message);
    });
});