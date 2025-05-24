-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-05-2025 a las 01:54:21
-- Versión del servidor: 10.4.32-MariaDB-log
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dvgt`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `ID_Almacen` int(6) NOT NULL,
  `Encarga_Alm` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`ID_Almacen`, `Encarga_Alm`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 8),
(5, 8),
(6, 8);

--
-- Disparadores `almacen`
--
DELIMITER $$
CREATE TRIGGER `after_almacen_delete` AFTER DELETE ON `almacen` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Delete', 'Almacen', CONCAT('Se eliminó almacen ID: ', OLD.ID_Almacen), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_almacen_insert` AFTER INSERT ON `almacen` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Insert', 'Almacen', CONCAT('Se insertó almacen ID: ', NEW.ID_Almacen), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_almacen_update` AFTER UPDATE ON `almacen` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Update', 'Almacen', CONCAT('Se actualizó almacen ID: ', NEW.ID_Almacen), NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id` int(11) NOT NULL,
  `accion` varchar(100) DEFAULT NULL,
  `tabla_afectada` varchar(100) DEFAULT NULL,
  `detalle` text DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id`, `accion`, `tabla_afectada`, `detalle`, `fecha_hora`) VALUES
(1, 'Update', 'productos', 'Se actualizó el producto con ID: 02417219', '2025-05-21 20:03:51'),
(2, 'Update', 'cliente', 'Se actualizó cliente ID: 6', '2025-05-21 20:13:39'),
(3, 'Update', 'usuario', 'Se actualizó usuario ID: 1', '2025-05-21 20:15:15'),
(4, 'Insert', 'usuario', 'Se insertó usuario ID: 10', '2025-05-21 20:19:11'),
(5, 'Update', 'Usuario', 'Se actualizó usuario ID: 10', '2025-05-21 20:27:20'),
(6, 'Update', 'Usuario', 'Se actualizó usuario ID: 9', '2025-05-21 20:44:02'),
(7, 'Delete', 'Usuario', 'Se eliminó usuario ID: 9', '2025-05-21 20:44:32'),
(8, 'Update', 'Usuario', 'Se actualizó usuario ID: 10', '2025-05-21 20:49:21'),
(9, 'Update', 'Usuario', 'Se actualizó usuario ID: 10', '2025-05-21 20:49:31'),
(10, 'Update', 'Usuario', 'Se actualizó usuario ID: 1', '2025-05-21 20:49:54'),
(11, 'Update', 'Usuario', 'Se actualizó usuario ID: 1', '2025-05-21 20:50:16'),
(12, 'Update', 'Cliente', 'Se actualizó cliente ID: 1', '2025-05-21 20:55:16'),
(13, 'Update', 'Usuario', 'Se actualizó usuario ID: 7', '2025-05-22 07:38:49'),
(14, 'Update', 'Usuario', 'Se actualizó usuario ID: 1', '2025-05-22 07:39:36'),
(15, 'Insert', 'Pedido', 'Se insertó pedido ID: 7', '2025-05-23 08:10:55'),
(16, 'Insert', 'Detalle_pedido', 'Se insertó detalle pedido ID: 1', '2025-05-23 08:10:55'),
(17, 'Insert', 'Detalle_pedido', 'Se insertó detalle pedido ID: 2', '2025-05-23 08:10:55'),
(18, 'Update', 'Almacen', 'Se actualizó almacen ID: 1', '2025-05-24 16:59:05'),
(19, 'Update', 'Almacen', 'Se actualizó almacen ID: 1', '2025-05-24 16:59:15'),
(20, 'Update', 'Almacen', 'Se actualizó almacen ID: 2', '2025-05-24 16:59:22'),
(21, 'Update', 'Almacen', 'Se actualizó almacen ID: 3', '2025-05-24 17:00:43'),
(22, 'Update', 'Almacen', 'Se actualizó almacen ID: 4', '2025-05-24 17:00:51'),
(23, 'Update', 'Almacen', 'Se actualizó almacen ID: 5', '2025-05-24 17:00:59'),
(24, 'Update', 'Almacen', 'Se actualizó almacen ID: 6', '2025-05-24 17:01:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `ID_Categoria` int(6) NOT NULL,
  `Categoria_Nombre` varchar(40) NOT NULL,
  `Categoria_Descripcion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`ID_Categoria`, `Categoria_Nombre`, `Categoria_Descripcion`) VALUES
(1, 'Antibióticos', 'Productos para tratar infecciones bacterianas en animales'),
(2, 'Vacunas', 'Vacunas para prevenir enfermedades comunes en mascotas'),
(3, 'Vitaminas', 'Suplementos vitamínicos y minerales para animales'),
(4, 'Antiparasitarios', 'Medicamentos contra parásitos internos y externos'),
(5, 'Alimentos', 'Alimentos balanceados y dietas especiales para mascotas'),
(6, 'Higiene', 'Productos de aseo y cuidado para animales domésticos');

--
-- Disparadores `categoria`
--
DELIMITER $$
CREATE TRIGGER `after_categoria_delete` AFTER DELETE ON `categoria` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Delete', 'Categoria', CONCAT('Se eliminó categoria ID: ', OLD.ID_Categoria), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_categoria_insert` AFTER INSERT ON `categoria` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Insert', 'Categoria', CONCAT('Se insertó categoria ID: ', NEW.ID_Categoria), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_categoria_update` AFTER UPDATE ON `categoria` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Update', 'Categoria', CONCAT('Se actualizó categoria ID: ', NEW.ID_Categoria), NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `ID_Cliente` int(6) NOT NULL,
  `Nombre_Cliente` varchar(40) NOT NULL,
  `Apellido_Cliente` varchar(40) NOT NULL,
  `Direc_Cliente` varchar(60) NOT NULL,
  `Telef_Cliente` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`ID_Cliente`, `Nombre_Cliente`, `Apellido_Cliente`, `Direc_Cliente`, `Telef_Cliente`) VALUES
