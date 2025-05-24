<?php
session_start();
require_once '../server/conexion_bd.php';

// Consultas no medicas 
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:rgb(255, 255, 255);
            margin: 0;
            padding: 20px;
        }

        main#main {
            padding: 20px;
        }

        h2 {
            text-align: center;
            color:rgb(134, 28, 183);
            margin-bottom: 25px;
            font-size: 30px;
            letter-spacing: 0.5px;
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
            border: 1px solid #f8d7da;
        }

        table th {
            background-color:rgb(186, 79, 229);
            color: #ffffff;
            font-weight: 600;
            font-size: 16px;
        }

        table tr:nth-child(even) {
            background-color: #fff5f5;
        }

        table tr:nth-child(odd) {
            background-color: #fdeaea;
        }

        table tr:hover {
            background-color:rgb(214, 172, 218);
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
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            color: #fff;
            background-color:rgb(134, 28, 183);
            margin-top: 20px;
            transition: background-color 0.3s ease, box-shadow 0.2s ease;
        }

        .btn:hover {
            background-color:rgb(93, 19, 128);
            box-shadow: 0 2px 6px rgba(105, 40, 226, 0.4);
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
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            width: 50%;
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
        <button class="btn btn-edit" onclick="mostrarDetalles()">Ver Detalles</button>
        <button class="btn" onclick="abrirNuevoPedido()">Agregar pedido</button>
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
                    <td>$" . number_format($fila["Precio_Total"], 2) . "</td>
                </tr>";
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
    $clientes = $conexion->query("SELECT ID_Cliente, Nombre_Cliente, Apellido_Cliente FROM cliente");
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
                        echo "<option value='{$cli['ID_Cliente']}'>#{$cli['ID_Cliente']} - {$cli['Nombre_Cliente']} {$cli['Apellido_Cliente']}</option>";
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

                <button type="button" class="btn" onclick="agregarProducto()">Agregar otro producto</button>
                <br><br>
                <button type="submit" class="btn">Confirmar Pedido</button>
            </form>
        </div>
    </div>
</main>

<script src="js/script.js"></script>
<script src="js/modal_Pedidos.js"></script>
</body>
</html>