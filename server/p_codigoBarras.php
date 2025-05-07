<?php
require_once '../server/conexion_bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Recolectar datos del formulario
    $id_producto = $_POST['ID_Prod'];
    $nombre = $_POST['Nomb_Prod'];
    $descuento = $_POST['Desc_Prod'];
    $lote = $_POST['Lote_Prod'];
    $cantidad = $_POST['Cant_Disp_Prod'];
    $almacen_id = $_POST['ID_Almacen'];
    $precio_compra = $_POST['Prec_Comp'];
    $precio_venta = $_POST['Prec_vent'];
    $proveedor = $_POST['Nombre_Prov'];
    $categoria_id = $_POST['ID_Categoria'];
    $estatus = isset($_POST['Prod_Estatus']) ? $_POST['Prod_Estatus'] : 1;
    $fecha_caducidad = $_POST['Fec_Cad'];

    function mostrarError($mensaje) {
        echo "<script>alert('$mensaje');</script>";
        exit;
    }

    function registroExiste($conexion, $tabla, $columna, $valor) {
        $stmt = $conexion->prepare("SELECT 1 FROM $tabla WHERE $columna = ?");
        $stmt->bind_param("s", $valor);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    // Aqui se valida que el codigo de barras no este duplicado
    $stmtCheckID = $conexion->prepare("SELECT 1 FROM productos WHERE ID_Prod = ?");
    $stmtCheckID->bind_param("s", $id_producto);
    $stmtCheckID->execute();
    $stmtCheckID->store_result();

    if ($stmtCheckID->num_rows > 0) {
        mostrarError("Ya existe un producto con el código de barras \"$id_producto\".");
    }

    // Por si falla el invento de las claves foraneas de la tabla productos (no tan necesario)
    if (!registroExiste($conexion, 'proveedor', 'Nomb_Prov', $proveedor)) {
        mostrarError("El proveedor '$proveedor' no existe.");
    }

    if (!registroExiste($conexion, 'almacen', 'ID_Almacen', $almacen_id)) {
        mostrarError("El almacén '$almacen_id' no existe.");
    }

    if (!registroExiste($conexion, 'categoria', 'ID_Categoria', $categoria_id)) {
        mostrarError("La categoría '$categoria_id' no existe.");
    }

    // Validacion que la fecha no esté vacía
    if (empty($fecha_caducidad)) {
        mostrarError("Debes ingresar una fecha de caducidad válida.");
    }

    // Insertar el producto en la base de datos
    $sql = "INSERT INTO productos (
                ID_Prod, Nomb_Prod, Desc_Prod, Lote_Prod, Cant_Disp_Prod,
                ID_Almacen, Prec_Comp, Prec_vent, Nombre_Prov,
                ID_Categoria, Prod_Estatus, Fec_Cad
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    if ($stmt === false) {
        mostrarError("Error al preparar la consulta: " . $conexion->error);
    }

    $stmt->bind_param(
        "ssssisddssis",
        $id_producto,
        $nombre,
        $descuento,
        $lote,
        $cantidad,
        $almacen_id,
        $precio_compra,
        $precio_venta,
        $proveedor,
        $categoria_id,
        $estatus,
        $fecha_caducidad
    );

    if ($stmt->execute()) {
        echo "<script>
            alert('Producto guardado correctamente.');
            window.location.href = '../public/inventario.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al guardar el producto: " . addslashes($stmt->error) . "');
            window.location.href = '../public/inventario.php';
        </script>";
    }

    $stmt->close();
    $conexion->close();
}
?>