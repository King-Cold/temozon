<?php
session_start();
require_once '../server/conexion_bd.php';

// Consulta de los envíos
$sql = "SELECT ID_Envio, Estado_Envio,Maximo_Articulos, Fecha_Envio, Fecha_Recibo FROM envios";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Envíos</title>
    <link rel="stylesheet" href="css/styles.css">
 <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f4f4f4;
        margin: 0;
        padding: 20px;
    }

    main#main {
        padding: 20px;
    }

    h2 {
        text-align: center;
        color: #333333;
        margin-bottom: 25px;
        font-size: 30px;
        letter-spacing: 0.5px;
    }

    table {
        width: 95%;
        margin: auto;
        border-collapse: collapse;
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(51, 51, 51, 0.2);
        border-radius: 10px;
        overflow: hidden;
    }

    table th, table td {
        padding: 14px 18px;
        text-align: center;
        border: 1px solid #e0e0e0;
    }

    table th {
        background-color: #424242;
        color: #ffffff;
        font-weight: 600;
        font-size: 16px;
    }

    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    table tr:nth-child(odd) {
        background-color: #eeeeee;
    }

    table tr:hover {
        background-color: #d6d6d6;
        transition: background-color 0.3s ease;
    }

    table td {
        color: #333333;
        font-size: 14.5px;
    }

    .btn {
        padding: 8px 14px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
        color: #fff;
        margin: 2px;
        display: inline-block;
        transition: background-color 0.3s ease, box-shadow 0.2s ease;
    }

    .btn-edit {
        background-color: #616161;
    }

    .btn-edit:hover {
        background-color: #424242;
        box-shadow: 0 2px 6px rgba(66, 66, 66, 0.4);
    }

    .btn-delete {
        background-color: #757575;
    }

    .btn-delete:hover {
        background-color: #616161;
        box-shadow: 0 2px 6px rgba(97, 97, 97, 0.4);
    }
</style>
</head>
<body>

    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>

    <main id="main">
        <h2>Registro de Envíos</h2>
        <table>
    <tr>
        <th>ID Envío</th>
        <th>Estado</th>
        <th>Maximo de Pedidos </th>
        <th>Fecha de Envío</th>
        <th>Fecha de Recibo</th>
        <?php if (tienePermiso(['Encargado de Bodega'])): ?>
        <th>Acciones</th>
        <?php endif; ?>
    </tr>
    <?php
    if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>
                <td>" . htmlspecialchars($fila["ID_Envio"]) . "</td>
                <td>" . htmlspecialchars($fila["Estado_Envio"]) . "</td>
                <td>" . htmlspecialchars($fila["Maximo_Articulos"]) . "</td>
                <td>" . htmlspecialchars($fila["Fecha_Envio"]) . "</td>
                <td>" . ($fila["Fecha_Recibo"] ? htmlspecialchars($fila["Fecha_Recibo"]) : 'Pendiente') . "</td>";
            
            if (tienePermiso(['Encargado de Bodega'])) {
                echo "<td>
                    <a class='btn btn-edit' href='../server/crud_envios.php?id=" . $fila["ID_Envio"] . "'>Modificar</a>
                    <form method='POST' action='../server/crud_envios.php?id=" . $fila["ID_Envio"] . "' style='display:inline;' onsubmit=\"return confirm('¿Seguro que deseas eliminar este envío?');\">
                        <input type='hidden' name='eliminar' value='1'>
                        <button type='submit' class='btn btn-delete'>Eliminar</button>
                    </form>
                </td>";
            }
        }
    } else {
        echo "<tr><td colspan='5'>No hay registros de envíos.</td></tr>";
    }
    ?>
</table>
    </main>
    <script src="js/script.js"></script>
</body>
</html>
