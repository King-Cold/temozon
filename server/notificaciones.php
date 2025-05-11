<?php
session_start();
require_once '../server/conexion_bd.php'; // Ajusta la ruta si es necesario

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para productos próximos a caducar (próximos 7 días)
$sql = "SELECT 
            ID_Prod, 
            Nomb_Prod, 
            Desc_Prod, 
            Lote_Prod, 
            Cant_Disp_Prod, 
            ID_Almacen, 
            Prec_Comp, 
            Prec_vent, 
            Nombre_Prov, 
            ID_Categoria, 
            Fec_Cad, 
            Prod_Estatus 
        FROM productos
        WHERE DATE(Fec_Cad) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 10000000 DAY)
        AND Prod_Estatus = 'Activo'
        ORDER BY Fec_Cad ASC";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificaciones de Productos Próximos a Caducar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h2 {
            color: #4b0082;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #4b0082;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #eee;
        }
        p {
            font-size: 16px;
        }
    </style>
</head>
<body>

    <h2>📢 Productos Próximos a Caducar (7 días)</h2>

    <?php
    if ($resultado) {
        if ($resultado->num_rows > 0) {
            echo "<table>";
            echo "<tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Lote</th>
                    <th>Disponible</th>
                    <th>Almacén</th>
                    <th>Precio Compra</th>
                    <th>Precio Venta</th>
                    <th>Proveedor</th>
                    <th>Categoría</th>
                    <th>Fecha Caducidad</th>
                    <th>Estatus</th>
                  </tr>";

            while ($row = $resultado->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['ID_Prod']}</td>
                        <td>{$row['Nomb_Prod']}</td>
                        <td>{$row['Desc_Prod']}</td>
                        <td>{$row['Lote_Prod']}</td>
                        <td>{$row['Cant_Disp_Prod']}</td>
                        <td>{$row['ID_Almacen']}</td>
                        <td>$ {$row['Prec_Comp']}</td>
                        <td>$ {$row['Prec_vent']}</td>
                        <td>{$row['Nombre_Prov']}</td>
                        <td>{$row['ID_Categoria']}</td>
                        <td>{$row['Fec_Cad']}</td>
                        <td>{$row['Prod_Estatus']}</td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "<p>✅ No hay productos próximos a caducar en los próximos 7 días.</p>";
        }
    } else {
        echo "<p>Error en la consulta: " . $conexion->error . "</p>";
    }

    $conexion->close();
    ?>

</body>
</html>
