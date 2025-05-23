<?php
require_once '../server/conexion_bd.php';

if (!isset($_GET['id'])) {
    echo "ID de detalle no proporcionado.";
    exit;
}

$id = intval($_GET['id']);

$sql = "SELECT dp.ID_Detalle, dp.ID_Prod, p.Nomb_Prod, p.Prec_Vent, dp.Cantidad 
        FROM detalle_pedido dp
        LEFT JOIN productos p ON dp.ID_Prod = p.ID_Prod
        WHERE dp.ID_Pedido = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado && $resultado->num_rows > 0) {
    echo '
    <style>
        .tabla-formal {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            margin-top: 10px;
        }

        .tabla-formal table {
            border-collapse: collapse;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            border-radius: 8px;
            width: 100%;
            margin: 0 auto;
        }

        .tabla-formal th {
            background-color:rgb(186, 79, 229);
            color: #fff;
            padding: 12px 15px;
            text-align: center;
            font-weight: 600;
            font-size: 14px;
        }

        .tabla-formal td {
            padding: 12px 15px;
            text-align: center;
            font-size: 14px;
            border-bottom: 1px solid #e0e0e0;
        }

        .tabla-formal tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .tabla-formal tr:hover {
            background-color: #f1f1f1;
        }

        .tabla-formal h2 {
            font-size: 20px;
            color:rgb(134, 28, 183);
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
    <div class="tabla-formal">
        <h2>Detalle del Pedido</h2>
        <table>
            <tr>
                <th>ID Detalle</th>
                <th>ID Producto</th>
                <th>Nombre del Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
            </tr>';

    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($fila["ID_Detalle"]) . "</td>
                <td>" . htmlspecialchars($fila["ID_Prod"]) . "</td>
                <td>" . htmlspecialchars($fila["Nomb_Prod"]) . "</td>
                <td>" . htmlspecialchars($fila["Prec_Vent"]) . "</td>
                <td>" . htmlspecialchars($fila["Cantidad"]) . "</td>
              </tr>";
    }

    echo '</table></div>';
} else {
    echo "No hay detalles de este pedido.";
}

?>
