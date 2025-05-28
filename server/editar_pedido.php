<?php
require_once '../server/conexion_bd.php';

$id = intval($_GET['id']);

// Datos del pedido
$pedido = $conexion->query("SELECT * FROM pedidos WHERE ID_Pedido = $id")->fetch_assoc();
$detalles = $conexion->query("SELECT dp.ID_Detalle, dp.ID_Prod, dp.Cantidad, p.Nomb_Prod, p.Cant_Disp_Prod 
                              FROM detalle_pedido dp 
                              JOIN productos p ON dp.ID_Prod = p.ID_Prod 
                              WHERE dp.ID_Pedido = $id");

$envios = $conexion->query("SELECT ID_Envio FROM envios WHERE Estado_Envio = 'Pendiente'");
$clientes = $conexion->query("SELECT ID_Cliente, Nombre_Cliente, Apellido_Cliente FROM cliente");
$productos = $conexion->query("SELECT ID_Prod, Nomb_Prod, Cant_Disp_Prod FROM productos WHERE Prod_Estatus = 1");

$productoLista = [];
foreach ($productos as $prod) {
    $productoLista[$prod['ID_Prod']] = [
        'nombre' => $prod['Nomb_Prod'],
        'disponible' => $prod['Cant_Disp_Prod']
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Pedido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 20px;
        }

        form {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        label {
            margin-top: 15px;
            display: block;
        }

        select, input[type="number"], input[type="datetime-local"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .producto-block {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .botones {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
        }

        .guardar {
            background-color: #1976d2;
        }

        .cancelar {
            background-color: #c62828;
            text-decoration: none;
            text-align: center;
            line-height: 36px;
        }
    </style>
    <script>
        const productos = <?php echo json_encode($productoLista); ?>;

        function actualizarMax(cantidadInput, selectElement, cantidadAnterior) {
            const idProd = selectElement.value;
            const disponible = productos[idProd]?.disponible || 0;
            const maxPermitido = disponible + parseInt(cantidadAnterior);

            cantidadInput.max = maxPermitido;
            if (parseInt(cantidadInput.value) > maxPermitido) {
                cantidadInput.value = maxPermitido;
            }
        }
    </script>
</head>
<body>

<h2 style="text-align:center;">Editar Pedido #<?php echo $id; ?></h2>

<form method="POST" action="../server/crud_pedidos.php">
    <input type="hidden" name="modificar" value="1">
    <input type="hidden" name="id_pedido" value="<?php echo $id; ?>">

    <label>ID Envío:</label>
    <select name="ID_Envio" required>
        <?php while ($env = $envios->fetch_assoc()) {
            $selected = ($env['ID_Envio'] == $pedido['ID_Envio']) ? 'selected' : '';
            echo "<option value='{$env['ID_Envio']}' $selected>{$env['ID_Envio']}</option>";
        } ?>
    </select>

    <label>Cliente:</label>
    <select name="ID_Cliente" required>
        <?php while ($cli = $clientes->fetch_assoc()) {
            $selected = ($cli['ID_Cliente'] == $pedido['ID_Cliente']) ? 'selected' : '';
            echo "<option value='{$cli['ID_Cliente']}' $selected>#{$cli['ID_Cliente']} - {$cli['Nombre_Cliente']} {$cli['Apellido_Cliente']}</option>";
        } ?>
    </select>

    <label>Fecha:</label>
    <input type="datetime-local" name="Fecha" value="<?php echo date('Y-m-d\TH:i', strtotime($pedido['Fecha'])); ?>" required>

    <h3>Productos del Pedido:</h3>

    <?php while ($detalle = $detalles->fetch_assoc()) {
        $id_detalle = $detalle['ID_Detalle'];
        $id_prod_actual = $detalle['ID_Prod'];
        $cantidad_actual = $detalle['Cantidad'];
        $disponible = $productoLista[$id_prod_actual]['disponible'];
        $maximo = $disponible + $cantidad_actual;
    ?>
        <div class="producto-block">
            <label>Producto:</label>
            <select name="productos[<?php echo $id_detalle; ?>]" required onchange="actualizarMax(this.nextElementSibling, this, <?php echo $cantidad_actual; ?>)">
                <?php foreach ($productoLista as $id_prod => $data) {
                    $selected = ($id_prod_actual == $id_prod) ? 'selected' : '';
                    echo "<option value='$id_prod' $selected>
                            {$data['nombre']} ({$data['disponible']} disponibles)
                          </option>";
                } ?>
            </select>

            <label>Cantidad:</label>
            <input type="number"
                   name="cantidades[<?php echo $id_detalle; ?>]"
                   value="<?php echo $cantidad_actual; ?>"
                   min="1"
                   max="<?php echo $maximo; ?>"
                   required>
        </div>
    <?php } ?>

    <div class="botones">
        <button type="submit" class="btn guardar">Guardar Cambios</button>
        <a href="../public/pedidos.php" class="btn cancelar">Cancelar</a>
    </div>
</form>

</body>
</html>
