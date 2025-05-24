-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-05-2025 a las 01:49:13
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
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_Usuario` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
