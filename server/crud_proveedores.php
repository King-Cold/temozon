<?php
session_start();
require_once '../server/conexion_bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $id = $_GET['id'];

    $sqlDelete = "DELETE FROM cliente WHERE ID_Cliente = ?";
    $stmtDelete = $conexion->prepare($sqlDelete);
    $stmtDelete->bind_param("s", $id);

    if ($stmtDelete->execute()) {
        header("Location: ../public/proveedores.php");
        exit;
    } else {
        echo "<p style='color:red; text-align:center;'>Error al eliminar usuario.</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    $usuario = $_POST['nombre'];
    $telefono = $_POST['telefono'];
     $tipo = $_POST['tipo'];
    $cambio = $_POST['cambio'];
    $direccion = $_POST['direccion'];


    $sqlInsert = "INSERT INTO proveedor (Nomb_Prov, Telefono_Prov, Tipo_Prov, Manejo_Camb, Direccion_Prov)
    VALUES (?, ?, ?, ?, ?)";
    $stmtInsert = $conexion->prepare($sqlInsert);
    $stmtInsert->bind_param("sssss", $usuario,  $telefono,$tipo, $cambio, $direccion);

    if ($stmtInsert->execute()) {
        header("Location: ../public/proveedores.php");
        exit;
    } else {
        echo "<p style='color:red; text-align:center;'>Error al agregar proveedor.</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    // Actualizar usuario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
     $tipo = $_POST['tipo'];
    $cambio = $_POST['cambio'];
    $direccion = $_POST['direccion'];

    $sqlUpdate = "UPDATE proveedor SET 	Nomb_Prov = ?, Telefono_Prov = ?, Tipo_Prov = ?, Manejo_Camb = ? , Direccion_Prov = ?  WHERE ID_Prov = ?";
    $stmtUpdate = $conexion->prepare($sqlUpdate);
    $stmtUpdate->bind_param("ssssss", $nombre, $telefono, $tipo, $cambio, $direccion, $id);

    if ($stmtUpdate->execute()) {
        header("Location: ../public/proveedores.php");
        exit;
    } else {
        echo "Error al actualizar.";
    }
}
// Verificar si se envió el ID por GET
if (!isset($_GET['id'])) {
    echo "ID de proveedor no especificado.";
    exit;
}

$id = $_GET['id'];

// Consultar los datos del usuario
$sql = "SELECT * FROM proveedor WHERE ID_Prov = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "Proveedor no encontrado.";
    exit;
}

$usuario = $resultado->fetch_assoc();

// Procesar formulario
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Proveedor</title>
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
        padding: 40px;
        border-radius: 16px;
        max-width: 700px;
        margin: auto;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

.form-row {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.form-group {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-width: 100px;
}

    label {
        font-weight: 600;
        color: #444;
        margin-bottom: 6px;
    }

    input,
    select {
        padding: 12px 14px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    input:focus,
    select:focus {
        border-color: #1976d2;
        outline: none;
        box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.12);
    }

    .botones {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 10px;
        flex-wrap: wrap;
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
            max-width: 95%;
        }

        .form-row {
            flex-direction: column;
        }

        .botones {
            flex-direction: column;
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

    <h2 style="text-align:center;">Editar Proveedor #<?php echo $id; ?></h2>

<form method="POST">

    <div class="form-row">
        <div class="form-group">
            <label>Nombre de Proveedor:</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['Nomb_Prov']); ?>" required>
        </div>

        <div class="form-group">
            <label>Teléfono del Proveedor:</label>
            <input type="number" name="telefono" value="<?php echo htmlspecialchars($usuario['Telefono_Prov']); ?>" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Tipo:</label>
            <select name="tipo" required>
                <option value="Mayorista" <?= $usuario['Tipo_Prov'] == "Mayorista" ? "selected" : "" ?>>Mayorista</option>
                <option value="Minorista" <?= $usuario['Tipo_Prov'] == "Minorista" ? "selected" : "" ?>>Minorista</option>
            </select>
        </div>

        <div class="form-group">
            <label>¿Maneja Cambios?:</label>
            <select name="cambio" required>
                <option value="0" <?= $usuario['Manejo_Camb'] == "0" ? "selected" : "" ?>>0</option>
                <option value="1" <?= $usuario['Manejo_Camb'] == "1" ? "selected" : "" ?>>1</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group" style="flex: 1;">
            <label>Dirección del Proveedor:</label>
            <input type="text" name="direccion" value="<?php echo htmlspecialchars($usuario['Direccion_Prov']); ?>" required>
        </div>
    </div>

    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="hidden" name="actualizar" value="1">

    <div class="botones">
        <button type="submit" class="guardar">Guardar Cambios</button>
        <a href="../public/proveedores.php" class="cancelar">Cancelar</a>
    </div>
</form>


</body>

</html>