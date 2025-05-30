-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2025 a las 15:48:03
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
-- Base de datos: `empresa_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_vendidos`
--

CREATE TABLE `productos_vendidos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(100) NOT NULL,
  `unidades_vendidas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos_vendidos`
--

INSERT INTO `productos_vendidos` (`id_producto`, `nombre_producto`, `unidades_vendidas`) VALUES
(1, 'Docchu', 250),
(2, 'Pastilla', 310),
(3, 'Paracetamol', 200),
(4, 'Aliviax', 150),
(5, 'Produc', 120),
(6, 'Tinki', 80),
(7, 'Wolf', 140);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_mensuales`
--

CREATE TABLE `ventas_mensuales` (
  `id` int(11) NOT NULL,
  `mes` varchar(20) DEFAULT NULL,
  `ventas` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas_mensuales`
--

INSERT INTO `ventas_mensuales` (`id`, `mes`, `ventas`) VALUES
(1, 'Ene', 2500.00),
(2, 'Feb', 3000.00),
(3, 'Mar', 2700.00),
(4, 'Abr', 3500.00),
(5, 'May', 3200.00),
(6, 'Jun', 4000.00),
(7, 'Jul', 4600.00),
(8, 'Ago', 4800.00),
(9, 'Sep', 5300.00),
(10, 'Oct', 5900.00),
(11, 'Nov', 5500.00),
(12, 'Dic', 1000.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos_vendidos`
--
ALTER TABLE `productos_vendidos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `ventas_mensuales`
--
ALTER TABLE `ventas_mensuales`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos_vendidos`
--
ALTER TABLE `productos_vendidos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ventas_mensuales`
--
ALTER TABLE `ventas_mensuales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
