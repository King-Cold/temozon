<?php
session_start();
require_once '../server/conexion_bd.php';

// Consulta de los envíos
$sql = "SELECT ID_Cliente, Nombre_Cliente, Direc_Cliente,Telef_Cliente FROM  cliente";
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
        font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f0f0f0;
        margin: 0;
        padding: 20px;
    }

    main#main {
        padding: 20px;
    }

    h2 {
        text-align: center;
        color: #FC0052;
        margin-bottom: 25px;
        font-size: 30px;
        letter-spacing: 0.5px;
    }

    table {
        width: 95%;
        margin: auto;
        border-collapse: collapse;
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(190, 73, 103, 0.2);
        border-radius: 10px;
        overflow: hidden;
    }

    table th, table td {
        padding: 14px 18px;
        text-align: center;
        border: 1px solid rgb(219, 215, 243);
    }

    table th {
        background-color:rgba(255, 77, 92, 0.75);
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
        background-color:rgb(40, 49, 163);
    }

    .btn-edit:hover {
        background-color:rgb(70, 64, 161);
        box-shadow: 0 2px 6px rgba(106, 27, 154, 0.4);
    }

    .btn-delete {
        background-color:rgb(188, 71, 87);
    }

    .btn-delete:hover {
        background-color:rgb(176, 39, 39);
        box-shadow: 0 2px 6px rgba(156, 39, 176, 0.4);
    }
        .btn-add {
        background-color: #388e3c;
    }

    .btn-add:hover {
        background-color: #2e7d32;
        box-shadow: 0 2px 6px rgba(76, 175, 80, 0.4);
    }
</style>
</head>
<body>

    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>

    <main id="main">
        <div style="width:95%; margin:auto; display:flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin:0;">Clientes</h2>
    <button onclick="document.getElementById('formAgregar').style.display='block'" class="btn btn-add">Agregar Cliente</button>
</div>
        
            <div id="formAgregar" style="display:none; background:#fff; padding:20px; border-radius:8px; width:95%; margin:auto; margin-bottom:20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <form method="POST" action="../server/crud_clientes.php" style="display: flex; flex-wrap: wrap; gap: 10px;">
            <input type="text" name="nombre" placeholder="Nombre Cliente" required style="flex:1; padding:8px;">
            <input type="text" name="direccion" placeholder="Dirección" required style="flex:1; padding:8px;">
            <input type="text" name="telefono" placeholder="Teléfono" required style="flex:1; padding:8px;">

            <div style="flex:1; display:flex; gap:10px;">
                <button type="submit" name="agregar" class="btn btn-add">Guardar</button>
                <button type="button" onclick="document.getElementById('formAgregar').style.display='none'" class="btn btn-delete">Cancelar</button>
            </div>
        </form>
    </div>
        <table>
    <tr>
        <th>ID Cliente</th>
        <th>Nombre</th>
        <th>Dirección</th>
        <th>Telefono</th>
        <th>Acciones</th>

    </tr>
    <?php
    if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>
                <td>" . htmlspecialchars($fila["ID_Cliente"]) . "</td>
                <td>" . htmlspecialchars($fila["Nombre_Cliente"]) . "</td>
                <td>" . htmlspecialchars($fila["Direc_Cliente"]) . "</td>
                <td>" . htmlspecialchars($fila["Telef_Cliente"]) . "</td>
                <td>
                    <a class='btn btn-edit' href='../server/crud_clientes.php?id=" . $fila["ID_Cliente"] . "'>Modificar</a>
                    <form method='POST' action='../server/crud_clientes.php?id=" . $fila["ID_Cliente"] . "' style='display:inline;' onsubmit=\"return confirm('¿Seguro que deseas eliminar este envío?');\">
                        <input type='hidden' name='eliminar' value='1'>
                        <button type='submit' class='btn btn-delete'>Dar de baja</button>
                    </form>
                </td>
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
