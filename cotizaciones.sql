-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-09-2024 a las 19:15:01
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cotizaciones`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos_cotizacion`
--

CREATE TABLE `archivos_cotizacion` (
  `id` int(11) NOT NULL,
  `cotizacion_id` int(11) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `ruta_archivo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `cedula` varchar(250) NOT NULL,
  `nombre_cliente` varchar(255) NOT NULL,
  `contacto` varchar(255) NOT NULL,
  `cargo` varchar(255) NOT NULL,
  `ciudad` varchar(255) NOT NULL,
  `telefono_cliente` char(30) NOT NULL,
  `email_cliente` varchar(64) NOT NULL,
  `direccion_cliente` varchar(255) NOT NULL,
  `status_cliente` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `id_moneda` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `cedula`, `nombre_cliente`, `contacto`, `cargo`, `ciudad`, `telefono_cliente`, `email_cliente`, `direccion_cliente`, `status_cliente`, `date_added`, `id_moneda`) VALUES
(235, '900788217', 'AG DISEÑOS Y CONSTRUCCIONES SAS', 'ING ERNESTO ERAZO', '', 'BOGOTA', '3174241316', 'eerazo@agconstrucciones.com.co', 'CRA 63 # 14-75', 1, '2024-08-28 12:59:06', 0),
(237, '800165694', 'AUTONORTE SAS', 'Clara Morales Morales', 'Asistente de gerencia/recepción', 'Barranquilla', '318 7074175', 'recepcionc@autonorte.com.co', 'Avenida circunvalar calle 110 43c#91', 1, '2024-08-30 11:36:53', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `currencies`
--

CREATE TABLE `currencies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `precision` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `thousand_separator` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `decimal_separator` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `symbol`, `precision`, `thousand_separator`, `decimal_separator`, `code`) VALUES
(1, 'Peso Colombiano', '$', '2', ',', '.', 'COP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `id_detalle` int(11) NOT NULL,
  `numero_factura` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_factura`
--

INSERT INTO `detalle_factura` (`id_detalle`, `numero_factura`, `id_producto`, `cantidad`, `precio_venta`) VALUES
(804, 8, 1, 1, 0),
(803, 8, 2, 1, 0),
(802, 7, 1, 1, 0),
(801, 7, 2, 1, 0),
(800, 6, 1, 1, 0),
(799, 6, 2, 1, 0),
(798, 6, 3, 1, 0),
(797, 6, 1, 1, 0),
(796, 6, 2, 1, 0),
(794, 6, 3, 1, 0),
(795, 6, 2, 1, 0),
(790, 5, 2, 1, 0),
(784, 2, 2, 1, 0),
(781, 1, 2, 1, 0),
(783, 2, 3, 1, 0),
(780, 1, 3, 1, 0),
(788, 4, 2, 1, 0),
(785, 2, 1, 1, 0),
(789, 4, 1, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_factura` int(11) NOT NULL,
  `numero_factura` int(11) NOT NULL,
  `fecha_factura` datetime NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `condiciones` varchar(30) NOT NULL,
  `total_venta` varchar(20) NOT NULL,
  `estado_factura` tinyint(1) NOT NULL,
  `nota` varchar(500) DEFAULT NULL,
  `tiempo_entrega` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id_factura`, `numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `total_venta`, `estado_factura`, `nota`, `tiempo_entrega`) VALUES
(5, 1, '2024-09-03 19:59:44', 235, 1, '1', '0', 1, 'aaasasasas', 'aaa'),
(6, 2, '2024-09-03 20:50:43', 235, 1, '1', '0', 1, 'aaaa', 'aaa'),
(7, 3, '2024-09-03 20:55:37', 235, 1, '1', '0', 2, 'AAAAAAAAAA', 'Prueba'),
(8, 4, '2024-09-03 22:21:26', 235, 1, '1', '0', 3, 'aaa', 'aaa'),
(9, 5, '2024-09-03 22:50:32', 235, 1, '1', '0', 2, 'aaa', ''),
(10, 6, '2024-09-05 18:19:11', 235, 1, '1', '0', 1, 'aa', 'aaaa'),
(11, 7, '2024-09-05 19:00:18', 235, 1, '1', '0', 1, 'aaa', 'aaaaa'),
(12, 8, '2024-09-05 19:01:32', 235, 1, '1', '0', 1, 'aaa', 'aaaa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL,
  `nit_empresa` varchar(250) NOT NULL,
  `nombre_empresa` varchar(150) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `codigo_postal` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(64) NOT NULL,
  `impuesto` int(2) DEFAULT NULL,
  `moneda` varchar(6) NOT NULL,
  `logo_url` varchar(255) NOT NULL,
  `mensaje_factura` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `nit_empresa`, `nombre_empresa`, `direccion`, `ciudad`, `codigo_postal`, `estado`, `telefono`, `email`, `impuesto`, `moneda`, `logo_url`, `mensaje_factura`) VALUES