(1, 'Luis', 'Ramírez', 'Calle Palma 234, Col. Arboledas', '951777111'),
(2, 'María', 'López', 'Av. Hidalgo 678, Col. Centro', '9518882222'),
(3, 'Carlos', 'Hernández', 'Calle 5 de Mayo 123, Col. Reforma', '9519993333'),
(4, 'Ana', 'González', 'Boulevard Oaxaca 456, Col. Industrial', '9510004444'),
(5, 'Javier', 'Pérez', 'Calle Independencia 789, Col. San José', '9513216547'),
(6, 'Diana', 'Santos', 'Av. Juárez 890, Col. Alameda', '9517418525');

--
-- Disparadores `cliente`
--
DELIMITER $$
CREATE TRIGGER `after_cliente_delete` AFTER DELETE ON `cliente` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Delete', 'Cliente', CONCAT('Se eliminó cliente ID: ', OLD.ID_Cliente), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_cliente_insert` AFTER INSERT ON `cliente` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Insert', 'Cliente', CONCAT('Se insertó cliente ID: ', NEW.ID_Cliente), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_cliente_update` AFTER UPDATE ON `cliente` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Update', 'Cliente', CONCAT('Se actualizó cliente ID: ', NEW.ID_Cliente), NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descripcion_producto`
--

