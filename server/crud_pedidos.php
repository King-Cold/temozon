<?php
require_once '../server/conexion_bd.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // MODIFICAR PEDIDO
    if (isset($_POST['modificar']) && isset($_POST['id_pedido'])) {
        $id_pedido = intval($_POST['id_pedido']);
        $id_envio = intval($_POST['ID_Envio']);
        $id_cliente = intval($_POST['ID_Cliente']);
        $fecha = $_POST['Fecha'];
        $cantidades = $_POST['cantidades']; 
        $productos_nuevos = $_POST['productos']; 

        $precio_total = 0;

        foreach ($cantidades as $id_detalle => $nueva_cant) {
            $id_detalle = intval($id_detalle);
            $nueva_cant = intval($nueva_cant);
            $nuevo_prod = $conexion->real_escape_string($productos_nuevos[$id_detalle]);

            // Obtener datos anteriores
            $res = $conexion->query("SELECT ID_Prod, Cantidad FROM detalle_pedido WHERE ID_Detalle = $id_detalle");
            $row = $res->fetch_assoc();
            $prod_anterior = $row['ID_Prod'];
            $cant_anterior = $row['Cantidad'];

            // Restaurar stock anterior
            $conexion->query("UPDATE productos SET Cant_Disp_Prod = Cant_Disp_Prod + $cant_anterior WHERE ID_Prod = '$prod_anterior'");

            // Descontar stock nuevo
            $conexion->query("UPDATE productos SET Cant_Disp_Prod = Cant_Disp_Prod - $nueva_cant WHERE ID_Prod = '$nuevo_prod'");

            // Actualizar detalle_pedido
            $conexion->query("UPDATE detalle_pedido SET ID_Prod = '$nuevo_prod', Cantidad = $nueva_cant WHERE ID_Detalle = $id_detalle");

            // Obtener precio del producto nuevo
            $res2 = $conexion->query("SELECT Prec_Vent FROM productos WHERE ID_Prod = '$nuevo_prod'");
            $precio = $res2->fetch_assoc()['Prec_Vent'];
            $precio_total += $precio * $nueva_cant;
        }

        // Actualizar pedido principal
        $stmt = $conexion->prepare("UPDATE pedidos SET ID_Envio=?, ID_Cliente=?, Fecha=?, Precio_Total=? WHERE ID_Pedido=?");
        $stmt->bind_param("iisdi", $id_envio, $id_cliente, $fecha, $precio_total, $id_pedido);
        $stmt->execute();

        // Actualizar estado de envíos 
        $conexion->query("
            UPDATE envios e
            JOIN (
                SELECT ID_Envio, COUNT(*) AS total_pedidos
                FROM pedidos
                GROUP BY ID_Envio
            ) p ON e.ID_Envio = p.ID_Envio
            SET e.Estado_Envio = 'En tránsito'
            WHERE p.total_pedidos >= e.Maximo_Articulos
            AND e.Estado_Envio != 'En tránsito';
        ");

        header('Location: ../public/pedidos.php');
        exit;
    }

    // ELIMINAR PEDIDO
    if (isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
        $id_pedido = intval($_POST['id_pedido']);
        $result = $conexion->query("SELECT ID_Prod, Cantidad FROM detalle_pedido WHERE ID_Pedido = $id_pedido");
        while ($row = $result->fetch_assoc()) {
            $id_prod = $row['ID_Prod'];
            $cant = $row['Cantidad'];
            $conexion->query("UPDATE productos SET Cant_Disp_Prod = Cant_Disp_Prod + $cant WHERE ID_Prod = '$id_prod'");
        }
        $conexion->query("DELETE FROM detalle_pedido WHERE ID_Pedido = $id_pedido");
        $conexion->query("DELETE FROM pedidos WHERE ID_Pedido = $id_pedido");
        header('Location: ../public/pedidos.php');
        exit;
    }

    // AGREGAR PEDIDO
    $id_envio = intval($_POST['ID_Envio']);
    $id_cliente = intval($_POST['ID_Cliente']);
    $productos = $_POST['productos'];
    $cantidades = $_POST['cantidades'];

    if (count($productos) !== count($cantidades)) {
        http_response_code(400);
        echo "Error: Los productos y cantidades no coinciden.";
        exit;
    }

    $precio_total = 0;
    foreach ($productos as $i => $id_prod) {
        $id_prod = $conexion->real_escape_string($id_prod);
        $cant = intval($cantidades[$i]);
        $query = $conexion->query("SELECT Prec_Vent FROM productos WHERE ID_Prod = '$id_prod'");
        if ($row = $query->fetch_assoc()) {
            $precio_total += $row['Prec_Vent'] * $cant;
        }
    }

    $stmt = $conexion->prepare("INSERT INTO pedidos (ID_Envio, ID_Cliente, Fecha, Precio_Total) VALUES (?, ?, NOW(), ?)");
    $stmt->bind_param("iid", $id_envio, $id_cliente, $precio_total);
    $stmt->execute();
    $id_pedido = $stmt->insert_id;

    $stmt_detalle = $conexion->prepare("INSERT INTO detalle_pedido (ID_Pedido, ID_Prod, Cantidad) VALUES (?, ?, ?)");
    foreach ($productos as $i => $id_prod) {
        $cant = intval($cantidades[$i]);
        $stmt_detalle->bind_param("isi", $id_pedido, $id_prod, $cant);
        $stmt_detalle->execute();
        $conexion->query("UPDATE productos SET Cant_Disp_Prod = Cant_Disp_Prod - $cant WHERE ID_Prod = '$id_prod'");
    }

    $conexion->query("
        UPDATE envios e
        JOIN (
            SELECT ID_Envio, COUNT(*) AS total_pedidos
            FROM pedidos
            GROUP BY ID_Envio
        ) p ON e.ID_Envio = p.ID_Envio
        SET e.Estado_Envio = 'En tránsito'
        WHERE p.total_pedidos >= e.Maximo_Articulos
        AND e.Estado_Envio != 'En tránsito';
    ");

    echo "Pedido confirmado con éxito.";

} else {
    http_response_code(405);
    echo "Método no permitido.";
}
?>
