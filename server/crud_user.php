<?php
session_start();
require_once '../server/conexion_bd.php';

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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['eliminar'])) {
        // Eliminar el usuario
        $sqlDelete = "DELETE FROM usuario WHERE ID_Usuario = ?";
        $stmtDelete = $conexion->prepare($sqlDelete);
        $stmtDelete->bind_param("s", $id);

        if ($stmtDelete->execute()) {
            header("Location: ../public/usuarios.php");
            exit;
        } else {
            echo "Error al eliminar el usuario.";
        }
    } else {
        // Actualizar el usuario
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
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar o Eliminar Usuario</title>
    <style>
        body { font-family: sans-serif; background: #f4f6f8; padding: 20px; }
        form { background: #fff; padding: 20px; border-radius: 8px; max-width: 500px; margin: auto; }
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 20px; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; }
        .guardar { background: #1976d2; color: #fff; }
        .guardar:hover { background: #125ea6; }
        .eliminar { background: #d32f2f; color: #fff; margin-left: 10px; }
        .eliminar:hover { background: #a31818; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Editar o Eliminar Usuario #<?php echo $id; ?></h2>

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

    <div style="display: flex; justify-content: center;">
        <button type="submit" class="guardar">Guardar Cambios</button>
        <button type="submit" name="eliminar" value="1" class="eliminar" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar Usuario</button>
    </div>
</form>

</body>
</html>
