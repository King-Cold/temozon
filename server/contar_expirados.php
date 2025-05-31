<?php
include("conexion_bd.php");

// Consulta para contar productos expirados
$sql = "SELECT COUNT(*) AS total FROM productos WHERE Fec_Cad < CURDATE()";
$resultado = $conexion->query($sql);

// Si hay resultado, lo retornamos
if ($fila = $resultado->fetch_assoc()) {
    echo $fila['total'];
} else {
    echo "0";
}

$conexion->close();
?>
