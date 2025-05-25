<?php
session_start();
require_once '../server/conexion_bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $id = $_GET['id'];

    $sqlDelete = "DELETE FROM cliente WHERE ID_Cliente = ?";
    $stmtDelete = $conexion->prepare($sqlDelete);
    $stmtDelete->bind_param("s", $id);

    if ($stmtDelete->execute()) {
        header("Location: ../public/clientes.php");
        exit;
    } else {
        echo "<p style='color:red; text-align:center;'>Error al eliminar cliente.</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    $usuario = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];


    $sqlInsert = "INSERT INTO cliente (Nombre_Cliente, Direc_Cliente, Telef_Cliente)
    VALUES (?, ?, ?)";
    $stmtInsert = $conexion->prepare($sqlInsert);
    $stmtInsert->bind_param("sss", $usuario, $direccion, $telefono);

    if ($stmtInsert->execute()) {
        header("Location: ../public/clientes.php");
        exit;
    } else {
        echo "<p style='color:red; text-align:center;'>Error al agregar usuario.</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    // Actualizar usuario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    $sqlUpdate = "UPDATE cliente SET Nombre_Cliente = ?, Direc_Cliente = ?, Telef_Cliente = ? WHERE ID_Cliente = ?";
    $stmtUpdate = $conexion->prepare($sqlUpdate);
    $stmtUpdate->bind_param("ssss", $nombre, $direccion, $telefono,$id);

    if ($stmtUpdate->execute()) {
        header("Location: ../public/clientes.php");
        exit;
    } else {
        echo "Error al actualizar.";
    }
}
// Verificar si se envió el ID por GET
if (!isset($_GET['id'])) {
    echo "ID de usuario no especificado.";
    exit;
}

$id = $_GET['id'];

// Consultar los datos del usuario
$sql = "SELECT * FROM cliente WHERE ID_Cliente = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "Usuario no encontrado.";
    exit;
}

$usuario = $resultado->fetch_assoc();

// Procesar formulario
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
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
        font-size: 28px;
    }

    form {
        background: #fff;
        padding: 35px;
        border-radius: 16px;
        max-width: 600px;
        margin: auto;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    label {
        font-weight: 600;
        color: #444;
        margin-bottom: 6px;
        display: block;
    }

    input,
    select {
        width: 100%;
        padding: 14px 16px;
        border: 1px solid #ccc;
        border-radius: 10px;
        font-size: 15px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    input:focus,
    select:focus {
        border-color: #1976d2;
        outline: none;
        box-shadow: 0 0 0 4px rgba(25, 118, 210, 0.12);
    }

    .botones {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 10px;
    }

    button,
    .cancelar {
        padding: 14px 28px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.3s ease, transform 0.2s ease;
        text-decoration: none;
        font-size: 15px;
    }

    .guardar {
        background: #1976d2;
        color: #fff;
    }

    .guardar:hover {
        background: #125ea6;
        transform: translateY(-2px);
    }

    .cancelar {
        background: #a31818;
        color: #fff;
    }

    .cancelar:hover {
        background: #811212;
        transform: translateY(-2px);
    }

    @media (max-width: 640px) {
        form {
            padding: 25px;
            max-width: 90%;
        }

        .botones {
            flex-direction: column;
            gap: 12px;
        }

        button,
        .cancelar {
            width: 100%;
            text-align: center;
        }
    }
</style>
</head>

<body>

    <h2 style="text-align:center;">Editar Cliente #<?php echo $id; ?></h2>

    <form method="POST">
        <label>Nombre del cliente:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['Nombre_Cliente']); ?>" required>

        <label>Direccion de cliente:</label>
        <input type="text" name="direccion" value="<?php echo htmlspecialchars($usuario['Direc_Cliente']); ?>" required>

        <label>Telefono del cliente:</label>
        <input type="number" name="telefono" value="<?php echo htmlspecialchars($usuario['Telef_Cliente']); ?>" required>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="actualizar" value="1">
        <div class="botones">
            <button type="submit" class="guardar">Guardar Cambios</button>
            <a href="../public/clientes.php" class="cancelar">Cancelar</a>
        </div>
    </form>

</body>

</html>