CREATE TABLE `descripcion_producto` (
  `ID_Descrip` int(6) NOT NULL,
  `Descrip_Produc` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `descripcion_producto`
--

INSERT INTO `descripcion_producto` (`ID_Descrip`, `Descrip_Produc`) VALUES
(1, 'Antibiótico de amplio espectro'),
(2, 'Vacuna contra parvovirus'),
(3, 'Suplemento vitamínico para perros'),
(4, 'Antiparasitario de uso interno'),
(5, 'Alimento balanceado premium'),
(6, 'Shampoo medicinal para perros');

--
-- Disparadores `descripcion_producto`
--
DELIMITER $$
CREATE TRIGGER `after_descripcion_producto_delete` AFTER DELETE ON `descripcion_producto` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Delete', 'Descripcion_producto', CONCAT('Se eliminó descripción ID: ', OLD.ID_Descrip), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_descripcion_producto_insert` AFTER INSERT ON `descripcion_producto` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Insert', 'Descripcion_producto', CONCAT('Se insertó descripción ID: ', NEW.ID_Descrip), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_descripcion_producto_update` AFTER UPDATE ON `descripcion_producto` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Update', 'Descripcion_producto', CONCAT('Se actualizó descripción ID: ', NEW.ID_Descrip), NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `ID_Detalle` int(11) NOT NULL,
  `ID_Pedido` int(11) DEFAULT NULL,
  `ID_Prod` varchar(32) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`ID_Detalle`, `ID_Pedido`, `ID_Prod`, `Cantidad`) VALUES
(1, 7, 'PROD02', 17),
(2, 7, '5012345678900', 13);

--
-- Disparadores `detalle_pedido`
--
DELIMITER $$
CREATE TRIGGER `after_detalle_pedido_delete` AFTER DELETE ON `detalle_pedido` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Delete', 'Detalle_pedido', CONCAT('Se eliminó detalle pedido ID: ', OLD.ID_Detalle), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_detalle_pedido_insert` AFTER INSERT ON `detalle_pedido` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Insert', 'Detalle_pedido', CONCAT('Se insertó detalle pedido ID: ', NEW.ID_Detalle), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_detalle_pedido_update` AFTER UPDATE ON `detalle_pedido` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Update', 'Detalle_pedido', CONCAT('Se actualizó detalle pedido ID: ', NEW.ID_Detalle), NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envios`
--

CREATE TABLE `envios` (
  `ID_Envio` int(6) NOT NULL,
  `Estado_Envio` varchar(20) NOT NULL,
  `Maximo_Articulos` int(4) NOT NULL,
  `Fecha_Envio` datetime DEFAULT NULL,
  `Fecha_Recibo` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `envios`
--

INSERT INTO `envios` (`ID_Envio`, `Estado_Envio`, `Maximo_Articulos`, `Fecha_Envio`, `Fecha_Recibo`) VALUES
(1, 'En tránsito', 10, '2025-05-14 09:00:00', '0000-00-00 00:00:00'),
(2, 'Entregado', 5, '2025-05-10 08:30:00', '2025-05-12 19:00:00'),
(3, 'Pendiente', 20, '2025-05-16 11:00:00', '0000-00-00 00:00:00'),
(4, 'Cancelado', 8, '2025-05-12 10:45:00', '0000-00-00 00:00:00'),
(5, 'En tránsito', 12, '2025-05-14 15:00:00', '0000-00-00 00:00:00'),
(6, 'Entregado', 7, '2025-05-11 14:30:00', '2025-05-12 19:00:00');

--
-- Disparadores `envios`
--
DELIMITER $$
CREATE TRIGGER `after_envios_delete` AFTER DELETE ON `envios` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Delete', 'Envio', CONCAT('Se eliminó envío ID: ', OLD.ID_Envio), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_envios_insert` AFTER INSERT ON `envios` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Insert', 'Envio', CONCAT('Se insertó envío ID: ', NEW.ID_Envio), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_envios_update` AFTER UPDATE ON `envios` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Update', 'Envio', CONCAT('Se actualizó envío ID: ', NEW.ID_Envio), NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `ID_Pedido` int(6) NOT NULL,
  `ID_Envio` int(6) DEFAULT NULL,
  `ID_Cliente` int(6) DEFAULT NULL,
  `Fecha` datetime NOT NULL,
  `Precio_Total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`ID_Pedido`, `ID_Envio`, `ID_Cliente`, `Fecha`, `Precio_Total`) VALUES
(1, 1, 1, '2025-05-14 09:30:00', 1500.00),
(2, 2, 2, '2025-05-10 10:00:00', 980.50),
(3, 3, 3, '2025-05-16 12:15:00', 2300.75),
(4, 4, 4, '2025-05-12 13:45:00', 650.00),
(5, 5, 5, '2025-05-14 16:20:00', 1230.60),
(6, 6, 6, '2025-05-11 15:10:00', 750.30),
(7, 3, 2, '2025-05-23 08:10:55', 4325.00);

--
-- Disparadores `pedidos`
--
DELIMITER $$
CREATE TRIGGER `after_pedidos_delete` AFTER DELETE ON `pedidos` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Delete', 'Pedido', CONCAT('Se eliminó pedido ID: ', OLD.ID_Pedido), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_pedidos_insert` AFTER INSERT ON `pedidos` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Insert', 'Pedido', CONCAT('Se insertó pedido ID: ', NEW.ID_Pedido), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_pedidos_update` AFTER UPDATE ON `pedidos` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Update', 'Pedido', CONCAT('Se actualizó pedido ID: ', NEW.ID_Pedido), NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ID_Prod` varchar(30) NOT NULL,
  `Nomb_Prod` varchar(40) NOT NULL,
  `ID_Descrip` int(6) NOT NULL,
  `Cant_Disp_Prod` int(3) NOT NULL,
  `ID_Almacen` int(6) NOT NULL,
  `Prec_Comp` decimal(7,2) NOT NULL,
  `Prec_Vent` decimal(7,2) NOT NULL,
  `ID_Prov` int(6) NOT NULL,
  `ID_Categoria` int(6) NOT NULL,
  `Prod_Estatus` tinyint(1) DEFAULT NULL,
  `Fec_Cad` date DEFAULT NULL,
  `Desc_Prod` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID_Prod`, `Nomb_Prod`, `ID_Descrip`, `Cant_Disp_Prod`, `ID_Almacen`, `Prec_Comp`, `Prec_Vent`, `ID_Prov`, `ID_Categoria`, `Prod_Estatus`, `Fec_Cad`, `Desc_Prod`) VALUES