(1, '830.015.914-3', 'COTIZACIÓN SERVICIO DE GALVANIZADO', 'Bogotá D.C', 'Carrera 123 #14a - 11,', '110110', 'Malambo, Atlántico AV Oriental 5-56 ', '(601) 4220980', 'servicioalcliente@polyuprotec.com', 19, '$', 'img/1715873946_LOGO-SIN FONDO (POLYUPROTEC).png', 'Prueba																																							');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id_producto` int(11) NOT NULL,
  `codigo_producto` char(20) NOT NULL,
  `nombre_producto` char(255) NOT NULL,
  `kilogramos` char(20) NOT NULL,
  `status_producto` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `precio_producto` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id_producto`, `codigo_producto`, `nombre_producto`, `kilogramos`, `status_producto`, `date_added`, `precio_producto`) VALUES
(1, '1', 'GALVANIZADO POR INMERSIÓN SENCILLA', 'KG', 1, '2024-03-15 16:46:17', 0),
(2, '2', 'GALVANIZADO POR DOBLE INMERSIÓN', 'KG', 1, '2024-03-22 17:40:26', 0),
(3, '3', 'CENTRIFUGADO', 'UND', 1, '2024-03-22 17:40:42', 0),
(4, '4', 'GRANALLADO', 'UND', 1, '2024-03-22 17:40:54', 0),
(5, '5', 'PERFORACIONES', 'UND', 1, '2024-03-22 17:41:09', 0),
(6, '6', 'DECAPADO', 'UND', 1, '2024-03-22 17:41:22', 0),
(7, '7', 'PINTURA', 'UND', 1, '2024-03-22 17:41:35', 0),
(8, '8', 'PRIME ZINC LATA AEROSOL 400ML', 'KG', 1, '2024-03-22 17:41:48', 0),
(9, '9', 'PRIME ZINC GALÓN', 'UND', 1, '2024-03-22 17:42:02', 0),
(10, '10', 'PRIME ZINC MEDIO GALÓN', 'KG', 1, '2024-03-22 17:42:22', 0),
(11, '11', 'PRIME ZINC 1/4 DE GALÓN', 'Kg', 1, '2024-03-22 17:42:39', 0),
(18, '12', 'TRANSPORTE', 'N/A', 1, '2024-04-04 22:55:27', 0),
(19, '13', 'OREJAS PARA COLGAR', 'UND', 1, '2024-05-02 09:34:16', 3000),
(20, '14', 'QUEMADO (LIMPIEZA DE CALAMINA EN TUBERIA)', 'KG', 1, '2024-05-24 15:49:40', 400),
(21, '15', 'SHOTBLASTING', 'KG', 1, '2024-05-28 10:03:58', 400),
(22, '16', 'PRUEBA', 'Kilogramos', 1, '2024-09-04 18:27:17', 10000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp`
--

CREATE TABLE `tmp` (
  `id_tmp` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_tmp` int(11) NOT NULL,
  `precio_tmp` double(10,2) DEFAULT NULL,
  `session_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tmp`
--

INSERT INTO `tmp` (`id_tmp`, `id_producto`, `cantidad_tmp`, `precio_tmp`, `session_id`) VALUES
(796, 4, 1, 0.00, 'bvcut3qr2ltf4h48oducqpc30c'),
(795, 2, 1, 0.00, 'bvcut3qr2ltf4h48oducqpc30c'),
(794, 1, 1, 0.00, 'bvcut3qr2ltf4h48oducqpc30c'),
(789, 1, 1, 0.00, 'jo5pisjladlubi14pkqtajq0f0'),
(788, 2, 1, 0.00, 'jo5pisjladlubi14pkqtajq0f0'),
(787, 1, 1, 0.00, 'jo5pisjladlubi14pkqtajq0f0'),
(786, 1, 1, 0.00, 'jo5pisjladlubi14pkqtajq0f0'),
(785, 1, 1, 0.00, 'jo5pisjladlubi14pkqtajq0f0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL COMMENT 'auto incrementing user_id of each user, unique index',
  `firstname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  `celular` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `user_name`, `user_password_hash`, `user_email`, `celular`, `date_added`) VALUES
(1, 'Jeider', 'Buelvas', 'Programador', '$2y$10$ibQoPbEx2O2jusvUPmZil.Zqi8yeCA/gVU4cJr5oekHAjiaZk3LVW', 'jbuelvas@polyuprotec.com', '3134512321', '2024-07-24 15:06:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos_cotizacion`
--
ALTER TABLE `archivos_cotizacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cotizacion_id` (`cotizacion_id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `codigo_producto` (`nombre_cliente`);

--
-- Indices de la tabla `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `numero_cotizacion` (`numero_factura`,`id_producto`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_factura`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `codigo_producto` (`codigo_producto`);

--
-- Indices de la tabla `tmp`
--
ALTER TABLE `tmp`
  ADD PRIMARY KEY (`id_tmp`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos_cotizacion`
--
ALTER TABLE `archivos_cotizacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT de la tabla `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=805;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `tmp`
--
ALTER TABLE `tmp`
  MODIFY `id_tmp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=797;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index', AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archivos_cotizacion`
--
ALTER TABLE `archivos_cotizacion`
  ADD CONSTRAINT `archivos_cotizacion_ibfk_1` FOREIGN KEY (`cotizacion_id`) REFERENCES `facturas` (`id_factura`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
