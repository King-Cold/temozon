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
    document.querySelectorAll("select[name='productos[]']").forEach(select => {
        select.addEventListener("change", function () {
            actualizarMaximoCantidad(this);
        });
        actualizarMaximoCantidad(select);
    });

    document.querySelectorAll("input[name='cantidades[]']").forEach(inputCantidad => {
        inputCantidad.addEventListener("input", function () {
            const max = inputCantidad.max ? parseInt(inputCantidad.max) : null;
            const val = inputCantidad.value ? parseInt(inputCantidad.value) : 0;
            if (max !== null && val > max) {
                inputCantidad.value = max;
            } else if (val < 1) {
                inputCantidad.value = 1;
            }
        });
    });
}


function cerrarNuevoPedido() {
    document.getElementById("nuevoPedidoModal").style.display = "none";
}

function agregarProducto() {
    const container = document.getElementById("productosContainer");

    const item = document.createElement("div");
    item.className = "producto-item";
    item.style.marginBottom = "10px";

    item.innerHTML = `
        <label>Producto:</label>
        <select name="productos[]" required>
            ${document.querySelector("select[name='productos[]']").innerHTML}
        </select>
        <label>Cantidad:</label>
        <input type="number" name="cantidades[]" min="1" required>
    `;

    const selectProducto = item.querySelector("select[name='productos[]']");
    const inputCantidad = item.querySelector("input[name='cantidades[]']");

    // Cuando cambie el producto, se actualiza el select o si no truena el invento
    selectProducto.addEventListener("change", function () {
        actualizarMaximoCantidad(this);
    });

    // Limitar la cantidad al máximo permitido mientras el usuario escribe
    inputCantidad.addEventListener("input", function () {
        const max = inputCantidad.max ? parseInt(inputCantidad.max) : null;
        const val = inputCantidad.value ? parseInt(inputCantidad.value) : 0;
        if (max !== null && val > max) {
            inputCantidad.value = max;
        } else if (val < 1) {
            inputCantidad.value = 1; 
        }
    });

    // Establece el máximo inicial si hay uno seleccionado
    actualizarMaximoCantidad(selectProducto);

    const btnEliminar = document.createElement("button");
    btnEliminar.type = "button";
    btnEliminar.textContent = "Eliminar";
    btnEliminar.className = "btn";
    btnEliminar.style.backgroundColor = "rgb(200, 50, 50)";
    btnEliminar.style.marginLeft = "10px";
    btnEliminar.onclick = () => {
        container.removeChild(item);
    };

    item.appendChild(btnEliminar);
    container.appendChild(item);
}



function actualizarMaximoCantidad(selectElement) {
    const cantidadInput = selectElement.closest('.producto-item').querySelector("input[name='cantidades[]']");
    const opcionSeleccionada = selectElement.options[selectElement.selectedIndex];
    const max = opcionSeleccionada.getAttribute("data-disponible");

    if (max) {
        cantidadInput.max = max;
        if (parseInt(cantidadInput.value) > parseInt(max)) {
            cantidadInput.value = max;
        }
    } else {
        cantidadInput.removeAttribute("max");
    }
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