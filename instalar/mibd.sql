-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-12-2020 a las 00:12:17
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gymdatos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id` int(10) NOT NULL,
  `nombre` varchar(10) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `aforo` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `nombre`, `descripcion`, `aforo`) VALUES
(1, 'ciclo', '', 100),
(2, 'zumba', '  ', 100),
(3, 'yoga', '', 100),
(49061223, 'crossfit', '  ', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramos`
--

CREATE TABLE `tramos` (
  `id` int(10) NOT NULL,
  `dia` varchar(10) NOT NULL,
  `horainicio` varchar(5) NOT NULL,
  `horafin` varchar(5) NOT NULL,
  `actividad_id` int(10) NOT NULL,
  `fecha_alta` varchar(10) NOT NULL,
  `fecha_baja` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tramos`
--

INSERT INTO `tramos` (`id`, `dia`, `horainicio`, `horafin`, `actividad_id`, `fecha_alta`, `fecha_baja`) VALUES
(2, 'jueves', '09:00', '09:30', 1, '0000-00-01', '<br /><b>N'),
(37576898, 'martes', '09:00', '09:30', 2, '0000-00-00', '0000-00-00'),
(58568896, 'lunes', '12:00', '12:30', 3, '0000-00-00', '0000-00-00'),
(76718152, 'viernes', '12:00', '12:30', 3, '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) NOT NULL,
  `nif` varchar(13) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(20) NOT NULL,
  `telefono` int(9) NOT NULL,
  `direccion` varchar(40) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `imagen` varchar(50) NOT NULL,
  `rol_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nif`, `nombre`, `apellidos`, `email`, `password`, `telefono`, `direccion`, `estado`, `imagen`, `rol_id`) VALUES
(1, '499dkwsdoksd', 'alee', 'ale', 'alejandro@gmail.com', 'ale', 999999999, 'c,saldmsakamdsak', 1, '', 2111211),
(9848196, '        ', 'no', 'admin', 'usuarionoadmin@gmail.con', 'usuarionoadmin', 999999999, '   ', 1, 'ninguna', 0),
(50952400, '    ', 'admin', '   ', 'admin@gmail.com', 'admin', 99999999, '    ', 1, 'ninguna', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `tramos`
--
ALTER TABLE `tramos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actividades_id` (`actividad_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tramos`
--
ALTER TABLE `tramos`
  ADD CONSTRAINT `actividades_id` FOREIGN KEY (`actividad_id`) REFERENCES `actividades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
