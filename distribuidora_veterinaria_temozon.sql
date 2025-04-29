-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-02-2025 a las 05:58:31
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `distribuidora_veterinaria_temozon`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `ID_Almacen` varchar(15) NOT NULL,
  `Direccion_Alm` varchar(60) NOT NULL,
  `Telefono_Alm` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`ID_Almacen`, `Direccion_Alm`, `Telefono_Alm`) VALUES
('A001', 'Calle Ficticia 123, Ciudad A', '9876543210'),
('A002', 'Avenida Siempre Viva 456, Ciudad B', '9876543211'),
('A003', 'Calle Sol 789, Ciudad C', '9876543212'),
('A004', 'Calle Luna 101, Ciudad D', '9876543213'),
('A005', 'Bulevar del Sol 202, Ciudad E', '9876543214'),
('A006', 'Calle del Mar 303, Ciudad F', '9876543215');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `ID_Categoria` varchar(15) NOT NULL,
  `Categoria_Nombre` varchar(40) NOT NULL,
  `Categoria_Descripcion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`ID_Categoria`, `Categoria_Nombre`, `Categoria_Descripcion`) VALUES
('C0003', 'Alimentos', 'Alimentos y suplementos para la nutrición de mascotas y animales de granja.'),
('C0004', 'Antiparasitarios', 'Productos para el control y eliminación de parásitos internos y externos en animales.'),
('C0006', 'Cuidado Dental', 'Productos para el cuidado y limpieza dental de mascotas, incluyendo pastas y cepillos especiales.'),
('C0005', 'Equipos Veterinarios', 'Instrumentos y equipos utilizados por los veterinarios para diagnóstico y tratamiento de animales.'),
('C0002', 'Medicamentos', 'Medicamentos para el tratamiento de enfermedades en animales, como antibióticos, antiinflamatorios, etc.'),
('C0001', 'Vacunas', 'Vacunas para prevenir diversas enfermedades en animales, como rabia, parvovirus, etc.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `ID_Cliente` varchar(15) NOT NULL,
  `Nombre_Cliente` varchar(40) NOT NULL,
  `Direc_Cliente` varchar(60) NOT NULL,
  `Telef_Cliente` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`ID_Cliente`, `Nombre_Cliente`, `Direc_Cliente`, `Telef_Cliente`) VALUES
('CL1001', 'Dr. Alfredo Abreu', 'Calle Ficticia 123, Ciudad A', '9876543210'),
('CL1002', 'Dra. Rocío Gancedo', 'Avenida Siempre Viva 456, Ciudad B', '9876543211'),
('CL1003', 'Dr. Sury Pech', 'Calle Sol 789, Ciudad C', '9876543212'),
('CL1004', 'Dra. Neydi Poot', 'Calle Luna 101, Ciudad D', '9876543213'),
('CL1005', 'Dr. Narcizo Ac', 'Bulevar del Sol 202, Ciudad E', '9876543214'),
('CL1006', 'Dra. Carmen García', 'Calle del Mar 303, Ciudad F', '9876543215'),
('CL1007', 'Dr. Luis Martínez', 'Calle del Bosque 404, Ciudad G', '9876543216'),
('CL1008', 'Dra. Ana Rodríguez', 'Avenida Las Palmas 505, Ciudad H', '9876543217'),
('CL1009', 'Dr. Mario López', 'Calle de los Cedros 606, Ciudad I', '9876543218'),
('CL1010', 'Dra. Teresa Fernández', 'Calle del Río 707, Ciudad J', '9876543219');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ID_Prod` varchar(6) NOT NULL,
  `Nomb_Prod` varchar(40) NOT NULL,
  `Desc_Prod` varchar(3) NOT NULL,
  `Lote_Prod` varchar(6) NOT NULL,
  `Cant_Disp_Prod` int(3) NOT NULL,
  `ID_Almacen` varchar(15) NOT NULL,
  `Prec_Comp` decimal(7,2) NOT NULL,
  `Prec_vent` decimal(7,2) NOT NULL,
  `Nombre_Prov` varchar(40) NOT NULL,
  `ID_Categoria` varchar(15) NOT NULL,
  `Prod_Estatus` tinyint(1) DEFAULT NULL,
  `Fec_Cad` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID_Prod`, `Nomb_Prod`, `Desc_Prod`, `Lote_Prod`, `Cant_Disp_Prod`, `ID_Almacen`, `Prec_Comp`, `Prec_vent`, `Nombre_Prov`, `ID_Categoria`, `Prod_Estatus`, `Fec_Cad`) VALUES
('P001', 'Vacuna Antirrábica', '5%', 'LT001', 100, 'A001', 150.00, 250.00, 'Virbac', 'C0001', 1, '2025-12-31'),
('P002', 'Antibiótico Amoxicilina', '10%', 'LT002', 50, 'A002', 100.00, 150.00, 'Betoquinol', 'C0002', 1, '2024-11-30'),
('P003', 'Pasta Antiparasitaria', '4%', 'LT003', 200, 'A003', 80.00, 130.00, 'Labyes', 'C0004', 1, '2026-03-15'),
('P004', 'Alimento Balanceado Canino', '4%', 'LT004', 150, 'A004', 200.00, 350.00, 'Decre', 'C0003', 1, '2025-07-01'),
('P005', 'Suplemento Vitaminico', '7%', 'LT005', 300, 'A005', 120.00, 180.00, 'Bioso', 'C0003', 1, '2026-06-25'),
('P006', 'Vacuna Parvovirus', '9%', 'LT006', 50, 'A006', 160.00, 270.00, 'Bionote', 'C0001', 1, '2024-08-22'),
('P007', 'Antiinflamatorio Ketoprofeno', '4 %', 'LT007', 75, 'A001', 90.00, 150.00, 'Crush', 'C0002', 1, '2025-09-10'),
('P008', 'Pipeta Antiparasitaria', '2%', 'LT008', 150, 'A002', 50.00, 100.00, 'Intermedic', 'C0004', 1, '2026-01-18'),
('P009', 'Alimento Balanceado Felino', '3%', 'LT009', 120, 'A003', 210.00, 350.00, 'Virbac', 'C0003', 1, '2024-10-05'),
('P010', 'Desinfectante Veterinario', '11%', 'LT010', 200, 'A004', 60.00, 120.00, 'Decre', 'C0005', 1, '2025-05-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `Nomb_Prov` varchar(15) NOT NULL,
  `Telefono_Prov` varchar(10) NOT NULL,
  `Tipo_Prov` varchar(15) NOT NULL,
  `Manejo_Camb` tinyint(1) NOT NULL,
  `Direccion_Prov` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`Nomb_Prov`, `Telefono_Prov`, `Tipo_Prov`, `Manejo_Camb`, `Direccion_Prov`) VALUES
('Betoquinol', '9512345679', 'Minorista', 0, 'Calle Delta 789, Colonia Centro, Ciudad L'),
('Bionote', '9512345683', 'Mayorista', 1, 'Avenida de la Industria 444, Planta 3, Ciudad P'),
('Bioso', '9512345682', 'Mayorista', 1, 'Calle del Sol 998, Lote 25, Parque Industrial, Ciudad O'),
('Crush', '9512345684', 'Minorista', 0, 'Calle del Parque 123, Local 7, Mercado Central, Ciudad Q'),
('Decre', '9512345681', 'Minorista', 0, 'Calle Jaguar 334, Barrio La Paz, Ciudad N'),
('Intermedic', '9512345685', 'Mayorista', 1, 'Calle de los Áviles 250, Zona 10, Ciudad R'),
('Labyes', '9512345680', 'Mayorista', 1, 'Boulevard de la Reforma 1010, Edificio Torre, Ciudad M'),
('Virbac', '9512345678', 'Mayorista', 1, 'Av. Principal 456, Zona Industrial, Ciudad K');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID_Usuario` varchar(6) NOT NULL,
  `Nombre_Usuario` varchar(40) NOT NULL,
  `Rol` varchar(20) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Contraseña` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_Usuario`, `Nombre_Usuario`, `Rol`, `Email`, `Contraseña`) VALUES
