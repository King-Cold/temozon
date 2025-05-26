<?php
require_once '../server/permisos.php';
?>
<div class="sidebar" id="sidebar">
    <nav>
        <ul>
            <li>
                <a href="inicio.php" >
                    <img src="../Icons/home-svgrepo-com.svg" alt="Home">
                    <span>DASHBOARD</span>
                </a>
            </li>
            <li>
                <a href="inventario.php" >
                    <img src="../Icons/product-guide-svgrepo-com.svg" alt="Inventario">
                    <span>INVENTARIO</span>
                </a>
            </li>
            <?php if (tienePermiso(['Administrador', 'Gerente', 'Encargado de Bodega', 'Empleado Auxilar'])): ?>
            <li>
                <a href="envios.php">
                    <img src="../Icons/lorry-svgrepo-com.svg" alt="Envios">
                    <span>ENVIOS</span>
                </a>
            </li>
            <li>
                <a href="pedidos.php">
                    <img src="../Icons/list-check-svgrepo-com.svg" alt="Pedidos">
                    <span>PEDIDOS</span>
                </a>
            </li>
            <?php endif; ?>
            <li>
                <a href="proveedores.php">
                    <img src="../Icons/building-user-svgrepo-com.svg" alt="Proveedores">
                    <span>PROVEEDORES</span>
                </a>
            </li>
            <?php if (tienePermiso(['Administrador'])): ?>
            <li>
                <a href="almacen.php">
                    <img src="../Icons/almacen.svg" alt="Usuarios">
                    <span>ALMACEN</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if (tienePermiso(['Administrador'])): ?>
            <li>
                <a href="usuarios.php">
                    <img src="../Icons/users-group-svgrepo-com.svg" alt="Usuarios">
                    <span>USUARIOS</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if (tienePermiso(['Administrador', 'Gerente', 'Encargado de Bodega', 'Empleado Auxilar'])): ?>
            <li>
                <a href="clientes.php">
                    <img src="../Icons/contentment-customer-feedback-svgrepo-com.svg" alt="Envios">
                    <span>CLIENTES</span>
                </a>
            </li>
            <?php endif; ?>
            
        </ul>
    </nav>
</div>
