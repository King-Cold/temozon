<?php
session_start();
require_once '../server/conexion_bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $id = $_GET['id'];

    $sqlDelete = "DELETE FROM usuario WHERE ID_Usuario = ?";
    $stmtDelete = $conexion->prepare($sqlDelete);
    $stmtDelete->bind_param("s", $id);

    if ($stmtDelete->execute()) {
        header("Location: ../public/usuarios.php");
        exit;
    } else {
        echo "<p style='color:red; text-align:center;'>Error al eliminar usuario.</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    $usuario = $_POST['nombre'];
    $rol = $_POST['rol'];
    $email = $_POST['email'];
    $password = $_POST['contrasena'];

    $sqlInsert = "INSERT INTO usuario (Nombre_Usuario, Rol, Email, Contraseña)
                  VALUES (?, ?, ?, ?)";
    $stmtInsert = $conexion->prepare($sqlInsert);
    $stmtInsert->bind_param("ssss", $usuario, $rol, $email, $password);

    if ($stmtInsert->execute()) {
        header("Location: ../public/usuarios.php");
        exit;
    } else {
        echo "<p style='color:red; text-align:center;'>Error al agregar usuario.</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    // Actualizar usuario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $rol = $_POST['rol'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    $sqlUpdate = "UPDATE usuario SET Nombre_Usuario = ?, Rol = ?, Email = ?, Contraseña = ? WHERE ID_Usuario = ?";
    $stmtUpdate = $conexion->prepare($sqlUpdate);
    $stmtUpdate->bind_param("sssss", $nombre, $rol, $email, $contrasena, $id);

    if ($stmtUpdate->execute()) {
        header("Location: ../public/usuarios.php");
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
$sql = "SELECT * FROM usuario WHERE ID_Usuario = ?";
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

<h2 style="text-align:center;">Editar Usuario #<?php echo $id; ?></h2>

<form method="POST">
    <label>Nombre de Usuario:</label>
    <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['Nombre_Usuario']); ?>" required>

    <label>Rol:</label>
    <select name="rol" required>
        <option value="Administrador" <?= $usuario['Rol'] == "Administrador" ? "selected" : "" ?>>Administrador</option>
        <option value="Encargado de Bodega" <?= $usuario['Rol'] == "Encargado de Bodega" ? "selected" : "" ?>>Encargado de Bodega</option>
        <option value="Gerente" <?= $usuario['Rol'] == "Gerente" ? "selected" : "" ?>>Gerente</option>
        <option value="Empleado Auxilar" <?= $usuario['Rol'] == "Empleado Auxilar" ? "selected" : "" ?>>Empleado Auxilar</option>
    </select>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($usuario['Email']); ?>" required>

    <label>Contraseña:</label>
    <input type="text" name="contrasena" value="<?php echo htmlspecialchars($usuario['Contraseña']); ?>" required>
<input type="hidden" name="id" value="<?php echo $id; ?>">
<input type="hidden" name="actualizar" value="1">
<div class="botones">
    <button type="submit" class="guardar">Guardar Cambios</button>
    <a href="../public/usuarios.php" class="cancelar">Cancelar</a>
</div>
</form>

</body>
</html>
