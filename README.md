# VETERINARIA TEMOZON
***
## ROLES
- Administrador
- Encargado de Bodega
- Gerente
- Empleado Auxilar
***
## Estados de Envio
- Pendiente
- En transito
- Entregado
- Cancelado
***
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
> Todos lo ven

| ROL                 | SOLO LECTURA | CRUD completo |
| ------------------- | ------------ | ------------- |
| Administrador       | ✅            |               |
| Gerente             | ✅            |               |
| Encargado de Bodega |              | ✅             |
| Empleado Auxilar    | ✅            |               |

### PEDIDOS
> Todos lo ven

| ROL                 | SOLO LECTURA | CRUD completo |
| ------------------- | ------------ | ------------- |
| Administrador       | ✅            |               |
| Gerente             | ✅            |               |
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

| ROL           | SOLO LECTURA | CRUD completo |
| ------------- | ------------ | ------------- |
| Administrador |              | ✅             |

### Clientes
> Solo lo ve Encargado de Bodega y Gerente

| ROL                 | SOLO LECTURA | CRUD completo |
| ------------------- | ------------ | ------------- |
| Encargado de Bodega | ✅            |               |
| Gerente             |              | ✅             |

### Almacen
> Solo lo ve Administrador y Gerente

| ROL           | SOLO LECTURA | CRUD completo |
| ------------- | ------------ | ------------- |
| Administrador |              | ✅             |
| Gerente       |              | ✅             |