('02417219', 'Paracetamol', 2, 24, 6, 3434.00, 353.00, 1, 1, 1, '2025-05-28', 34),
('5012345678900', 'Desimposilina ', 2, 2333, 1, 23.00, 45.00, 8, 5, 1, '2025-05-12', 0),
('7702111812918', 'dssddsad', 1, 32, 1, 23.00, 34.00, 1, 1, 1, '2025-05-27', 34),
('PROD01', 'AmoxiVet 500mg', 1, 50, 1, 120.00, 150.00, 1, 1, 1, '2026-05-14', 0),
('PROD02', 'ParvoVac Plus', 2, 30, 2, 180.00, 220.00, 2, 2, 1, '2025-12-30', 0),
('PROD03', 'Vitacan B Complex', 3, 70, 3, 70.00, 95.00, 3, 3, 1, '2026-03-20', 0),
('PROD04', 'Parasitol 250ml', 4, 45, 4, 90.00, 120.00, 4, 4, 1, '2026-01-15', 0),
('PROD05', 'Dog Chow Adulto', 5, 100, 5, 450.00, 580.00, 5, 5, 1, '2026-07-30', 0),
('PROD06', 'Shampoo Dermavet', 6, 25, 6, 85.00, 110.00, 6, 6, 1, '2025-11-10', 0);

--
-- Disparadores `productos`
--
DELIMITER $$
CREATE TRIGGER `after_productos_delete` AFTER DELETE ON `productos` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Delete', 'Producto', CONCAT('Se eliminó producto ID: ', OLD.ID_Prod), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_productos_insert` AFTER INSERT ON `productos` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Insert', 'Producto', CONCAT('Se insertó producto ID: ', NEW.ID_Prod), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_productos_update` AFTER UPDATE ON `productos` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Update', 'Producto', CONCAT('Se actualizó producto ID: ', NEW.ID_Prod), NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `ID_Prov` int(6) NOT NULL,
  `Nomb_Prov` varchar(40) NOT NULL,
  `Telefono_Prov` varchar(10) NOT NULL,
  `Tipo_Prov` varchar(15) NOT NULL,
  `Manejo_Camb` tinyint(1) NOT NULL,
  `Direccion_Prov` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`ID_Prov`, `Nomb_Prov`, `Telefono_Prov`, `Tipo_Prov`, `Manejo_Camb`, `Direccion_Prov`) VALUES
(1, 'Betoquinol', '9512345679', 'Minorista', 0, 'Calle Delta 789, Colonia Centro, Ciudad L'),
(2, 'Bionote', '9512345683', 'Mayorista', 1, 'Avenida de la Industria 444, Planta 3, Ciudad P'),
(3, 'Bioso', '9512345682', 'Mayorista', 1, 'Calle del Sol 998, Lote 25, Parque Industrial, Ciudad O'),
(4, 'Crush', '9512345684', 'Minorista', 0, 'Calle del Parque 123, Local 7, Mercado Central, Ciudad Q'),
(5, 'Decre', '9512345681', 'Minorista', 0, 'Calle Jaguar 334, Barrio La Paz, Ciudad N'),
(6, 'Intermedic', '9512345685', 'Mayorista', 1, 'Calle de los Áviles 250, Zona 10, Ciudad R'),
(7, 'Labyes', '9512345680', 'Mayorista', 1, 'Boulevard de la Reforma 1010, Edificio Torre, Ciudad M'),
(8, 'Virbac', '9512345678', 'Mayorista', 1, 'Av. Principal 456, Zona Industrial, Ciudad K');

--
-- Disparadores `proveedor`
--
DELIMITER $$
CREATE TRIGGER `after_proveedor_delete` AFTER DELETE ON `proveedor` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Delete', 'Proveedor', CONCAT('Se eliminó proveedor ID: ', OLD.ID_Prov), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_proveedor_insert` AFTER INSERT ON `proveedor` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Insert', 'Proveedor', CONCAT('Se insertó proveedor ID: ', NEW.ID_Prov), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_proveedor_update` AFTER UPDATE ON `proveedor` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Update', 'Proveedor', CONCAT('Se actualizó proveedor ID: ', NEW.ID_Prov), NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID_Usuario` int(6) NOT NULL,
  `Nombre_Usuario` varchar(40) NOT NULL,
  `Rol` varchar(20) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Contraseña` varchar(10) NOT NULL,
  `avatar_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_Usuario`, `Nombre_Usuario`, `Rol`, `Email`, `Contraseña`, `avatar_url`) VALUES
