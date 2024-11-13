-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 13-11-2024 a las 15:04:59
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `equipofutbol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alineacion`
--

CREATE TABLE `alineacion` (
  `id_alineacion` int(11) NOT NULL,
  `id_jugador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alineacion`
--

INSERT INTO `alineacion` (`id_alineacion`, `id_jugador`) VALUES
(45, 21),
(41, 23),
(42, 26),
(46, 27),
(43, 32),
(47, 33),
(48, 36),
(49, 39),
(44, 41),
(50, 43);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `id_posicion` int(11) NOT NULL,
  `dorsal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`id`, `nombre`, `id_posicion`, `dorsal`) VALUES
(20, 'Aarón Olmos', 2, 10),
(21, 'Alex Ollé', 3, 7),
(22, 'Carla Hurtado', 4, 9),
(23, 'Carlos Moreno', 2, 5),
(24, 'Daniel Pons', 3, 11),
(25, 'Douglas A. Largo', 4, 15),
(26, 'Enrique Muñoz', 2, 4),
(27, 'Fidel Lauroba', 3, 8),
(28, 'Hugo Alias', 4, 14),
(29, 'Jose Serrano', 2, 6),
(30, 'Joseph Adrián', 3, 12),
(31, 'Juan Pablo Arias', 4, 16),
(32, 'Lilia hrytskiv', 2, 13),
(33, 'Maïna Boza', 3, 20),
(34, 'Marcos Castellanos', 4, 18),
(35, 'Marcos Allet', 2, 3),
(36, 'Pablo Miguel Ferrer', 3, 17),
(37, 'Pablo Santiago', 4, 19),
(38, 'Pedro Rodriguez', 2, 2),
(39, 'Rubén Motos', 3, 21),
(40, 'Santi Membrado', 4, 22),
(41, 'Victor Bleda', 2, 23),
(42, 'Yoel Capilla', 3, 24),
(43, 'Enol González', 4, 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posicion`
--

CREATE TABLE `posicion` (
  `id` int(11) NOT NULL,
  `nombre_posicion` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `posicion`
--

INSERT INTO `posicion` (`id`, `nombre_posicion`) VALUES
(1, 'portero'),
(2, 'defensa'),
(3, 'mediocampista'),
(4, 'delantero'),
(5, 'entrenador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tactica`
--

CREATE TABLE `tactica` (
  `id_tactica` int(11) NOT NULL,
  `formacion` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tactica`
--

INSERT INTO `tactica` (`id_tactica`, `formacion`) VALUES
(1, '4-4-2'),
(2, '4-3-3'),
(3, '3-4-3'),
(4, '3-5-2'),
(5, '5-4-1'),
(6, '4-5-1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alineacion`
--
ALTER TABLE `alineacion`
  ADD PRIMARY KEY (`id_alineacion`),
  ADD KEY `fk_id_jugador` (`id_jugador`);

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_rol` (`id_posicion`);

--
-- Indices de la tabla `posicion`
--
ALTER TABLE `posicion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tactica`
--
ALTER TABLE `tactica`
  ADD PRIMARY KEY (`id_tactica`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alineacion`
--
ALTER TABLE `alineacion`
  MODIFY `id_alineacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `posicion`
--
ALTER TABLE `posicion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tactica`
--
ALTER TABLE `tactica`
  MODIFY `id_tactica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alineacion`
--
ALTER TABLE `alineacion`
  ADD CONSTRAINT `fk_id_jugador` FOREIGN KEY (`id_jugador`) REFERENCES `equipo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD CONSTRAINT `fk_id_rol` FOREIGN KEY (`id_posicion`) REFERENCES `posicion` (`id`) ON DELETE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
