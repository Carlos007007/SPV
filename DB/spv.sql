-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-03-2024 a las 23:11:17
-- Versión del servidor: 5.7.33
-- Versión de PHP: 8.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `spv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `Codigo` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `Nombres` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `Apellidos` varchar(70) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`Codigo`, `Nombres`, `Apellidos`) VALUES
('AC87720821', 'Administrador', 'Principal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase`
--

CREATE TABLE `clase` (
  `id` int(7) NOT NULL,
  `Video` text COLLATE utf8_spanish2_ci NOT NULL,
  `Fecha` date NOT NULL,
  `Titulo` varchar(535) COLLATE utf8_spanish2_ci NOT NULL,
  `Tutor` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `Adjuntos` text COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `idc` int(17) NOT NULL,
  `id` int(7) NOT NULL,
  `Fecha` datetime NOT NULL,
  `Comentario` text COLLATE utf8_spanish2_ci NOT NULL,
  `Adjunto` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `Tipo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `Codigo` varchar(70) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

CREATE TABLE `cuenta` (
  `id` int(7) NOT NULL,
  `Privilegio` int(1) NOT NULL,
  `Usuario` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `Clave` varchar(535) COLLATE utf8_spanish2_ci NOT NULL,
  `Tipo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `Genero` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `Codigo` varchar(70) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cuenta`
--

INSERT INTO `cuenta` (`id`, `Privilegio`, `Usuario`, `Clave`, `Tipo`, `Genero`, `Codigo`) VALUES
(1, 1, 'Administrador', 'NXVlQVZFeTRBV3pTL1R5WEFGY2dMdz09', 'Administrador', 'Masculino', 'AC87720821');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `Codigo` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `Nombres` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `Apellidos` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `Email` varchar(70) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Codigo`);

--
-- Indices de la tabla `clase`
--
ALTER TABLE `clase`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`idc`);

--
-- Indices de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`Codigo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clase`
--
ALTER TABLE `clase`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `idc` int(17) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
