<?php
session_start();
require_once '../server/conexion_bd.php';

// Consulta de los envíos
$sql = "SELECT ID_Cliente, Nombre_Cliente, Apellido_Cliente, Direc_Cliente,Telef_Cliente FROM  cliente";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Clientes </title>
    <link rel="stylesheet" href="css/styles.css">
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background:#f0f0f0;
        margin: 0;
        padding: 20px;
    }

    main#main {
        padding: 20px;
    }

    h2 {
        text-align: center;
        color: #b71c1c;
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
        background-color: #E5524F;
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
        background-color: #e53935;
    }

    .btn-edit:hover {
        background-color: #c62828;
        box-shadow: 0 2px 6px rgba(198, 40, 40, 0.4);
    }

    .btn-delete {
        background-color: #ef5350;
    }

    .btn-delete:hover {
        background-color: #e53935;
        box-shadow: 0 2px 6px rgba(229, 57, 53, 0.4);
    }
</style>
</head>
<body>

    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>

    <main id="main">
        <h2>Clientes</h2>
        <table>
    <tr>
        <th>ID Cliente</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Dirección</th>
        <th>Telefono</th>

    </tr>
    <?php
    if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>
                <td>" . htmlspecialchars($fila["ID_Cliente"]) . "</td>
                <td>" . htmlspecialchars($fila["Nombre_Cliente"]) . "</td>
                <td>" . htmlspecialchars($fila["Apellido_Cliente"]) . "</td>
                <td>" . htmlspecialchars($fila["Direc_Cliente"]) . "</td>
                <td>" . htmlspecialchars($fila["Telef_Cliente"]) . "</td>
            </tr>";
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
