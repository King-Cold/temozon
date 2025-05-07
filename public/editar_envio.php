<?php
session_start();
require_once '../server/conexion_bd.php';

// Verificar si se envió el ID por GET
if (!isset($_GET['id'])) {
    echo "ID de envío no especificado.";
    exit;
}

$id = $_GET['id'];

// Consultar los datos del envío
$sql = "SELECT * FROM envios WHERE ID_Envio = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "Envío no encontrado.";
    exit;
}

$envio = $resultado->fetch_assoc();

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estado = $_POST['estado'];
    $fecha_envio = $_POST['fecha_envio'];
    $fecha_recibo = $_POST['fecha_recibo'];

    $sqlUpdate = "UPDATE envios SET Estado_de_Envio = ?, Fecha_Envio = ?, Fecha_Recibo = ? WHERE ID_Envio = ?";
    $stmtUpdate = $conexion->prepare($sqlUpdate);
    $stmtUpdate->bind_param("sssi", $estado, $fecha_envio, $fecha_recibo, $id);

    if ($stmtUpdate->execute()) {
        header("Location: envios.php");
        exit;
    } else {
        echo "Error al actualizar.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Envío</title>
    <style>
        body { font-family: sans-serif; background: #f4f6f8; padding: 20px; }
        form { background: #fff; padding: 20px; border-radius: 8px; max-width: 500px; margin: auto; }
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 20px; padding: 10px 20px; background: #1976d2; color: #fff; border: none; border-radius: 6px; }
        button:hover { background: #125ea6; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Editar Envío #<?php echo $id; ?></h2>

<form method="POST">
    <label>Estado de Envío:</label>
    <select name="estado" required>
        <option value="Pendiente de envío" <?= $envio['Estado_de_Envio'] === 'Pendiente de envío' ? 'selected' : ''; ?>>Pendiente de envío</option>
        <option value="En tránsito" <?= $envio['Estado_de_Envio'] === 'En tránsito' ? 'selected' : ''; ?>>En tránsito</option>
        <option value="Entregado" <?= $envio['Estado_de_Envio'] === 'Entregado' ? 'selected' : ''; ?>>Entregado</option>
        <option value="Cancelado" <?= $envio['Estado_de_Envio'] === 'Cancelado' ? 'selected' : ''; ?>>Cancelado</option>
    </select>

    <label>Fecha de Envío:</label>
    <input type="date" name="fecha_envio" value="<?php echo $envio['Fecha_Envio']; ?>">

    <label>Fecha de Recibo:</label>
    <input type="date" name="fecha_recibo" value="<?php echo $envio['Fecha_Recibo']; ?>">

    <button type="submit">Guardar Cambios</button>
</form>

</body>
</html>
