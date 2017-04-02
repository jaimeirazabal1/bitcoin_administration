-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 02-04-2017 a las 12:05:31
-- Versión del servidor: 5.7.17-0ubuntu0.16.04.1
-- Versión de PHP: 5.6.30-7+deb.sury.org~xenial+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `administracion_bitcoin`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `currencies`
--

CREATE TABLE `currencies` (
  `currency` char(20) NOT NULL DEFAULT '',
  `currabrev` char(3) NOT NULL DEFAULT '',
  `country` char(50) NOT NULL DEFAULT '',
  `hundredsname` char(15) NOT NULL DEFAULT 'Cents',
  `decimalplaces` tinyint(3) NOT NULL DEFAULT '2',
  `rate` double NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `currencies`
--

INSERT INTO `currencies` (`currency`, `currabrev`, `country`, `hundredsname`, `decimalplaces`, `rate`) VALUES
('Peso Colombiano', 'COP', 'Colombia', 'cents', 2, 2045),
('Dolar Americano', 'USD', 'USA', 'cents', 2, 1),
('Bolivar Fuerte', 'VEF', 'Venezuela', 'cents', 2, 260);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transaction`
--

CREATE TABLE `transaction` (
  `idoperacion` varchar(200) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `moneda` varchar(20) NOT NULL,
  `btc` varchar(20) NOT NULL,
  `monto` varchar(20) NOT NULL,
  `ref_pago` varchar(100) NOT NULL,
  `observacion` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transaction`
--

INSERT INTO `transaction` (`idoperacion`, `tipo`, `moneda`, `btc`, `monto`, `ref_pago`, `observacion`, `created`) VALUES
('111', 'compra', 'COP', '0.03685504', '150,000.00', '444', '555', '2017-04-01 20:20:39'),
('1212412', 'compra', 'VEF', '0,2141697', '883.450,00', '123123123', 'segunda linea compra ', '2017-04-02 11:23:18'),
('1231231', 'compra', 'VEF', '0,03685504', '150.000,00', '4213123123', ' primera linea del ejemplo', '2017-04-02 21:22:56'),
('12412312', 'compra', 'VEF', '0,11990408', '500.000,00', '123123', ' cuarta linea', '2017-04-02 11:23:57'),
('124123123', 'compra', 'VEF', '0,10856454', '450.000,00', '13212312', ' tercera linea ', '2017-05-10 11:23:40'),
('34121323', 'venta', 'VEF', '0,03685504', '150.000,00', '231323', ' primera fila venta', '2017-05-11 12:18:40'),
('3435323', 'venta', 'VEF', '0,08973888', '373.000,00', '23423', ' segunda fila venta', '2017-04-02 12:18:54'),
('632341', 'venta', 'VEF', '0,1207797', '500.000,00', '151252', ' tercera fila venta', '2017-04-02 12:19:10');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`currabrev`),
  ADD KEY `Country` (`country`);

--
-- Indices de la tabla `transaction`
--
ALTER TABLE `transaction`
  ADD UNIQUE KEY `idoperacion` (`idoperacion`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
