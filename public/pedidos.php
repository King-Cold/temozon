<?php
session_start();
require_once '../server/conexion_bd.php';

//Actualizar el estado de los envíos
$actualizarEnvios = "
    UPDATE envios e
    JOIN (
        SELECT ID_Envio, COUNT(*) AS total_pedidos
        FROM pedidos
        GROUP BY ID_Envio
    ) p ON e.ID_Envio = p.ID_Envio
    SET e.Estado_Envio = 'En tránsito'
    WHERE p.total_pedidos >= e.Maximo_Articulos
    AND e.Estado_Envio != 'En tránsito';
";
$conexion->query($actualizarEnvios);
$sql = "SELECT 
            pedidos.ID_Pedido,
            pedidos.ID_Envio,
            envios.Estado_Envio,
            pedidos.ID_Cliente,
            cliente.Nombre_Cliente,
            cliente.Direc_Cliente,
            pedidos.Fecha,
            pedidos.Precio_Total
        FROM pedidos
        INNER JOIN cliente ON pedidos.ID_Cliente = cliente.ID_Cliente
        INNER JOIN envios ON pedidos.ID_Envio = envios.ID_Envio
        ORDER BY pedidos.ID_Pedido ASC";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
       body {
    font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f9f9f9;
    margin: 0;
    padding: 20px;
    color: #333;
}

        main#main {
            padding: 20px;
        }

h2 {
    text-align: center;
    color:rgba(255, 123, 0, 0.69);
    margin-bottom: 25px;
    font-size: 34px;
    font-weight: 700;
    letter-spacing: 0.7px;
}
        table {
            width: 95%;
            margin: auto;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(183, 28, 28, 0.2);
            border-radius: 10px;
            overflow: hidden;
        }

        table th, table td {
            padding: 14px 18px;
            text-align: center;
             border: 1px solid rgb(219, 215, 243);
        }

        table th {
            background-color: #FF9533;
            color: #ffffff;
            font-weight: 600;
            font-size: 16px;
        }

        table tr:nth-child(even) {
        background-color: #f8f5fc;
        }

        table tr:nth-child(odd) {
        background-color: #ede7f6;
        }

        table tr:hover {
        background-color:rgba(141, 79, 255, 0.34);
            transition: background-color 0.3s ease;
        }

        table td {
            color: #333;
            font-size: 14.5px;
        }

        table tr.seleccionado {
            background-color:rgb(214, 172, 218) !important;
            font-weight: bold;
        }

  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 15px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
}

