-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-12-2021 a las 02:56:20
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `farmacias`
--

CREATE TABLE `farmacias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `latitud` decimal(10,5) NOT NULL,
  `longitud` decimal(16,5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `farmacias`
--

INSERT INTO `farmacias` (`id`, `nombre`, `direccion`, `latitud`, `longitud`) VALUES
(1, 'Farmacia yachelini', 'Matanza 3259 Piso Pb 1825 Monte Chingolo Buenos Aires ', '-34.72978', '-58.35329'),
(2, 'Nadir Salud Farmacias', 'Av. Adolfo Alsina 3, B1832AHA Banfield, Provincia de Buenos Aires', '-34.74471', '-58.40410'),
(4, 'Muñoz Segundo E', 'Rodríguez Brito 1402, B1828 Salta 501, B1844 San José-Alte Brown, Provincia de Buenos Aires', '-34.61315', '-58.37723'),
(5, 'Farmacia Gonzalez', 'Rodríguez Brito 1402, B1828 Banfield, Provincia de Buenos Aires', '-34.75066', '34.75066'),
(6, 'FARMACIA GISPERT', 'Buenos Aires AR, Maipú 401, B1828 IJI, Provincia de Buenos Aires', '-34.61315', '-58.37723');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `farmacias`
--
ALTER TABLE `farmacias`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `farmacias`
--
ALTER TABLE `farmacias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
