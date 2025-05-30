<?php
include("../server/conexion_bd.php");

// Contar productos
$result = mysqli_query($conexion, "SELECT COUNT(*) AS total FROM productos");
$row = mysqli_fetch_assoc($result);
$totalProductos = $row['total'];

// Contar ventas
$result = mysqli_query($conexion, "SELECT COUNT(*) AS total FROM pedidos");
$row = mysqli_fetch_assoc($result);
$totalVentas = $row['total'];

// Calcular ingresos
$result = mysqli_query($conexion, "SELECT SUM(Precio_Total) AS ingresos FROM pedidos");
$row = mysqli_fetch_assoc($result);
$totalIngresos = $row['ingresos'] ? $row['ingresos'] : 0;

// Calcular compras
$result = mysqli_query($conexion, "SELECT SUM(Prec_Comp) AS compras FROM productos");
$row = mysqli_fetch_assoc($result);
$totalCompras = $row['compras'] ? $row['compras'] : 0;

// Devolver los datos en formato JSON
echo json_encode([
    "productos" => $totalProductos,
    "ventas" => $totalVentas,
    "ingresos" => $totalIngresos,
    "compras" => $totalCompras
]);

?>