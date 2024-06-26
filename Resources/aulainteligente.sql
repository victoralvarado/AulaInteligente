-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-06-2024 a las 04:41:43
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
-- Base de datos: `aulainteligente`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id` int(11) NOT NULL,
  `carnet` varchar(6) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `carnet`, `nombres`, `apellidos`, `activo`) VALUES
(1, '017316', 'Victor Eliezar', 'Alvarado Guzman', 1),
(2, '101010', 'Juan José', 'Perez', 1),
(3, '012216', 'Mario Antonio', 'Martinez', 0),
(4, '111111', 'aaaaaaa', 'bbbbbbb', 0),
(6, '222222', 'cccccccccc', 'oooooooooo', 1),
(7, '777777', 'swsw', 'swsws', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `id` int(11) NOT NULL,
  `fechaHora` datetime NOT NULL,
  `materia` int(11) NOT NULL,
  `alumno` int(11) NOT NULL,
  `grupo` int(11) NOT NULL,
  `estado` enum('T','I','•') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencias`
--

INSERT INTO `asistencias` (`id`, `fechaHora`, `materia`, `alumno`, `grupo`, `estado`) VALUES
(1, '2024-06-15 22:34:16', 1, 1, 1, 'T'),
(3, '2024-06-15 22:43:11', 1, 2, 1, 'T'),
(4, '2024-06-16 22:14:39', 1, 1, 1, '•'),
(5, '2024-06-17 22:19:57', 1, 2, 1, 'T'),
(7, '2024-06-17 22:23:04', 1, 3, 1, 'I');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aulas`
--

CREATE TABLE `aulas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `aulas`
--

INSERT INTO `aulas` (`id`, `nombre`) VALUES
(1, 'F305'),
(2, 'F301');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `id` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`id`, `nombres`, `apellidos`) VALUES
(1, 'Jorge Alberto', 'Suarez Paredes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id`, `nombre`) VALUES
(1, 'DS01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id` int(11) NOT NULL,
  `aula` int(11) NOT NULL,
  `materia` int(11) NOT NULL,
  `grupo` int(11) NOT NULL,
  `horaInicio` time NOT NULL,
  `horafin` time NOT NULL,
  `dia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`id`, `aula`, `materia`, `grupo`, `horaInicio`, `horafin`, `dia`) VALUES
(1, 1, 1, 1, '22:00:00', '23:00:00', 5),
(2, 2, 1, 1, '22:00:00', '23:00:00', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `nombre`) VALUES
(1, 'Lógica de Programación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiasdocentes`
--

CREATE TABLE `materiasdocentes` (
  `id` int(11) NOT NULL,
  `materia` int(11) NOT NULL,
  `docente` int(11) NOT NULL,
  `grupo` int(11) NOT NULL,
  `aula` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materiasdocentes`
--

INSERT INTO `materiasdocentes` (`id`, `materia`, `docente`, `grupo`, `aula`) VALUES
(1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiasinscritas`
--

CREATE TABLE `materiasinscritas` (
  `id` int(11) NOT NULL,
  `materia` int(11) NOT NULL,
  `grupo` int(11) NOT NULL,
  `alumno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materiasinscritas`
--

INSERT INTO `materiasinscritas` (`id`, `materia`, `grupo`, `alumno`) VALUES
(1, 1, 1, 1),
(2, 1, 1, 2),
(3, 1, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tolerancia`
--

CREATE TABLE `tolerancia` (
  `id` int(11) NOT NULL,
  `materia` int(11) NOT NULL,
  `minutos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tolerancia`
--

INSERT INTO `tolerancia` (`id`, `materia`, `minutos`) VALUES
(1, 1, 15);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alumnos_carnet_unique` (`carnet`);

--
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asistencias_alumno_foreign` (`alumno`),
  ADD KEY `asistencias_grupo_foreign` (`grupo`),
  ADD KEY `asistencias_materia_foreign` (`materia`);

--
-- Indices de la tabla `aulas`
--
ALTER TABLE `aulas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `horarios_materia_foreign` (`materia`),
  ADD KEY `horarios_grupo_foreign` (`grupo`),
  ADD KEY `horarios_aula_foreign` (`aula`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materiasdocentes`
--
ALTER TABLE `materiasdocentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materiasdocentes_docente_foreign` (`docente`),
  ADD KEY `materiasdocentes_materia_foreign` (`materia`),
  ADD KEY `materiasdocentes_grupo_foreign` (`grupo`),
  ADD KEY `materiasdocentes_aula_foreign` (`aula`);

--
-- Indices de la tabla `materiasinscritas`
--
ALTER TABLE `materiasinscritas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materiasinscritas_grupo_foreign` (`grupo`),
  ADD KEY `materiasinscritas_alumno_foreign` (`alumno`),
  ADD KEY `materiasinscritas_materia_foreign` (`materia`);

--
-- Indices de la tabla `tolerancia`
--
ALTER TABLE `tolerancia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tolerancia_materia_foreign` (`materia`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `aulas`
--
ALTER TABLE `aulas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `materiasdocentes`
--
ALTER TABLE `materiasdocentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `materiasinscritas`
--
ALTER TABLE `materiasinscritas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tolerancia`
--
ALTER TABLE `tolerancia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD CONSTRAINT `asistencias_alumno_foreign` FOREIGN KEY (`alumno`) REFERENCES `alumnos` (`id`),
  ADD CONSTRAINT `asistencias_grupo_foreign` FOREIGN KEY (`grupo`) REFERENCES `grupos` (`id`),
  ADD CONSTRAINT `asistencias_materia_foreign` FOREIGN KEY (`materia`) REFERENCES `materias` (`id`);

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `horarios_aula_foreign` FOREIGN KEY (`aula`) REFERENCES `aulas` (`id`),
  ADD CONSTRAINT `horarios_grupo_foreign` FOREIGN KEY (`grupo`) REFERENCES `grupos` (`id`),
  ADD CONSTRAINT `horarios_materia_foreign` FOREIGN KEY (`materia`) REFERENCES `materias` (`id`);

--
-- Filtros para la tabla `materiasdocentes`
--
ALTER TABLE `materiasdocentes`
  ADD CONSTRAINT `materiasdocentes_aula_foreign` FOREIGN KEY (`aula`) REFERENCES `aulas` (`id`),
  ADD CONSTRAINT `materiasdocentes_docente_foreign` FOREIGN KEY (`docente`) REFERENCES `docentes` (`id`),
  ADD CONSTRAINT `materiasdocentes_grupo_foreign` FOREIGN KEY (`grupo`) REFERENCES `grupos` (`id`),
  ADD CONSTRAINT `materiasdocentes_materia_foreign` FOREIGN KEY (`materia`) REFERENCES `materias` (`id`);

--
-- Filtros para la tabla `materiasinscritas`
--
ALTER TABLE `materiasinscritas`
  ADD CONSTRAINT `materiasinscritas_alumno_foreign` FOREIGN KEY (`alumno`) REFERENCES `alumnos` (`id`),
  ADD CONSTRAINT `materiasinscritas_grupo_foreign` FOREIGN KEY (`grupo`) REFERENCES `grupos` (`id`),
  ADD CONSTRAINT `materiasinscritas_materia_foreign` FOREIGN KEY (`materia`) REFERENCES `materias` (`id`);

--
-- Filtros para la tabla `tolerancia`
--
ALTER TABLE `tolerancia`
  ADD CONSTRAINT `tolerancia_materia_foreign` FOREIGN KEY (`materia`) REFERENCES `materias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