/* Botón general */
.btn-detail {
    background: linear-gradient(135deg, #8e24aa, #6a1b9a);
    color: #fff;
}

.btn-detail:hover {
    background: linear-gradient(135deg, #6a1b9a, #4a148c);
    transform: translateY(-1px);
}

/* Botón agregar */
.btn-add {
    background:rgb(11, 177, 52);
    color: #fff;
}

.btn-add:hover {
    background:rgb(0, 116, 39);
    transform: translateY(-1px);
}

/* Botón eliminar */
.btn-delete {
    background: linear-gradient(135deg, #d32f2f, #b71c1c);
    color: #fff;
    padding: 8px 16px;
    font-size: 14px;
    border-radius: 6px;
}

.btn-delete:hover {
    background: linear-gradient(135deg, #b71c1c, #7f0000);
    transform: translateY(-1px);
}

/* Iconos en botones */
.btn img {
    width: 18px;
    height: 18px;
    margin-right: 8px;
    vertical-align: middle;
}

        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

 .modal-content {
    background-color: #fff;
    margin: 60px auto;
    padding: 30px 25px;
    border-radius: 12px;
    width: 60%;
    max-width: 700px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    animation: fadeIn 0.4s ease;
}

.modal-content h2 {
    color: #FF7A00;
    margin-bottom: 20px;
    text-align: center;
}

.modal-content label {
    display: block;
    margin: 12px 0 6px;
    font-weight: 600;
}

.modal-content select, 
.modal-content input[type="number"] {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
    transition: border-color 0.3s;
    margin-bottom: 10px;
}

.modal-content select:focus, 
.modal-content input[type="number"]:focus {
    border-color: #8e24aa;
    outline: none;
}

.producto-item {
    background: #f8f5fc;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
}

.producto-item label {
    margin-top: 8px;
}

.modal-content .btn {
    width: auto;
    display: inline-block;
    margin-top: 10px;
    font-weight: bold;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

        .close {
            color: #aaa;
            float: right;
            font-size: 32px; 
            font-weight: bold; 
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .close:hover {
            color: #e53935; 
        }

    </style>
</head>
<body>

<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

<main id="main">
    <h2>PEDIDOS</h2>

    <div style="text-align: center; margin: 20px;">
    <button class="btn btn-detail" onclick="mostrarDetalles()">Ver Detalles</button>
    <button class="btn btn-add" onclick="abrirNuevoPedido()">Agregar pedido</button>
</div>

    <table>
        <tr>
            <th>ID Pedido</th>
            <th>ID Envío</th>
            <th>Estado del Envío</th>
            <th>ID Cliente</th>
            <th>Nombre del Cliente</th>
            <th>Dirección del Cliente</th>
            <th>Fecha</th>
            <th>Precio Total</th>
            <?php if (tienePermiso(['Encargado de Bodega'])): ?>
            <th>Acciones</th>
            <?php endif; ?>
        </tr>
        <?php
        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr onclick=\"seleccionarFila(this, '" . htmlspecialchars($fila["ID_Pedido"] ?? '') . "')\">
                    <td>" . htmlspecialchars($fila["ID_Pedido"]) . "</td>
                    <td>" . htmlspecialchars($fila["ID_Envio"]) . "</td>
                    <td>" . htmlspecialchars($fila["Estado_Envio"]) . "</td>
                    <td>" . htmlspecialchars($fila["ID_Cliente"]) . "</td>
                    <td>" . htmlspecialchars($fila["Nombre_Cliente"]) . "</td>
                    <td>" . htmlspecialchars($fila["Direc_Cliente"]) . "</td>
                    <td>" . htmlspecialchars($fila["Fecha"]) . "</td>
                    <td>$" . number_format($fila["Precio_Total"], 2) . "</td>";

                if (tienePermiso(['Encargado de Bodega'])) {
                    echo "<td>";
                    if ($fila["Estado_Envio"] !== "En tránsito") {
                        echo "
                        <form method='POST' action='../server/crud_pedidos.php?id=" . $fila["ID_Pedido"] . "' style='display:inline;' onsubmit=\"return confirm('¿Seguro que deseas eliminar el pedido #" . $fila["ID_Pedido"] . "?');\">
                            <input type='hidden' name='accion' value='eliminar'>
                            <input type='hidden' name='id_pedido' value='" . $fila["ID_Pedido"] . "'>
                            <button type='submit' class='btn btn-delete'>Dar de baja</button>
                        </form>";
                    } else {
                        echo "<span style='color: gray; font-style: italic;'>No disponible</span>";
                    }
                    echo "</td>";
                }
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No hay registros de pedidos.</td></tr>";
        }
        ?>
    </table>
    <div id="detalleModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <div id="detalleContenido">Cargando detalles...</div>
        </div>
    </div>
    
    <?php
    $envios = $conexion->query("SELECT ID_Envio, Estado_Envio FROM envios WHERE Estado_Envio = 'Pendiente'");
    $clientes = $conexion->query("SELECT ID_Cliente, Nombre_Cliente FROM cliente");
    $productos = $conexion->query("SELECT ID_Prod, Nomb_Prod, Cant_Disp_Prod, Prec_Vent FROM productos WHERE Prod_Estatus = 1");
    ?>

    <div id="nuevoPedidoModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarNuevoPedido()">&times;</span>
            <h2>Nuevo Pedido</h2>
<form id="formNuevoPedido">
    <label for="ID_Envio">Envío:</label>
    <select name="ID_Envio" required>
        <option value="">Seleccione un envío</option>
        <?php while ($env = $envios->fetch_assoc()) {
            echo "<option value='{$env['ID_Envio']}'>#{$env['ID_Envio']} - {$env['Estado_Envio']}</option>";
        } ?>
    </select>

    <label for="ID_Cliente">Cliente:</label>
    <select name="ID_Cliente" required>
        <option value="">Seleccione un cliente</option>
        <?php while ($cli = $clientes->fetch_assoc()) {
            echo "<option value='{$cli['ID_Cliente']}'>#{$cli['ID_Cliente']}</option>";
        } ?>
    </select>

    <div id="productosContainer">
        <div class="producto-item">
            <label>Producto:</label>
            <select name="productos[]" required>
                <option value="">Seleccione un producto</option>
                <?php
                $productos->data_seek(0);
                while ($prod = $productos->fetch_assoc()) {
                    echo "<option value='{$prod['ID_Prod']}' data-precio='{$prod['Prec_Vent']}' data-disponible='{$prod['Cant_Disp_Prod']}'>{$prod['Nomb_Prod']} - {$prod['Cant_Disp_Prod']} disponibles</option>";
                }
                ?>
            </select>

            <label>Cantidad:</label>
            <input type="number" name="cantidades[]" min="1" required>
        </div>
    </div>

<button type="button" class="btn btn-add" onclick="agregarProducto()">
    <img src="../Icons/agregar.svg" alt="Agregar" style="width: 20px; height: 20px; vertical-align: middle; margin-right: 5px;">
    Agregar otro producto
</button>

<button type="submit" class="btn btn-detail">
    <img src="../Icons/confirmar.svg" alt="Confirmar" style="width: 20px; height: 20px; vertical-align: middle; margin-right: 5px;">
    Confirmar Pedido
</button>
</form>
        </div>
    </div>
</main>

<script src="js/script.js"></script>
<script src="js/modal_Pedidos.js"></script>
</body>
</html>