(1, 'Pepe', 'Administrador', 'pepe@123', '123', '../Icons/avatar/goku.png'),
(2, 'Narcizo Ac', 'Encargado de Bodega', 'narcizo.ac@empresa.com', '123', ''),
(3, 'Alfredo Abreu', 'Gerente', 'alfredo.abreu@empresa.com', '123', '../Icons/Avatares/Preterminado.png'),
(4, 'Rocio Gancedo', 'Administrador', 'rocio.gancedo@empresa.com', 'Adm1n@2024', '../Icons/Avatares/Preterminado.png'),
(5, 'Sury Pech', 'Ayudante de Bodega', 'sury.pech@empresa.com', 'Ayudante@2', '../Icons/Avatares/Preterminado.png'),
(6, 'Neydi Poot', 'Ayudante de Bodega', 'neydi.poot@empresa.com', 'Bodega@202', '../Icons/Avatares/Preterminado.png'),
(7, 'Leticia Hau', 'Gerente', 'Leti@123', '1234', '../Icons/avatar/prueba.jpg'),
(8, 'Angeles Olvera', 'Encargado de Bodega', 'Angeles@123', '1234', '../Icons/avatar/angeles.jpg\r\n'),
(10, 'Hermione Pech', 'Administrador', 'Sharis@12', '123', '../Icons/avatar/sharis.jpeg');

--
-- Disparadores `usuario`
--
DELIMITER $$
CREATE TRIGGER `after_usuario_delete` AFTER DELETE ON `usuario` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Delete', 'Usuario', CONCAT('Se eliminó usuario ID: ', OLD.ID_Usuario), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_usuario_insert` AFTER INSERT ON `usuario` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Insert', 'Usuario', CONCAT('Se insertó usuario ID: ', NEW.ID_Usuario), NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_usuario_update` AFTER UPDATE ON `usuario` FOR EACH ROW BEGIN
  INSERT INTO bitacora (accion, tabla_afectada, detalle, fecha_hora)
  VALUES ('Update', 'Usuario', CONCAT('Se actualizó usuario ID: ', NEW.ID_Usuario), NOW());
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`ID_Almacen`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID_Categoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`ID_Cliente`);

--
-- Indices de la tabla `descripcion_producto`
--
ALTER TABLE `descripcion_producto`
  ADD PRIMARY KEY (`ID_Descrip`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`ID_Detalle`),
  ADD KEY `ID_Pedido` (`ID_Pedido`),
  ADD KEY `ID_Prod` (`ID_Prod`);

--
-- Indices de la tabla `envios`
--
ALTER TABLE `envios`
  ADD PRIMARY KEY (`ID_Envio`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`ID_Pedido`),
  ADD KEY `ID_Envio` (`ID_Envio`),
  ADD KEY `ID_Cliente` (`ID_Cliente`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID_Prod`),
  ADD KEY `ID_Descrip` (`ID_Descrip`),
  ADD KEY `ID_Almacen` (`ID_Almacen`),
  ADD KEY `ID_Prov` (`ID_Prov`),
  ADD KEY `ID_Categoria` (`ID_Categoria`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`ID_Prov`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almacen`
--
ALTER TABLE `almacen`
  MODIFY `ID_Almacen` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `ID_Categoria` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `ID_Cliente` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `descripcion_producto`
--
ALTER TABLE `descripcion_producto`
  MODIFY `ID_Descrip` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `ID_Detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `envios`
--
ALTER TABLE `envios`
  MODIFY `ID_Envio` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `ID_Pedido` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `ID_Prov` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_Usuario` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`ID_Pedido`) REFERENCES `pedidos` (`ID_Pedido`),
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`ID_Prod`) REFERENCES `productos` (`ID_Prod`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`ID_Envio`) REFERENCES `envios` (`ID_Envio`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`ID_Descrip`) REFERENCES `descripcion_producto` (`ID_Descrip`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`ID_Almacen`) REFERENCES `almacen` (`ID_Almacen`),
  ADD CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`ID_Prov`) REFERENCES `proveedor` (`ID_Prov`),
  ADD CONSTRAINT `productos_ibfk_4` FOREIGN KEY (`ID_Categoria`) REFERENCES `categoria` (`ID_Categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
