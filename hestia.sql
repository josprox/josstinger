-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-11-2024 a las 23:48:56
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mht`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jpx_check_users`
--

CREATE TABLE `jpx_check_users` (
  `id` bigint(21) NOT NULL,
  `id_user` bigint(21) NOT NULL,
  `accion` varchar(60) DEFAULT NULL,
  `url` varchar(16) DEFAULT NULL,
  `expiracion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jpx_hestia_accounts`
--

CREATE TABLE `jpx_hestia_accounts` (
  `id` bigint(21) NOT NULL,
  `nameserver` bigint(21) NOT NULL,
  `host` varchar(125) NOT NULL,
  `port` int(12) NOT NULL,
  `user` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jpx_hestia_accounts`
--

INSERT INTO `jpx_hestia_accounts` (`id`, `nameserver`, `host`, `port`, `user`, `password`) VALUES
(1, 1, 'home.tecnotech.ovh', 2053, 'admin', 'Andyyyo12?');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jpx_nameservers`
--

CREATE TABLE `jpx_nameservers` (
  `id` bigint(21) NOT NULL,
  `dns1` varchar(125) NOT NULL,
  `dns2` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jpx_nameservers`
--

INSERT INTO `jpx_nameservers` (`id`, `dns1`, `dns2`) VALUES
(1, 'dns10.tecnotech.ovh', 'ns10.tecnotech.ovh');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jpx_not_pay`
--

CREATE TABLE `jpx_not_pay` (
  `id` bigint(21) NOT NULL,
  `check_pay` varchar(255) DEFAULT NULL,
  `fecha` date NOT NULL,
  `dias` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jpx_request_dns`
--

CREATE TABLE `jpx_request_dns` (
  `id` bigint(21) NOT NULL,
  `id_hestia` bigint(21) NOT NULL,
  `id_nameserver` bigint(22) NOT NULL,
  `id_user` bigint(22) NOT NULL,
  `id_pedido` bigint(21) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jpx_roles`
--

CREATE TABLE `jpx_roles` (
  `id` bigint(21) NOT NULL,
  `rol` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jpx_roles`
--

INSERT INTO `jpx_roles` (`id`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Editor'),
(3, 'Autor'),
(4, 'Colaborador'),
(5, 'Suscriptor'),
(6, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jpx_servicios`
--

CREATE TABLE `jpx_servicios` (
  `id` bigint(21) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `descripcion` text NOT NULL,
  `descripcion_text` text NOT NULL,
  `precio` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jpx_servicios`
--

INSERT INTO `jpx_servicios` (`id`, `nombre`, `descripcion`, `descripcion_text`, `precio`, `created_at`, `updated_at`) VALUES
(1, 'Junior', '<span class=\"excerpt d-block\">Este hosting es el Junior, obtienes los siguientes beneficios:</span>\r\n<ul class=\"pricing-text mb-4\">\r\n<li>Dominios a usar: <strong>1 dominio.</strong></li>\r\n<li>Alias por cada web: <strong>5 alias.</strong></li>\r\n<li>SSL/TLS: <strong>ilimitado.</strong></li>\r\n<li>Espacio disponible: <strong>12MB.</strong></li>\r\n<li>Control de DNS: <strong>0 disponibles.</strong></li>\r\n<li>Registros DNS: <strong>Ninguno.</strong></li>\r\n<li>Base de datos: <strong>1 disponible.</strong></li>\r\n<li>Tareas programadas: <strong>0 disponibles.</strong></li>\r\n<li>Respaldos: <strong>0 disponibles.</strong></li>\r\n</ul>', 'Con el plan Junior tu podrás alojar sitios web super pequeños sin tener lentitudes de carga, podrás usar en tu host 1 dominio web con 5 alias máximo, tendrás la oportunidad de generar cualquier SSL/TLS de manera gratuita, tienes un espacio disponible de 12MB, no podrás alojar ningún dns, contarás con 1 base de datos, no podrás programar tareas ni respaldos.', 1, '2023-01-06 20:33:28', '2023-05-05 21:26:18'),
(2, 'Startup', '<span class=\"excerpt d-block\">Este hosting es el Startup, obtienes los siguientes beneficios:</span>\r\n<ul class=\"pricing-text mb-4\">\r\n<li>Dominios a usar: <strong>3 dominios.</strong></li>\r\n<li>Alias por cada web: <strong>3 alias.</strong></li>\r\n<li>SSL/TLS: <strong>ilimitado.</strong></li>\r\n<li>Espacio disponible: <strong>2GB.</strong></li>\r\n<li>Control de DNS: <strong>1 disponible.</strong></li>\r\n<li>Registros DNS: <strong>ilimitados.</strong></li>\r\n<li>Base de datos: <strong>5 disponibles.</strong></li>\r\n<li>Tareas programadas: <strong>1 disponible.</strong></li>\r\n<li>Respaldos: <strong>1 disponible.</strong></li>\r\n</ul>', 'Con el plan startup tu podrás alojar sitios web pequeños sin tener lentitudes de carga, podrás usar en tu host 3 dominios web con 3 alias máximo, tendrás la oportunidad de generar cualquier SSL/TLS de manera gratuita, tienes un espacio disponible de 2GB y podrás alojar 1 dominio web con registros dns ilimitados, contarás con 5 bases de datos, podrás programar 1 tarea y dispones de 1 respaldo.', 4.1, NULL, '2023-05-05 21:26:32'),
(3, 'Premium', '<span class=\"excerpt d-block\">Este hosting es el Premium, obtienes los siguientes beneficios:</span>\r\n<ul class=\"pricing-text mb-4\">\r\n<li>Dominios a usar: <strong>6 dominios.</strong></li>\r\n<li>Alias por cada web: <strong>10 alias.</strong></li>\r\n<li>SSL/TLS: <strong>ilimitado.</strong></li>\r\n<li>Espacio disponible: <strong>5GB.</strong></li>\r\n<li>Control de DNS: <strong>3 disponibles.</strong></li>\r\n<li>Registros DNS: <strong>ilimitados.</strong></li>\r\n<li>Base de datos: <strong>8 disponibles.</strong></li>\r\n<li>Tareas programadas: <strong>2 disponibles.</strong></li>\r\n<li>Respaldos: <strong>3 disponibles.</strong></li>\r\n</ul>', 'Con el plan Premium tu podrás alojar sitios web pequeños/medianos sin tener lentitudes de carga, podrás usar en tu host 6 dominios web con 10 alias máximo, tendrás la oportunidad de generar cualquier SSL/TLS de manera gratuita, tienes un espacio disponible de 5GB y podrás alojar 3 dominios web con registros dns ilimitados, contarás con 8 bases de datos, podrás programar 2 tareas y dispones de 3 respaldos.', 6.3, NULL, '2023-05-05 21:26:39'),
(4, 'Pro', '<span class=\"excerpt d-block\">Este hosting es el Pro, obtienes los siguientes beneficios:</span>\r\n<ul class=\"pricing-text mb-4\">\r\n<li>Dominios a usar: <strong>10 dominios.</strong></li>\r\n<li>Alias por cada web: <strong>20 alias.</strong></li>\r\n<li>SSL/TLS: <strong>ilimitado.</strong></li>\r\n<li>Espacio disponible: <strong>8GB.</strong></li>\r\n<li>Control de DNS: <strong>6 disponibles.</strong></li>\r\n<li>Registros DNS: <strong>ilimitados.</strong></li>\r\n<li>Base de datos: <strong>10 disponibles.</strong></li>\r\n<li>Tareas programadas: <strong>5 disponibles.</strong></li>\r\n<li>Respaldos: <strong>6 disponibles.</strong></li>\r\n</ul>', 'Con el plan Pro tu podrás alojar sitios web medianos/grandes sin tener lentitudes de carga, podrás usar en tu host 10 dominios web con 20 alias máximo, tendrás la oportunidad de generar cualquier SSL/TLS de manera gratuita, tienes un espacio disponible de 8GB y podrás alojar 6 dominios web con registros dns ilimitados, contarás con 10 bases de datos, podrás programar 5 tareas y dispones de 6 respaldos.', 8.4, NULL, '2023-05-05 21:26:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jpx_tareas`
--

CREATE TABLE `jpx_tareas` (
  `id` bigint(21) NOT NULL,
  `funcion` text NOT NULL,
  `sig_fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jpx_tokens_pays`
--

CREATE TABLE `jpx_tokens_pays` (
  `id` bigint(21) NOT NULL,
  `token` varchar(16) NOT NULL,
  `estado` varchar(16) DEFAULT NULL,
  `id_user` bigint(21) NOT NULL,
  `id_servicio` bigint(21) NOT NULL,
  `id_pedido` bigint(21) DEFAULT NULL,
  `id_pago` bigint(21) DEFAULT NULL,
  `pagado_con` text DEFAULT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `expiracion` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jpx_users`
--

CREATE TABLE `jpx_users` (
  `id` bigint(21) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_rol` bigint(21) NOT NULL,
  `phone` varchar(21) DEFAULT NULL,
  `checked_status` varchar(5) DEFAULT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `fa` varchar(1) NOT NULL,
  `type_fa` varchar(15) DEFAULT NULL,
  `two_fa` varchar(32) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jpx_users`
--

INSERT INTO `jpx_users` (`id`, `name`, `email`, `password`, `id_rol`, `phone`, `checked_status`, `last_ip`, `fa`, `type_fa`, `two_fa`, `created_at`, `updated_at`) VALUES
(1, 'Joss Estrada', 'joss@int.josprox.com', '$2y$10$P55N9GZ8OCNaVYOKmVqpNO.aHCEZV0XU4lzVw8UyULjyNEcY3HA1O', 1, '+525540373610', 'TRUE', '189.217.106.45', 'A', 'correo', NULL, '2022-10-04 00:39:35', '2024-11-16 22:29:41'),
(4, 'Tester Huawei', 'melchor.jose.190339@cetis054.edu.mx', '$2y$10$RAxKwneoe74rlg46cHeOquEeU.V9UfduyVwjTLvKLXWbRnVd9vijy', 6, '+525540373610', 'TRUE', '::1', 'D', 'correo', '', '2024-07-31 01:34:01', '2024-11-17 22:30:17'),
(6, 'CARLOS', 'leonk4311@gmail.com', '$2y$10$GS1vMK5.o4U6234UGYpBCeqBhUT2aHfZHL1czqFaKoAbGoyUOt/Xi', 6, NULL, NULL, NULL, 'A', 'correo', NULL, '2024-09-10 21:45:48', NULL),
(7, 'Lucky', 'Luckyhuawei00@gmail.com', '$2y$10$5dD9Zsug66fagIt4BYjeRuvlj2kTFEDeTVb4kng9WhHFvUf9nHIg6', 6, NULL, NULL, NULL, 'A', 'correo', NULL, '2024-09-12 15:13:06', NULL),
(8, 'Gustavo García García ', 'gustavo.garciagar@my.unitec.edu.mx', '$2y$10$0STAGkWT7RX/zfN1vF3B2OAXFLvUV/HQgwUAPwuLJWcAMSAFKSB/S', 6, NULL, 'TRUE', NULL, 'A', 'correo', NULL, '2024-09-27 20:25:07', '2024-09-27 20:26:13'),
(9, 'Alarcón González Ricardo Alberto ', 'alc.richy132@gmail.com', '$2y$10$6i/ZGSs7J711NCjoqbR/Buqbbw4VFGxcUGteVgDOU39f3MUTq2d.6', 6, NULL, NULL, NULL, 'A', 'correo', NULL, '2024-10-07 23:33:05', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `jpx_check_users`
--
ALTER TABLE `jpx_check_users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jpx_hestia_accounts`
--
ALTER TABLE `jpx_hestia_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jpx_nameservers`
--
ALTER TABLE `jpx_nameservers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jpx_not_pay`
--
ALTER TABLE `jpx_not_pay`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jpx_request_dns`
--
ALTER TABLE `jpx_request_dns`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jpx_roles`
--
ALTER TABLE `jpx_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jpx_servicios`
--
ALTER TABLE `jpx_servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jpx_tareas`
--
ALTER TABLE `jpx_tareas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jpx_tokens_pays`
--
ALTER TABLE `jpx_tokens_pays`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jpx_users`
--
ALTER TABLE `jpx_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `jpx_check_users`
--
ALTER TABLE `jpx_check_users`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `jpx_hestia_accounts`
--
ALTER TABLE `jpx_hestia_accounts`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `jpx_nameservers`
--
ALTER TABLE `jpx_nameservers`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `jpx_not_pay`
--
ALTER TABLE `jpx_not_pay`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jpx_request_dns`
--
ALTER TABLE `jpx_request_dns`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `jpx_roles`
--
ALTER TABLE `jpx_roles`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `jpx_servicios`
--
ALTER TABLE `jpx_servicios`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `jpx_tareas`
--
ALTER TABLE `jpx_tareas`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jpx_tokens_pays`
--
ALTER TABLE `jpx_tokens_pays`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `jpx_users`
--
ALTER TABLE `jpx_users`
  MODIFY `id` bigint(21) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `jpx_users`
--
ALTER TABLE `jpx_users`
  ADD CONSTRAINT `jpx_users_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `jpx_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