('123456', 'Pepe', 'Admin', 'pepe@123', '123'),
('ADHT3G', 'Narcizo Ac', 'Encargado de Bodega', 'narcizo.ac@empresa.com', 'Encargado@'),
('B34GV2', 'Alfredo Abreu', 'Gerente', 'alfredo.abreu@empresa.com', 'G3rente@24'),
('HB3YU4', 'Rocio Gancedo', 'Administrador', 'rocio.gancedo@empresa.com', 'Adm1n@2024'),
('JN34IJ', 'Sury Pech', 'Ayudante de Bodega', 'sury.pech@empresa.com', 'Ayudante@2'),
('RJHD54', 'Neydi Poot', 'Ayudante de Bodega', 'neydi.poot@empresa.com', 'Bodega@202');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`ID_Almacen`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID_Categoria`),
  ADD UNIQUE KEY `Categoria_Nombre` (`Categoria_Nombre`,`Categoria_Descripcion`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`ID_Cliente`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID_Prod`),
  ADD UNIQUE KEY `Nomb_Prod` (`Nomb_Prod`),
  ADD KEY `ID_Almacen` (`ID_Almacen`),
  ADD KEY `Nombre_Prov` (`Nombre_Prov`),
  ADD KEY `ID_Categoria` (`ID_Categoria`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`Nomb_Prov`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_Usuario`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`ID_Almacen`) REFERENCES `almacen` (`ID_Almacen`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`Nombre_Prov`) REFERENCES `proveedor` (`Nomb_Prov`),
  ADD CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`ID_Categoria`) REFERENCES `categoria` (`ID_Categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
