<?php
require_once '../server/conexion_bd.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
    }

    echo "Pedido confirmado con éxito.";
} else {
    http_response_code(405);
    echo "Método no permitido.";
}
?>
