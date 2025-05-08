<?php
function tienePermiso($rolesPermitidos) {
    if (!isset($_SESSION['rol'])) return false;
    return in_array($_SESSION['rol'], $rolesPermitidos);
}

/*
<?php if (tienePermiso(['rol'])): ?>
<?php endif; ?>
*/