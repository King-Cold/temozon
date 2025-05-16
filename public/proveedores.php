<?php
session_start();
require_once '../server/conexion_bd.php';

// Consulta de los envíos
$sql = "SELECT ID_Prov, Nomb_Prov, Telefono_Prov, Tipo_Prov,Manejo_Camb, Direccion_Prov FROM  proveedor";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Proveedores </title>
    <link rel="stylesheet" href="css/styles.css">
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #e3f2fd; /* azul cielo muy claro */
        margin: 0;
        padding: 20px;
    }

    main#main {
        padding: 20px;
    }

    h2 {
        text-align: center;
        color: #0d47a1; /* azul intenso */
        margin-bottom: 20px;
        font-size: 28px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        border-radius: 10px;
        overflow: hidden;
    }

    table th, table td {
        padding: 14px 18px;
        text-align: center;
        border: 1px solid #bbdefb;
    }

    table th {
        background-color: #1565c0; /* azul fuerte */
        color: #ffffff;
        font-weight: 600;
        font-size: 16px;
    }

    table tr:nth-child(even) {
        background-color: #e3f2fd; /* azul claro */
    }

    table tr:nth-child(odd) {
        background-color: #ffffff;
    }

    table tr:hover {
        background-color: #bbdefb; /* azul pastel intermedio */
    }

    table td {
        color: #263238;
        font-size: 15px;
    }

    button {
        background-color: #1565c0;
        color: #fff;
        border: none;
        padding: 10px 24px;
        font-size: 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    button:hover {
        background-color: #0d47a1;
        box-shadow: 0 2px 8px rgba(0,0,0,0.25);
    }

    #escaneoCont {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 999;
    }

    #lector {
        width: 80%;
        height: 60%;
        margin: 50px auto;
        background: #000;
        border-radius: 12px;
    }

    #escaneoCont button {
        position: absolute;
        top: 20px;
        right: 20px;
    }
</style>
</head>
<body>

    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>

    <main id="main">
        <h2>proveedores</h2>
        <table>
    <tr>
        <th>ID Proveedor</th>
        <th>Nombre</th>
        <th>Telefono</th>
        <th>Tipo</th>
        <th>Maneja Cambio</th>
        <th>Dirección</th>

    </tr>
    <?php
    if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>
                <td>" . htmlspecialchars($fila["ID_Prov"]) . "</td>
                <td>" . htmlspecialchars($fila["Nomb_Prov"]) . "</td>
                <td>" . htmlspecialchars($fila["Telefono_Prov"]) . "</td>
                <td>" . htmlspecialchars($fila["Tipo_Prov"]) . "</td>
                <td>" . htmlspecialchars($fila["Manejo_Camb"]) . "</td>
                <td>" . htmlspecialchars($fila["Direccion_Prov"]) . "</td>
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
