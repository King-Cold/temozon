<?php
require_once 'conexion_bd.php';

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para contar productos próximos a caducar
$sql = "SELECT COUNT(*) AS total FROM productos 
        WHERE DATE(Fec_Cad) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 100 DAY)
        AND Prod_Estatus = 1";

$resultado = $conexion->query($sql);

if ($resultado) {
    $fila = $resultado->fetch_assoc();
    echo $fila['total'];
} else {
    echo "0";
}

$conexion->close();
?>