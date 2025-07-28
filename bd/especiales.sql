-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-06-2025 a las 22:56:53
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `especiales`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `tiempo` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_alumno`
--

CREATE TABLE `actividad_alumno` (
  `ID` int(11) NOT NULL,
  `Alumno_ID` int(11) DEFAULT NULL,
  `Actividad_ID` int(11) DEFAULT NULL,
  `f_inicio` date DEFAULT NULL,
  `f_final` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `Apellido` varchar(255) DEFAULT NULL,
  `Edad` int(11) DEFAULT NULL,
  `Sexo` varchar(50) DEFAULT NULL,
  `diagnostico` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alum_repre`
--

CREATE TABLE `alum_repre` (
  `codigo` int(11) NOT NULL,
  `Alumno_ID` int(11) DEFAULT NULL,
  `Representante_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `Tlf` varchar(50) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_alumno`
--

CREATE TABLE `doc_alumno` (
  `codigo` int(11) NOT NULL,
  `Alumno_ID` int(11) DEFAULT NULL,
  `Docente_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `representante`
--

CREATE TABLE `representante` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `Direccion` varchar(255) DEFAULT NULL,
  `Tlf` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `actividad_alumno`
--
ALTER TABLE `actividad_alumno`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Alumno_ID` (`Alumno_ID`),
  ADD KEY `Actividad_ID` (`Actividad_ID`);

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `alum_repre`
--
ALTER TABLE `alum_repre`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `Alumno_ID` (`Alumno_ID`),
  ADD KEY `Representante_ID` (`Representante_ID`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `doc_alumno`
--
ALTER TABLE `doc_alumno`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `Alumno_ID` (`Alumno_ID`),
  ADD KEY `Docente_ID` (`Docente_ID`);

--
-- Indices de la tabla `representante`
--
ALTER TABLE `representante`
  ADD PRIMARY KEY (`ID`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividad_alumno`
--
ALTER TABLE `actividad_alumno`
  ADD CONSTRAINT `actividad_alumno_ibfk_1` FOREIGN KEY (`Alumno_ID`) REFERENCES `alumno` (`ID`),
  ADD CONSTRAINT `actividad_alumno_ibfk_2` FOREIGN KEY (`Actividad_ID`) REFERENCES `actividad` (`ID`);

--
-- Filtros para la tabla `alum_repre`
--
ALTER TABLE `alum_repre`
  ADD CONSTRAINT `alum_repre_ibfk_1` FOREIGN KEY (`Alumno_ID`) REFERENCES `alumno` (`ID`),
  ADD CONSTRAINT `alum_repre_ibfk_2` FOREIGN KEY (`Representante_ID`) REFERENCES `representante` (`ID`);

--
-- Filtros para la tabla `doc_alumno`
--
ALTER TABLE `doc_alumno`
  ADD CONSTRAINT `doc_alumno_ibfk_1` FOREIGN KEY (`Alumno_ID`) REFERENCES `alumno` (`ID`),
  ADD CONSTRAINT `doc_alumno_ibfk_2` FOREIGN KEY (`Docente_ID`) REFERENCES `docente` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
