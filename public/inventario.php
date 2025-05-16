<?php
session_start();
require_once '../server/conexion_bd.php'; 
require_once '../server/permisos.php';

// Consulta principal del inventario
$sql = "SELECT p.ID_Prod, p.Nomb_Prod, d.Descrip_Produc, p.Cant_Disp_Prod, 
               a.Direccion_Alm AS Almacen, p.Prec_Comp, p.Prec_vent, pr.Nomb_Prov, 
               c.Categoria_Nombre, p.Prod_Estatus, p.Fec_Cad, p.Desc_Prod
        FROM productos p
        LEFT JOIN almacen a ON p.ID_Almacen = a.ID_Almacen
        LEFT JOIN categoria c ON p.ID_Categoria = c.ID_Categoria
        LEFT JOIN proveedor pr ON p.ID_Prov = pr.ID_Prov
        LEFT JOIN descripcion_producto d ON p.ID_Descrip = d.ID_Descrip";

$resultado = $conexion->query($sql);

// Consultas para selects en el formulario


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script> 

   <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #e8f5e9; /* verde muy claro */
        margin: 0;
        padding: 20px;
    }

    main#main {
        padding: 20px;
    }

    h2 {
        text-align: center;
        color: #01579b; /* azul corporativo */
        margin-bottom: 20px;
        font-size: 28px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12); /* sombra suave */
        border-radius: 10px;
        overflow: hidden;
    }

    table th, table td {
        padding: 14px 18px;
        text-align: center;
        border: 1px solid #cfd8dc;
    }

    table th {
        background-color: #00695c; /* verde fuerte */
        color: #ffffff;
        font-weight: 600;
        font-size: 16px;
    }

    table tr:nth-child(even) {
        background-color: #e0f7fa; /* azul verdoso clarito */
    }

    table tr:nth-child(odd) {
        background-color: #ffffff;
    }

    table tr:hover {
        background-color: #b2ebf2; /* hover azul-verde suave */
    }

    table td {
        color: #37474f;
        font-size: 15px;
    }

    button {
        background-color: #00796b;
        color: #fff;
        border: none;
        padding: 10px 24px;
        font-size: 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    button:hover {
        background-color: #004d40;
        box-shadow: 0 2px 8px rgba(0,0,0,0.25);
    }

    #escaneoCont {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 999;
    }

    #lector {
        width: 80%;
        height: 60%;
        margin: 50px auto;
        background: #000;
        border-radius: 12px;
    }

    #escaneoCont button {
        position: absolute;
        top: 20px;
        right: 20px;
    }
