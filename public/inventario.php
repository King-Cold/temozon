<?php
session_start();
require_once '../server/conexion_bd.php';
require_once '../server/permisos.php';

// Consulta principal del inventario
$sql = "SELECT 
  p.ID_Prod, 
  p.Nomb_Prod, 
  d.Descrip_Produc, 
  p.Cant_Disp_Prod, 
  a.ID_Almacen AS ID_Almacen, -- Aquí el ID del almacén
  u.Nombre_Usuario AS Encargado_Almacen, -- Aquí el nombre del encargado
  p.Prec_Comp, 
  p.Prec_vent, 
  pr.Nomb_Prov, 
  c.Categoria_Nombre, 
  p.Prod_Estatus, 
  p.Fec_Cad, 
  p.Desc_Prod
FROM productos p
LEFT JOIN almacen a ON p.ID_Almacen = a.ID_Almacen
LEFT JOIN usuario u ON a.Encarga_Alm = u.ID_Usuario -- Este es el join importante
LEFT JOIN categoria c ON p.ID_Categoria = c.ID_Categoria
LEFT JOIN proveedor pr ON p.ID_Prov = pr.ID_Prov
LEFT JOIN descripcion_producto d ON p.ID_Descrip = d.ID_Descrip;";

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
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f0f0;
            padding: 20px;
        }

        main#main {
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333333;
            margin-bottom: 25px;
            font-size: 30px;
            letter-spacing: 0.5px;
        }

        table {
            width: 95%;
            margin: auto;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(51, 51, 51, 0.2);
            border-radius: 10px;
            overflow: hidden;
        }

        table th,
        table td {
            padding: 14px 18px;
            text-align: center;
            border: 1px solid #e0e0e0;
        }

        table th {
            background-color: #2ECC71;
            color: #ffffff;
            font-weight: 600;
            font-size: 16px;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:nth-child(odd) {
            background-color: #eeeeee;
        }

        table tr:hover {
            background-color: #d6d6d6;
            transition: background-color 0.3s ease;
        }

        table td {
            color: #333333;
            font-size: 14.5px;
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
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
        }

            .btn {
        padding: 8px 14px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
        color: #fff;
        margin: 2px;
        display: inline-block;
        transition: background-color 0.3s ease, box-shadow 0.2s ease;
    }

    .btn-edit {
        background-color:rgb(40, 49, 163);
    }

    .btn-edit:hover {
        background-color:rgb(70, 64, 161);
        box-shadow: 0 2px 6px rgba(106, 27, 154, 0.4);
    }

    .btn-delete {
        background-color:rgb(188, 71, 87);
    }

    .btn-delete:hover {
        background-color:rgb(176, 39, 39);
        box-shadow: 0 2px 6px rgba(156, 39, 176, 0.4);
    }
        .btn-add {
        background-color: #388e3c;
    }

    .btn-add:hover {
        background-color: #2e7d32;
        box-shadow: 0 2px 6px rgba(76, 175, 80, 0.4);
    }

       
        #escaneoCont {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.85);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        #lector {
            width: 80%;
            max-width: 600px;
            height: 400px;
            background: #000;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0,0,0,0.6);
        }

        #escaneoCont button {
            margin-top: 20px;
            background: #ef5350;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            color: #fff;
            cursor: pointer;
        }

        .modal-content {
    background-color: #fff;
    margin: 60px auto;
    padding: 35px 30px;
    border-radius: 16px;
    width: 55%;
    max-width: 720px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
    animation: fadeIn 0.4s ease;
    border: 1px solid #e0d7f3;
}

.modal-content h2 {
    color: #8e24aa;
    margin-bottom: 25px;
    text-align: center;
    font-size: 26px;
    letter-spacing: 0.5px;
}

#modalForm {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    z-index: 2000;
    width: 450px;
    max-width: 95%;
    max-height: 90vh;
    overflow-y: auto;
    font-family: 'Arial', sans-serif;
}

#modalForm h3 {
    margin-top: 0;
    margin-bottom: 20px;
    text-align: center;
    color: #333;
}

#productoForm {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1.5fr;
    gap: 10px;
    align-items: center;
}

.form-row label {
    font-weight: bold;
    color: #555;
    font-size: 14px;
}

.form-row input[type="text"],
.form-row input[type="number"],
.form-row input[type="date"],
.form-row select {
    padding: 8px 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
    transition: border 0.3s;
    width: 100%;
    box-sizing: border-box;
}

.form-row input:focus,
.form-row select:focus {
    border-color: #008cba;
    outline: none;
}

.form-buttons {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    margin-top: 15px;
}

.btn-primary, .btn-secondary {
    flex: 1;
    padding: 10px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    transition: background 0.3s;
}

.btn-primary {
    background-color: #008cba;
    color: #fff;
}

.btn-primary:hover {
    background-color: #006e96;
}

.btn-secondary {
    background-color: #ccc;
    color: #333;
}

.btn-secondary:hover {
    background-color: #b3b3b3;
}

/* Responsive: si la pantalla es muy estrecha, las filas se vuelven columna */
@media (max-width: 500px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}

.producto-item {
    background: #f3e5f5;
    padding: 18px;
    border-radius: 12px;
    margin-bottom: 20px;
    border: 1px solid #e1bee7;
}

.producto-item label {
    margin-top: 10px;
    color: #4a148c;
    font-weight: 600;
}

