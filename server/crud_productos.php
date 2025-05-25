<?php
session_start();
require_once '../server/conexion_bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $id = $_GET['id'];

    $sqlDelete = "DELETE FROM productos WHERE ID_Prod = ?";
    $stmtDelete = $conexion->prepare($sqlDelete);
    $stmtDelete->bind_param("s", $id);

    if ($stmtDelete->execute()) {
        header("Location: ../public/inventario.php");
        exit;
    } else {
        echo "<p style='color:red; text-align:center;'>Error al eliminar envio.</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $compra = $_POST['compra'];
    $almacen = $_POST['almacen'];
    $venta = $_POST['venta'];
    $proveedor = $_POST['proveedor'];
    $categoria = $_POST['categoria'];
    $estatus = $_POST['estatus'];
    $fecha = $_POST['fecha'];
    $descuento= $_POST['descuento'];

    $sqlUpdate = "UPDATE productos SET Nomb_Prod = ?, ID_Descrip = ?, Cant_Disp_Prod = ?, ID_Almacen = ?, Prec_Comp = ?, Prec_Vent = ?, ID_Prov = ?, ID_Categoria = ?, Prod_Estatus = ?, Fec_Cad = ?, Desc_Prod = ? WHERE ID_Prod = ?";
    $stmtUpdate = $conexion->prepare($sqlUpdate);
    $stmtUpdate->bind_param("ssssssssssss", $nombre, $descripcion, $cantidad, $almacen, $compra, $venta, $proveedor, $categoria, $estatus, $fecha, $descuento, $id);

    if ($stmtUpdate->execute()) {
        header("Location: ../public/inventario.php");
        exit;
    } else {
        echo "Error al actualizar.";
    }
}
// Verificar si se envió el ID por GET
if (!isset($_GET['id'])) {
    echo "ID de envio no especificado.";
    exit;
}

$id = $_GET['id'];

// Consultar los datos del usuario
$sql = "SELECT * FROM productos WHERE ID_Prod = ?";
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
    <title>Editar Producto</title>
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

<h2 style="text-align:center;">Editar Producto #<?php echo $id; ?></h2>

<form method="POST">

    <div class="form-row">
        <div class="form-group">
            <label>Nombre de Producto:</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['Nomb_Prod']); ?>" required>
        </div>

        <div class="form-group">
            <label>Descripción:</label>
            <input type="number" name="descripcion" value="<?php echo htmlspecialchars($usuario['ID_Descrip']); ?>" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Cantidad:</label>
           <input type="number" name="cantidad" value="<?php echo htmlspecialchars($usuario['Cant_Disp_Prod']); ?>" required>
        </div>

        <div class="form-group">
            <label>Almacen:</label>
             <input type="number" name="almacen" value="<?php echo htmlspecialchars($usuario['ID_Almacen']); ?>" required>
        </div>
    </div>

     <div class="form-row">
        <div class="form-group">
            <label>Precio De Compra:</label>
           <input type="number" name="compra" value="<?php echo htmlspecialchars($usuario['Prec_Comp']); ?>" required>
        </div>

        <div class="form-group">
            <label>Precio De Venta:</label>
             <input type="number" name="venta" value="<?php echo htmlspecialchars($usuario['Prec_Vent']); ?>" required>
        </div>
    </div>

         <div class="form-row">
        <div class="form-group">
            <label>ID del Proveedor:</label>
           <input type="number" name="proveedor" value="<?php echo htmlspecialchars($usuario['ID_Prov']); ?>" required>
        </div>

        <div class="form-group">
            <label>Categoria:</label>
             <input type="number" name="categoria" value="<?php echo htmlspecialchars($usuario['ID_Categoria']); ?>" required>
        </div>
    </div>

             <div class="form-row">
        <div class="form-group">
            <label>Estatus:</label>
          <select name="estatus" required>
                <option value="0" <?= $usuario['Prod_Estatus'] == "0" ? "selected" : "" ?>>0</option>
                <option value="1" <?= $usuario['Prod_Estatus'] == "1" ? "selected" : "" ?>>1</option>
            </select>
        </div>

        <div class="form-group">
            <label>Fecha de Caducidad:</label>
             <input type="date" name="fecha" value="<?php echo htmlspecialchars($usuario['Fec_Cad']); ?>" required>
        </div>
    </div>

                 <div class="form-row">
        <div class="form-group">
            <label>Descuento:</label>
    <input type="number" name="descuento" value="<?php echo htmlspecialchars($usuario['Desc_Prod']); ?>" required>

    </div>

    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="hidden" name="actualizar" value="1">

    <div class="botones">
        <button type="submit" class="guardar">Guardar Cambios</button>
        <a href="../public/inventario.php" class="cancelar">Cancelar</a>
    </div>
</form>

</body>
</html>
