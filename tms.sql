-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-02-2019 a las 02:57:39
-- Versión del servidor: 10.1.35-MariaDB
-- Versión de PHP: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tms`
--
CREATE DATABASE IF NOT EXISTS `tms` DEFAULT CHARACTER SET utf16 COLLATE utf16_unicode_ci;
USE `tms`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tms_score`
--
-- Creación: 09-02-2019 a las 03:03:26
-- Última actualización: 15-02-2019 a las 01:48:15
-- Última revisión: 14-02-2019 a las 20:51:22
--

DROP TABLE IF EXISTS `tms_score`;
CREATE TABLE `tms_score` (
  `id` int(11) NOT NULL,
  `gen` varchar(32) COLLATE utf8_bin NOT NULL,
  `user` varchar(20) COLLATE utf8_bin NOT NULL,
  `time` float NOT NULL,
  `country` varchar(10) COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- RELACIONES PARA LA TABLA `tms_score`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tms_statics`
--
-- Creación: 14-02-2019 a las 21:24:04
--

DROP TABLE IF EXISTS `tms_statics`;
CREATE TABLE `tms_statics` (
  `id` int(11) NOT NULL,
  `scoreboard` int(11) NOT NULL,
  `games` int(11) NOT NULL,
  `country` varchar(10) COLLATE utf16_unicode_ci NOT NULL,
  `gen` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- RELACIONES PARA LA TABLA `tms_statics`:
--

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tms_score`
--
ALTER TABLE `tms_score`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tms_statics`
--
ALTER TABLE `tms_statics`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tms_score`
--
ALTER TABLE `tms_score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tms_statics`
--
ALTER TABLE `tms_statics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


--
-- Metadatos
--
USE `phpmyadmin`;

--
-- Metadatos para la tabla tms_score
--

--
-- Metadatos para la tabla tms_statics
--

--
-- Metadatos para la base de datos tms
--
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
