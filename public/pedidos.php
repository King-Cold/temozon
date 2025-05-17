<?php
session_start();
require_once '../server/conexion_bd.php';

// Consulta solo con los campos requeridos
$sql = "SELECT 
            pedidos.ID_Pedido,
            pedidos.ID_Detalle_Pedido,
            pedidos.ID_Envio,
            envios.Estado_Envio,
            pedidos.ID_Cliente,
            cliente.Nombre_Cliente,
            cliente.Direc_Cliente,
            pedidos.Fecha,
            pedidos.Precio_Total
        FROM pedidos
        INNER JOIN cliente ON pedidos.ID_Cliente = cliente.ID_Cliente
        INNER JOIN envios ON pedidos.ID_Envio = envios.ID_Envio";

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
            background-color: #f8c8c8;
            transition: background-color 0.3s ease;
        }

        table td {
            color: #333;
            font-size: 14.5px;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

<main id="main">
    <h2>PEDILLOS 🤮</h2>
    <table>
        <tr>
            <th>ID Pedido</th>
            <th>ID Detalle</th>
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
                echo "<tr>
                    <td>" . htmlspecialchars($fila["ID_Pedido"]) . "</td>
                    <td>" . htmlspecialchars($fila["ID_Detalle_Pedido"] ?? "N/A") . "</td>
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
</main>

<script src="js/script.js"></script>
</body>
</html>