</style>
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>

    <main id="main">

        <?php if (tienePermiso(['Encargado de Bodega','Gerente'])): ?>
        <!-- El boton :O-->
        <button onclick="ventanaEscaneo()" style="
            display: block;
            margin: 5px auto 1px;
            padding: 10px 20px;
            font-size: 16px;
        ">Escanear Código de Barras</button>
        <?php endif; ?>

        <h2>Inventario de Productos</h2>
        
        <!-- Barra de busqueda buscosa-->
        <input type="text" id="buscador" placeholder="Buscar por nombre del producto..." style="width: 100%; padding: 10px; margin-bottom: 15px; font-size: 16px;">

        <table border="1" cellspacing="0" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Almacén</th>
            <th>Precio Compra</th>
            <th>Precio Venta</th>
            <th>Proveedor</th>
            <th>Categoría</th>
            <th>Estatus</th>
            <th>Fecha Caducidad</th>
            <th>Descuento (%)</th>
            <th>Precio con Descuento</th>
        </tr>

            <?php
            if ($resultado && $resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    $precioVenta = (float)$fila["Prec_vent"];
                    $descuento = (int)$fila["Desc_Prod"];
                    $precioConDescuento = $precioVenta * (1 - ($descuento / 100));
                    echo "<tr>
                        <td>" . htmlspecialchars($fila["ID_Prod"]) . "</td>
                        <td>" . htmlspecialchars($fila["Nomb_Prod"]) . "</td>
                        <td>" . htmlspecialchars($fila["Descrip_Produc"]) . "</td>
                        <td>" . htmlspecialchars($fila["Cant_Disp_Prod"]) . "</td>
                        <td>" . htmlspecialchars($fila["Almacen"]) . "</td>
                        <td>$" . htmlspecialchars($fila["Prec_Comp"]) . "</td>
                        <td>$" . htmlspecialchars($fila["Prec_vent"]) . "</td>
                        <td>" . htmlspecialchars($fila["Nomb_Prov"]) . "</td>
                        <td>" . htmlspecialchars($fila["Categoria_Nombre"]) . "</td>
                        <td>" . ($fila["Prod_Estatus"] ? 'Activo' : 'Inactivo') . "</td>
                        <td>" . htmlspecialchars($fila["Fec_Cad"]) . "</td>
                        <td>" . htmlspecialchars($fila["Desc_Prod"]) . "</td>
                        <td>$" . number_format($precioConDescuento, 2) . "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='12'>No hay productos en el inventario.</td></tr>";
            }
            ?>
        </table>
    </main>

    <!-- Contenedor del escáner (temporal, ya que se ve feo jajaja, solo dalta darle diseño)-->
    <div id="escaneoCont" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:#000000c2; z-index:999;">
        <div id="lector" style="width:100%; height:60%; margin:auto;"></div>
        <button onclick="cerrarEscaner()" style="position:absolute; top:10px; right:10px;">Cerrar</button>
    </div>

    <!-- Ventana modal para el formulario -->
    <div id="modalForm" style="display:none; position:fixed; top:10%; left:30%; background:#fff; padding:20px; border:1px solid #ccc; z-index:2000;">
        <h3>Registrar Nuevo Producto</h3>
        <form id="productoForm" action="../server/p_codigoBarras.php" method="POST">
            <input type="hidden" name="ID_Prod" id="ID_Prod">

            <label>Nombre:</label><input type="text" name="Nomb_Prod" required><br>
            <label>Descuento (%):</label><input type="number" name="Desc_Prod" min="0" max="100" required><br>
            <label>Descripción:</label>
            <select name="ID_Descrip" required>
                <?php
                $descripciones = $conexion->query("SELECT ID_Descrip, Descrip_Produc FROM descripcion_producto");
                if ($descripciones && $descripciones->num_rows > 0) {
                    while ($d = $descripciones->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($d['ID_Descrip']) . '">' . htmlspecialchars($d['Descrip_Produc']) . '</option>';
                    }
                } else {
                    echo '<option value="">No hay descripciones</option>';
                }
                ?>
            </select><br>

            <label>Cantidad:</label><input type="number" name="Cant_Disp_Prod" required><br>

            <label>Almacén:</label>
            <select name="ID_Almacen" required>
                <?php
                $almacenes = $conexion->query("SELECT ID_Almacen, Direccion_Alm FROM almacen");
                if ($almacenes && $almacenes->num_rows > 0) {
                    while ($a = $almacenes->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($a['ID_Almacen']) . '">' . htmlspecialchars($a['Direccion_Alm']) . '</option>';
                    }
                } else {
                    echo '<option value="">No hay almacenes</option>';
                }
                ?>
            </select><br>
            <label>Precio Compra:</label><input type="number" step="0.01" name="Prec_Comp" required><br>
            <label>Precio Venta:</label><input type="number" step="0.01" name="Prec_vent" required><br>
            <label>Proveedor:</label>
            <select name="ID_Prov" required>
                <?php
                $proveedores = $conexion->query("SELECT ID_Prov, Nomb_Prov FROM proveedor");
                if ($proveedores && $proveedores->num_rows > 0) {
                    while ($p = $proveedores->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($p['ID_Prov']) . '">' . htmlspecialchars($p['Nomb_Prov']) . '</option>';
                    }
                } else {
                    echo '<option value="">No hay proveedores</option>';
                }
                ?>
            </select><br>

            <label>Categoría:</label>
            <select name="ID_Categoria" required>
                <?php
                $categorias = $conexion->query("SELECT ID_Categoria, Categoria_Nombre FROM categoria");
                if ($categorias && $categorias->num_rows > 0) {
                    while ($c = $categorias->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($c['ID_Categoria']) . '">' . htmlspecialchars($c['ID_Categoria']) . ' - ' . htmlspecialchars($c['Categoria_Nombre']) . '</option>';
                    }
                } else {
                    echo '<option value="">No hay categorías</option>';
                }
                ?>
            </select><br>

            <label>Estatus:</label>
            <select name="Prod_Estatus">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select><br>

            <label>Fecha Caducidad:</label><input type="date" name="Fec_Cad" required><br><br>

            <button type="submit">Guardar Producto</button>
            <button type="button" onclick="cerrarForm()">Cancelar</button>
        </form>
    </div>

    <!-- Ventana modal para selección de escaneo -->
    <div id="modalEscaneo" style="display:none; position:fixed; top:20%; left:35%; background:#fff; padding:20px; border:1px solid #ccc; z-index:1000;">
        <h3>Checar producteishon</h3>
        <div style="margin-top: 20px;">
            <button onclick="mostrarEscaner()">O escanear con la cámara</button>
            <button onclick="cerrarModalEscaneo()" style="margin-left: 10px;">Cancelar</button>
        </div>
    </div>
    <script src="js/script.js"></script>
    <script src="js/search.js"></script>
</body>
</html>
