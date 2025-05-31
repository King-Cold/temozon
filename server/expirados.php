<?php
include("conexion_bd.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos Expirados</title>
    <style>
        .tabla-formal {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            margin-top: 20px;
        }

        .tabla-formal table {
            border-collapse: collapse;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            border-radius: 8px;
            width: 90%;
            margin: 0 auto;
        }

        .tabla-formal th {
            background-color: #c62828;
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
            font-size: 22px;
            color: #c62828;
            margin-bottom: 15px;
            padding-bottom: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="tabla-formal">
    <h2>Productos Expirados</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Fecha de Caducidad</th>
        </tr>

        <?php
        $sql = "SELECT ID_Prod, Nomb_Prod, Cant_Disp_Prod, Fec_Cad 
                FROM productos
                WHERE Fec_Cad < CURDATE()
                AND Prod_Estatus = 1
                ORDER BY Fec_Cad ASC";

        $resultado = $conexion->query($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['ID_Prod']}</td>
                        <td>{$row['Nomb_Prod']}</td>
                        <td>{$row['Cant_Disp_Prod']}</td>
                        <td style='color: #800000; font-weight: bold;'>{$row['Fec_Cad']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No hay productos expirados 🎉</td></tr>";
        }

        $conexion->close();
        ?>

    </table>
</div>

</body>
</html>
