<?php
session_start();
require_once '../server/conexion_bd.php';

// Verificar si se envió el ID por GET
if (!isset($_GET['id'])) {
    echo "ID de envío no especificado.";
    exit;
}

$id = $_GET['id'];

// Eliminar el envío
$sql = "DELETE FROM envios WHERE ID_Usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: envios.php");
    exit;
} else {
    echo "Error al eliminar el envío.";
}
?>
