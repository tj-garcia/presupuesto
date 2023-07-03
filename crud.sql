-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-07-2023 a las 13:52:22
-- Versión del servidor: 10.1.9-MariaDB
-- Versión de PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `crud`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `id` int(11) NOT NULL,
  `nombres` varchar(255) DEFAULT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `estado` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id`, `nombres`, `apellidos`, `estado`) VALUES
(1, 'Elivar Oswaldo', 'Largo Rios', '1'),
(5, 'Juan', 'Vargas', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `beneficiario`
--

CREATE TABLE `beneficiario` (
  `id` int(9) NOT NULL,
  `nombres` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(11) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ciudad` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT 'VALLE DE LA PASCUA',
  `estado` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT 'GUÁRICO',
  `sector` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estatus` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ayudas` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `beneficiario`
--

INSERT INTO `beneficiario` (`id`, `nombres`, `apellidos`, `telefono`, `ciudad`, `estado`, `sector`, `direccion`, `estatus`, `ayudas`) VALUES
(2000000, 'pedro jose', 'araujo escalona', '20', '20', 'guarico', '20', 'direccion20', 'activo', 0),
(10000000, 'nombre', 'apellido', 'telefono', 'ciudad', 'guarico', 'sector', 'direccion', 'activo', 0),
(30000000, 'treinta', 'treinta', '02353000000', 'valle de la pascua', 'guarico', 'sector', 'direccion', 'activo', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_catg` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `deno_catg` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `nivel_catg` varchar(15) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Sub Categría',
  `cantSol_catg` int(6) NOT NULL,
  `cantEntr_catg` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_catg`, `deno_catg`, `nivel_catg`, `cantSol_catg`, `cantEntr_catg`) VALUES
('01000', 'MÉDICOS', 'Categoría', 0, 0),
('01001', 'MEDICAMENTOS', 'Sub Categoría', 0, 0),
('01002', 'CITA MEDICA', 'Sub Categría', 0, 0),
('01003', 'CIRUGIA', 'Sub Categría', 0, 0),
('02000', 'ALIMENTOS', 'Categoría', 0, 0),
('02001', 'ALIMENTOS', 'Sub Categría', 0, 0),
('03000', 'VIVIENDA', 'Categoría', 0, 0),
('03001', 'ADQUISICIÓN', 'Sub Categría', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donaciones`
--

CREATE TABLE `donaciones` (
  `id_donac` int(10) NOT NULL,
  `codi_donac` int(10) NOT NULL,
  `asun_donac` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `desc_donac` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `id_catg` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `estat_donac` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `solic_donac` date NOT NULL,
  `cierr_donac` date NOT NULL,
  `usua_sist` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` varchar(8) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(8) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombres` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `clave`, `nombres`, `apellidos`, `estado`) VALUES
('admin', 'admin', 'Administrador', 'Administrador', 'Activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `beneficiario`
--
ALTER TABLE `beneficiario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumno`
--
ALTER TABLE `alumno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
