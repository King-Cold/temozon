<?php
$conexion = new mysqli("localhost", "root", "", "empresa_db");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$sql = "SELECT mes, ventas FROM ventas_mensuales";
$resultado = $conexion->query($sql);

$meses = [];
$ventas = [];

while($fila = $resultado->fetch_assoc()) {
    $meses[] = $fila['mes'];
    $ventas[] = $fila['ventas'];
}

echo json_encode(["meses" => $meses, "ventas" => $ventas]);

$conexion->close();
?>