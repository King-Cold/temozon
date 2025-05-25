<?php
session_start();
require_once '../server/conexion_bd.php';

// Verificar si se envió el ID por GET
if (!isset($_GET['id'])) {
    echo "ID de cliente no especificado.";
    exit;
}

$id = $_GET['id'];

// Consultar los datos del cliente
$sql = "SELECT * FROM cliente WHERE ID_Cliente = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "Cliente no encontrado.";
    exit;
}

$cliente = $resultado->fetch_assoc();

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    $sqlUpdate = "UPDATE cliente SET Nombre_Cliente=?, Direc_Cliente=?, Telef_Cliente=? WHERE ID_Cliente=?";
    $stmtUpdate = $conexion->prepare($sqlUpdate);
    $stmtUpdate->bind_param("sssi", $nombre, $direccion, $telefono, $id);

    if ($stmtUpdate->execute()) {
        header("Location: ../public/clientes.php");
        exit;
    } else {
        echo "<p style='color:red; text-align:center;'>Error al actualizar cliente.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #f0f2f5;
        padding: 40px;
        margin: 0;
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 30px;
    }

    form {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        max-width: 500px;
        margin: auto;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        
    }

    label {
        display: block;
        margin-top: 15px;
        font-weight: 600;
        color: #555;
    }

    input, select {
        width: 100%;
        padding: 12px;
        margin-top: 8px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    input:focus, select:focus {
        border-color: #1976d2;
        outline: none;
        box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.15);
    }

    .botones {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }

    button, .cancelar {
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        text-align: center;
        font-weight: 600;
        transition: background 0.3s ease, transform 0.2s ease;
        text-decoration: none;
        font-size: 14px;
    }

    .guardar {
        background: #1976d2;
        color: #fff;
    }

    .guardar:hover {
        background: #125ea6;
        transform: translateY(-1px);
    }

    .cancelar {
        background:rgb(163, 24, 59);
        color: #fff;
    }

    .cancelar:hover {
        background: #a31818;
        transform: translateY(-1px);
    }
</style>
</head>
<body>

<h2 style="text-align:center;">Editar Cliente#<?php echo $id; ?></h2>

<form method="POST">
    <label>Nombre del Cliente:</label>
    <input type="text" name="nombre" value="<?php echo htmlspecialchars($cliente['Nombre_Cliente']); ?>" required>

    <label>Dirección del Cliente:</label>
    <input type="text" name="direccion" value="<?php echo htmlspecialchars($cliente['Direc_Cliente']); ?>" required>

    <label>Telefono del Cliente:</label>
    <input type="text" name="telefono" value="<?php echo htmlspecialchars($cliente['Telef_Cliente']); ?>" required>

    <div class="botones">
        <button type="submit" name="guardar" class="guardar">Guardar Cambios</button>
        <a href="../public/clientes.php" class="cancelar">Cancelar</a>
    </div>
</form>

</body>
</html>
