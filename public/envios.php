<?php
session_start();
require_once '../server/conexion_bd.php';

// Consulta de los envíos
$sql = "SELECT ID_Envio, Estado_de_Envio, Fecha_Envio, Fecha_Recibo FROM envios";
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
            background: #f4f6f8;
            margin: 0;
        }

        main#main {
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 28px;
        }

        table {
            width: 95%;
            margin: auto;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 0 0 2px #000000;
            border-radius: 8px;
            overflow: hidden;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ccc;
        }

        table th {
            background-color: rgb(0, 5, 8);
            color: #ffffff;
            font-weight: 600;
        }

        table tr:nth-child(even) {
            background-color: rgb(255, 255, 255);
        }

        table tr:nth-child(odd) {
            background-color: rgb(213, 224, 231);
        }

        table tr:hover {
            background-color: #c5cae9;
        }

        table td {
            color: #333;
            font-size: 14px;
        }

        .btn {
    padding: 6px 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 13px;
    text-decoration: none;
    color: #fff;
    margin: 2px;
    display: inline-block;
}

.btn-edit {
    background-color: #1976d2;
}

.btn-edit:hover {
    background-color: #125ea6;
}

.btn-delete {
    background-color: #d32f2f;
}

.btn-delete:hover {
    background-color: #a52828;
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
                <td>" . htmlspecialchars($fila["Estado_de_Envio"]) . "</td>
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
