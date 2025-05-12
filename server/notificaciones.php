<?php
// Mostrar errores para depurar
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conexion_bd.php';

echo "<p>⚙️ Entrando al script...</p>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<p>📨 Método POST detectado</p>";

    if (isset($_POST['guardar_todos'])) {
        echo "<p>✅ Botón 'guardar_todos' detectado</p>";

        if (isset($_POST['descuentos']) && is_array($_POST['descuentos'])) {
            $descuentos = $_POST['descuentos'];

            foreach ($descuentos as $id => $nuevo_descuento) {
                $id = (int)$id;
                $nuevo_descuento = (int)$nuevo_descuento;

                $stmt = $conexion->prepare("UPDATE productos SET Desc_Prod = ? WHERE ID_Prod = ?");
                if ($stmt) {
                    $stmt->bind_param("ii", $nuevo_descuento, $id);
                    $stmt->execute();
                    $stmt->close();
                    echo "<p>✔️ Producto ID $id actualizado a $nuevo_descuento%</p>";
                } else {
                    echo "<p style='color:red;'>❌ Error al preparar la sentencia para el producto $id</p>";
                }
            }

            echo "<p style='color:green;'>✅ Todos los descuentos han sido actualizados.</p>";
        } else {
            echo "<p style='color:red;'>❌ No se recibieron datos de descuentos.</p>";
        }

        // Opcional: redirige para evitar reenvío (comenta esto mientras depuras)
        // header("Location: " . $_SERVER['PHP_SELF']);
        // exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificaciones</title>
    <style>
        .tabla-formal {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            margin-top: 20px;
        }

        .tabla-formal table {
            border-collapse: collapse;
            width: 100%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            border-radius: 8px;
        }

        .tabla-formal th {
            background-color: #3f51b5;
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

        .tabla-formal input[type="number"] {
            width: 60px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .tabla-formal h2 {
            font-size: 22px;
            color: #3f51b5;
            margin-bottom: 15px;
            border-bottom: 2px solid rgb(0, 0, 0);
            padding-bottom: 5px;
            text-align: center;
        }

        .tabla-formal button {
            padding: 5px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .tabla-formal button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="tabla-formal">
    <h2>Productos próximos a caducar</h2>

    <form method="POST">
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descuento (%)</th>
                <th>Fecha Caducidad</th>
            </tr>
            <?php
            $sql = "SELECT ID_Prod, Nomb_Prod, Desc_Prod, Fec_Cad FROM productos
                    WHERE Fec_Cad BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1000 DAY)
                    AND Prod_Estatus = 1
                    ORDER BY Fec_Cad ASC";
            $resultado = $conexion->query($sql);

            if ($resultado && $resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['ID_Prod']}</td>
                            <td>{$row['Nomb_Prod']}</td>
                            <td>
                                <input type='number' name='descuentos[{$row['ID_Prod']}]' value='{$row['Desc_Prod']}' min='0' max='100'>
                            </td>
                            <td>{$row['Fec_Cad']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No hay productos próximos a caducar.</td></tr>";
            }

            $conexion->close();
            ?>
        </table><br>
        <div style="text-align: center;">
            <button type="submit" name="guardar_todos">Guardar todos</button>
        </div>
    </form>
</div>

</body>
</html>
