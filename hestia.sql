-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-12-2022 a las 02:00:06
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hestia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hestia_accounts`
--

CREATE TABLE `hestia_accounts` (
  `id` bigint(21) NOT NULL,
  `nameserver` bigint(21) NOT NULL,
  `host` varchar(125) NOT NULL,
  `port` int(12) NOT NULL,
  `user` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `hestia_accounts`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nameservers`
--

CREATE TABLE `nameservers` (
  `id` bigint(21) NOT NULL,
  `dns1` varchar(125) NOT NULL,
  `dns2` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `nameservers`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `not_pay`
--

CREATE TABLE `not_pay` (
  `id` bigint(25) NOT NULL,
  `check_pay` varchar(255) DEFAULT NULL,
  `fecha` date NOT NULL,
  `dias` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `request_dns`
--

CREATE TABLE `request_dns` (
  `id` bigint(22) NOT NULL,
  `id_hestia` bigint(21) NOT NULL,
  `id_nameserver` bigint(22) NOT NULL,
  `id_user` bigint(22) NOT NULL,
  `id_pedido` bigint(21) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `rol` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Editor'),
(3, 'Autor'),
(4, 'Colaborador'),
(5, 'Suscriptor'),
(6, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` bigint(21) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `descripcion` text NOT NULL,
  `descripcion_text` text NOT NULL,
  `precio` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`, `descripcion`, `descripcion_text`, `precio`, `created_at`, `updated_at`) VALUES
(1, 'Startup', '<span class=\"excerpt d-block\">Este hosting es el Startup, obtienes los siguientes beneficios:</span>\r\n<ul class=\"pricing-text mb-4\">\r\n<li>Dominios a usar: <strong>3 dominios.</strong></li>\r\n<li>Alias por cada web: <strong>3 alias.</strong></li>\r\n<li>SSL/TLS: <strong>ilimitado.</strong></li>\r\n<li>Espacio disponible: <strong>2GB.</strong></li>\r\n<li>Control de DNS: <strong>1 disponible.</strong></li>\r\n<li>Registros DNS: <strong>ilimitados.</strong></li>\r\n<li>Base de datos: <strong>5 disponibles.</strong></li>\r\n<li>Tareas programadas: <strong>1 disponible.</strong></li>\r\n<li>Respaldos: <strong>1 disponible.</strong></li>\r\n</ul>', 'Con el plan startup tu podrás alojar sitios web pequeños sin tener lentitudes de carga, podrás usar en tu host 3 dominios web con 3 alias máximo, tendrás la oportunidad de generar cualquier SSL/TLS de manera gratuita, tienes un espacio disponible de 2GB y podrás alojar 1 dominio web con registros dns ilimitados, contarás con 5 bases de datos, podrás programar 1 tarea y dispones de 1 respaldo.', 5.99, NULL, '2022-12-04 23:54:13'),
(2, 'Premium', '<span class=\"excerpt d-block\">Este hosting es el Premium, obtienes los siguientes beneficios:</span>\r\n<ul class=\"pricing-text mb-4\">\r\n<li>Dominios a usar: <strong>6 dominios.</strong></li>\r\n<li>Alias por cada web: <strong>10 alias.</strong></li>\r\n<li>SSL/TLS: <strong>ilimitado.</strong></li>\r\n<li>Espacio disponible: <strong>5GB.</strong></li>\r\n<li>Control de DNS: <strong>3 disponibles.</strong></li>\r\n<li>Registros DNS: <strong>ilimitados.</strong></li>\r\n<li>Base de datos: <strong>8 disponibles.</strong></li>\r\n<li>Tareas programadas: <strong>2 disponibles.</strong></li>\r\n<li>Respaldos: <strong>3 disponibles.</strong></li>\r\n</ul>', 'Con el plan Premium tu podrás alojar sitios web pequeños/medianos sin tener lentitudes de carga, podrás usar en tu host 6 dominios web con 10 alias máximo, tendrás la oportunidad de generar cualquier SSL/TLS de manera gratuita, tienes un espacio disponible de 5GB y podrás alojar 3 dominios web con registros dns ilimitados, contarás con 8 bases de datos, podrás programar 2 tareas y dispones de 3 respaldos.', 8.25, NULL, '2022-12-04 23:54:18'),
(3, 'Pro', '<span class=\"excerpt d-block\">Este hosting es el Pro, obtienes los siguientes beneficios:</span>\r\n<ul class=\"pricing-text mb-4\">\r\n<li>Dominios a usar: <strong>10 dominios.</strong></li>\r\n<li>Alias por cada web: <strong>20 alias.</strong></li>\r\n<li>SSL/TLS: <strong>ilimitado.</strong></li>\r\n<li>Espacio disponible: <strong>8GB.</strong></li>\r\n<li>Control de DNS: <strong>6 disponibles.</strong></li>\r\n<li>Registros DNS: <strong>ilimitados.</strong></li>\r\n<li>Base de datos: <strong>10 disponibles.</strong></li>\r\n<li>Tareas programadas: <strong>5 disponibles.</strong></li>\r\n<li>Respaldos: <strong>6 disponibles.</strong></li>\r\n</ul>', 'Con el plan Pro tu podrás alojar sitios web medianos/grandes sin tener lentitudes de carga, podrás usar en tu host 10 dominios web con 20 alias máximo, tendrás la oportunidad de generar cualquier SSL/TLS de manera gratuita, tienes un espacio disponible de 8GB y podrás alojar 6 dominios web con registros dns ilimitados, contarás con 10 bases de datos, podrás programar 5 tareas y dispones de 6 respaldos.', 12, NULL, '2022-12-04 23:54:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokens_pays`
--

CREATE TABLE `tokens_pays` (
  `id` bigint(21) NOT NULL,
  `token` varchar(16) NOT NULL,
  `estado` varchar(16) DEFAULT NULL,
  `id_user` bigint(21) NOT NULL,
  `id_servicio` bigint(21) NOT NULL,
  `id_pedido` bigint(21) DEFAULT NULL,
  `id_pago` int(21) DEFAULT NULL,
  `pagado_con` text DEFAULT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `expiracion` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `id_rol`, `last_ip`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'joss@int.josprox.com', '$2y$10$cS/2ZbYc.scMD8bJdxGG1ObsLgQxVJy/cHX3hH/NRSWxScfHq.kMO', 1, NULL, '2022-10-04 00:39:35', '2022-12-04 21:52:10');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `hestia_accounts`
--
ALTER TABLE `hestia_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `nameservers`
--
ALTER TABLE `nameservers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `not_pay`
--
ALTER TABLE `not_pay`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `request_dns`
--
ALTER TABLE `request_dns`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tokens_pays`
--
ALTER TABLE `tokens_pays`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `hestia_accounts`
--
ALTER TABLE `hestia_accounts`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nameservers`
--
ALTER TABLE `nameservers`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `not_pay`
--
ALTER TABLE `not_pay`
  MODIFY `id` bigint(25) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `request_dns`
--
ALTER TABLE `request_dns`
  MODIFY `id` bigint(22) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tokens_pays`
--
ALTER TABLE `tokens_pays`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
