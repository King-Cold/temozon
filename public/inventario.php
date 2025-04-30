<?php
session_start();
require_once '../server/conexion_bd.php'; 

$sql = "SELECT p.ID_Prod, p.Nomb_Prod, p.Desc_Prod, p.Lote_Prod, p.Cant_Disp_Prod, 
               a.Direccion_Alm AS Almacen, p.Prec_Comp, p.Prec_vent, p.Nombre_Prov, 
               c.Categoria_Nombre, p.Prod_Estatus, p.Fec_Cad
        FROM productos p
        JOIN almacen a ON p.ID_Almacen = a.ID_Almacen
        JOIN categoria c ON p.ID_Categoria = c.ID_Categoria";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>
    <main id="main">
        <h2>Inventario de Productos</h2>
        <table border="1" cellspacing="0" cellpadding="5">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Lote</th>
                <th>Cantidad</th>
                <th>Almacén</th>
                <th>Precio Compra</th>
                <th>Precio Venta</th>
                <th>Proveedor</th>
                <th>Categoría</th>
                <th>Estatus</th>
                <th>Fecha Caducidad</th>
            </tr>
            <?php
            if ($resultado && $resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>
                        <td>" . htmlspecialchars($fila["ID_Prod"]) . "</td>
                        <td>" . htmlspecialchars($fila["Nomb_Prod"]) . "</td>
                        <td>" . htmlspecialchars($fila["Desc_Prod"]) . "</td>
                        <td>" . htmlspecialchars($fila["Lote_Prod"]) . "</td>
                        <td>" . htmlspecialchars($fila["Cant_Disp_Prod"]) . "</td>
                        <td>" . htmlspecialchars($fila["Almacen"]) . "</td>
                        <td>$" . htmlspecialchars($fila["Prec_Comp"]) . "</td>
                        <td>$" . htmlspecialchars($fila["Prec_vent"]) . "</td>
                        <td>" . htmlspecialchars($fila["Nombre_Prov"]) . "</td>
                        <td>" . htmlspecialchars($fila["Categoria_Nombre"]) . "</td>
                        <td>" . ($fila["Prod_Estatus"] ? 'Activo' : 'Inactivo') . "</td>
                        <td>" . htmlspecialchars($fila["Fec_Cad"]) . "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='12'>No hay productos en el inventario.</td></tr>";
            }
            ?>
        </table>
    </main>

    <script src="js/script.js"></script>
</body>
</html>