.modal-content .btn {
    width: auto;
    display: inline-block;
    margin-top: 12px;
    font-weight: bold;
    padding: 11px 20px;
    border-radius: 8px;
    transition: background-color 0.3s ease, box-shadow 0.2s ease;
}

.close {
    color: #999;
    float: right;
    font-size: 32px;
    font-weight: bold;
    cursor: pointer;
    transition: color 0.2s ease;
}

.close:hover {
    color: #d32f2f;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>

    <main id="main">

        <?php if (tienePermiso(['Encargado de Bodega', 'Gerente'])): ?>
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
                <th>Categoría</th>
                <th>ID Almacen</th>
                <th>Encargado de Almacen</th>
                <th>Precio Compra</th>
                <th>Precio Venta</th>
                <th>Proveedor</th>
                <th>Estatus</th>
                <th>Fecha Caducidad</th>
                <th>Descuento (%)</th>
                <th>Precio con Descuento</th>
                <?php if (tienePermiso(['Encargado de Bodega','Gerente'])): ?>
                <th>Acciones</th>
                <?php endif; ?>
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
                        <td>" . htmlspecialchars($fila["Categoria_Nombre"]) . "</td>
                        <td>" . htmlspecialchars($fila["ID_Almacen"]) . "</td>
                        <td>" . htmlspecialchars($fila["Encargado_Almacen"]) . "</td>
                        <td>$" . htmlspecialchars($fila["Prec_Comp"]) . "</td>
                        <td>$" . htmlspecialchars($fila["Prec_vent"]) . "</td>
                        <td>" . htmlspecialchars($fila["Nomb_Prov"]) . "</td>
                        <td>" . ($fila["Prod_Estatus"] ? 'Activo' : 'Inactivo') . "</td>
                        <td>" . htmlspecialchars($fila["Fec_Cad"]) . "</td>
                        <td>" . htmlspecialchars($fila["Desc_Prod"]) . "</td>
                        <td>$" . number_format($precioConDescuento, 2) . "</td>";
                        if (tienePermiso(['Encargado de Bodega','Gerente'])) {
                            echo "<td>
                                <a class='btn btn-edit' href='../server/crud_productos.php?id=" . $fila["ID_Prod"] . "'>Modificar</a>
                                    <form method='POST' action='../server/crud_productos.php?id=" . $fila["ID_Prod"] . "' style='display:inline;' onsubmit=\"return confirm('¿Seguro que deseas eliminar este envío?');\">
                                    <input type='hidden' name='eliminar' value='1'>
                                    <button type='submit' class='btn btn-delete'>Dar de baja</button>
                                </form>
                            </td>
                            </tr>";
                        }      
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
   <div id="modalForm">
    <h3>Registrar Nuevo Producto</h3>
    <form id="productoForm" action="../server/p_codigoBarras.php" method="POST">
        <input type="hidden" name="ID_Prod" id="ID_Prod">

        <div class="form-row">
            <label>Nombre:</label>
            <input type="text" name="Nomb_Prod" required>
        </div>

        <div class="form-row">
            <label>Descuento (%):</label>
            <input type="number" name="Desc_Prod" min="0" max="100" required>

            <label>Cantidad:</label>
            <input type="number" name="Cant_Disp_Prod" required>
        </div>

      <div class="form-row">
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
    </select>

    <label>Almacén:</label>
    <select name="ID_Almacen" required>
        <?php
        $almacenes = $conexion->query("SELECT ID_Almacen FROM almacen");
        if ($almacenes && $almacenes->num_rows > 0) {
            while ($a = $almacenes->fetch_assoc()) {
                echo '<option value="' . htmlspecialchars($a['ID_Almacen']) . '">Almacén #' . htmlspecialchars($a['ID_Almacen']) . '</option>';
            }
        } else {
            echo '<option value="">No hay almacenes</option>';
        }
        ?>
    </select>
</div>

        <div class="form-row">
            <label>Precio Compra:</label>
            <input type="number" step="0.01" name="Prec_Comp" required>

            <label>Precio Venta:</label>
            <input type="number" step="0.01" name="Prec_vent" required>
        </div>

        <div class="form-row">
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
    </select>

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
    </select>
</div>

        <div class="form-row">
            <label>Estatus:</label>
            <select name="Prod_Estatus">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>

            <label>Fecha Caducidad:</label>
            <input type="date" name="Fec_Cad" required>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-primary">Guardar</button>
            <button type="button" class="btn-secondary" onclick="cerrarForm()">Cancelar</button>
        </div>
    </form>
</div>

    <!-- Ventana modal para selección de escaneo -->
    <div id="modalEscaneo" style="display:none; position:fixed; top:20%; left:35%; background:#fff; padding:20px; border:1px solid #ccc; z-index:1000;">
        <h3>Escanea el producto</h3>
        <div style="margin-top: 20px;">
            <button onclick="mostrarEscaner()">O escanear con la cámara</button>
            <button onclick="cerrarModalEscaneo()" style="margin-left: 10px;">Cancelar</button>
        </div>
    </div>
    <script src="js/script.js"></script>
    <script src="js/search.js"></script>
    <script>
        const modalForm = document.getElementById("modalForm");
        const modalEscaneo = document.getElementById("modalEscaneo");

        const checador = new MutationObserver(() => {
            const tasviendo = getComputedStyle(modalForm).display === "block";
            if (tasviendo) {

                if (modalEscaneo.style.display === "block") {
                    modalEscaneo.style.display = "none";
                }
            }
        });
        
        checador.observe(modalForm, { attributes: true, attributeFilter: ['style'] });
    </script>
</body>

</html>