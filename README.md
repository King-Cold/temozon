# VETERINARIA TEMOZON
- LETICIA MONSERRAT HAU CATZIN 
- HERMIONE SHARIS PECH POOT
- ANGELES MARGARITA OLVERA CASTAÑEDA 
- TOMAS URIEL VILLANUEVA MORA 
- RODRIGO ALEJANDRO CHI CATZIM

***
## ROLES
- Administrador
- Encargado de Bodega
- Gerente
- Empleado Auxilar

## PERMISOS SEGUN ROL
### INVENTARIO 
> Todos lo ven

| ROL                 | SOLO LECTURA | CRUD completo |
| ------------------- | ------------ | ------------- |
| Administrador       | ✅            |               |
| Encargado de Bodega |              | ✅             |
| Gerente             |              | ✅             |
| Empleado Auxilar    | ✅            |               |

### ENVIOS 
> Solo lo ve Encargado de Bodega y Empleado Auxilar

| ROL                 | SOLO LECTURA | CRUD completo |
| ------------------- | ------------ | ------------- |
| Encargado de Bodega |              | ✅             |
| Empleado Auxilar    | ✅            |               |

### PEDIDOS
> Solo lo ve Encargado de Bodega y Empleado Auxilar

| ROL                 | SOLO LECTURA | CRUD completo |
| ------------------- | ------------ | ------------- |
| Encargado de Bodega |              | ✅             |
| Empleado Auxilar    | ✅            |               |

### PROVEEDORES
> Todos lo ven

| ROL                 | SOLO LECTURA | CRUD completo |
| ------------------- | ------------ | ------------- |
| Administrador       | ✅            |               |
| Encargado de Bodega |              | ✅             |
| Gerente             |              | ✅             |
| Empleado Auxilar    | ✅            |               |

### USUARIOS
> Solo Administrador

| ROL                 | SOLO LECTURA | CRUD completo |
| ------------------- | ------------ | ------------- |
| Administrador       |              |  ✅           |

### Clientes
> Solo lo ve Encargado de Bodega y Gerente

| ROL                 | SOLO LECTURA | CRUD completo |
| ------------------- | ------------ | ------------- |
| Encargado de Bodega |              | ✅           |
| Gerente             | ✅           |              |

