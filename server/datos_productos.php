<?php
// conexion.php
$conexion = new mysqli("localhost", "root", "", "empresa_db");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT nombre_producto, unidades_vendidas FROM productos_vendidos ORDER BY unidades_vendidas DESC LIMIT 5";
$resultado = $conexion->query($sql);

$productos = [];
$ventas = [];

while ($fila = $resultado->fetch_assoc()) {
    $productos[] = $fila['nombre_producto'];
    $ventas[] = $fila['unidades_vendidas'];
}

echo json_encode([
    'productos' => $productos,
    'ventas' => $ventas
]);
?>