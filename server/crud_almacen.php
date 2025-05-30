<?php
session_start();
require_once '../server/conexion_bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $id = $_GET['id'];

    $sqlDelete = "DELETE FROM almacen WHERE ID_Almacen = ?";
    $stmtDelete = $conexion->prepare($sqlDelete);
    $stmtDelete->bind_param("s", $id);

    if ($stmtDelete->execute()) {
        header("Location: ../public/almacen.php");
        exit;
    } else {
        echo "<p style='color:red; text-align:center;'>Error al eliminar envio.</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    $encargado = $_POST['encargado'];


    $sqlInsert = "INSERT INTO almacen (Encarga_Alm)
    VALUES (?)";
    $stmtInsert = $conexion->prepare($sqlInsert);
    $stmtInsert->bind_param("s",$encargado);

    if ($stmtInsert->execute()) {
        header("Location: ../public/almacen.php");
        exit;
    } else {
        echo "<p style='color:red; text-align:center;'>Error al agregar envio.</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    // Actualizar usuario
    $id = $_POST['id'];
    $encargado = $_POST['encargado'];

    $sqlUpdate = "UPDATE almacen SET Encarga_Alm = ? WHERE ID_Almacen = ?";
    $stmtUpdate = $conexion->prepare($sqlUpdate);
    $stmtUpdate->bind_param("ss", $encargado, $id);

    if ($stmtUpdate->execute()) {
        header("Location: ../public/almacen.php");
        exit;
    } else {
        echo "Error al actualizar.";
    }
}
// Verificar si se envió el ID por GET
if (!isset($_GET['id'])) {
    echo "ID de almacen no especificado.";
    exit;
}

$id = $_GET['id'];

// Consultar los datos del usuario
$sql = "SELECT * FROM almacen WHERE ID_Almacen = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "Almacen no encontrado.";
    exit;
}

$usuario = $resultado->fetch_assoc();

// Procesar formulario
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

<h2 style="text-align:center;">Editar Almacen #<?php echo $id; ?></h2>

   <form method="POST">

        <label>Encargado de Almacen:</label>
        <input type="text" name="encargado" value="<?php echo htmlspecialchars($usuario['Encarga_Alm']); ?>" required>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="actualizar" value="1">
        <div class="botones">
            <button type="submit" class="guardar">Guardar Cambios</button>
            <a href="../public/almacen.php" class="cancelar">Cancelar</a>
        </div>
    </form>
</body>
</html>
