-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 07-11-2023 a las 19:09:16
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestorpermisos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area_usuario`
--

DROP TABLE IF EXISTS `area_usuario`;
CREATE TABLE IF NOT EXISTS `area_usuario` (
  `ID` smallint NOT NULL AUTO_INCREMENT,
  `area_usuario_nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `area_usuario_valor` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `area_usuario`
--

INSERT INTO `area_usuario` (`ID`, `area_usuario_nombre`, `area_usuario_valor`) VALUES
(1, 'Subdireccion Academica', 1),
(2, 'Planeacion y Vinculacion', 2),
(3, 'Administracion y Finanzas', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

DROP TABLE IF EXISTS `estado`;
CREATE TABLE IF NOT EXISTS `estado` (
  `ID` smallint NOT NULL AUTO_INCREMENT,
  `Estado_nombre` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Estado_valor` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`ID`, `Estado_nombre`, `Estado_valor`) VALUES
(31, 'En espera', 0),
(32, 'Aceptada', 1),
(33, 'Rechazada', 2),
(34, 'Visto Bueno', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivo`
--

DROP TABLE IF EXISTS `motivo`;
CREATE TABLE IF NOT EXISTS `motivo` (
  `ID` smallint NOT NULL AUTO_INCREMENT,
  `Motivo_nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Motivo_valor` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `motivo`
--

INSERT INTO `motivo` (`ID`, `Motivo_nombre`, `Motivo_valor`) VALUES
(11, 'Viaje Academico', 1),
(12, 'Enfermedad', 2),
(13, 'Cita Medica', 3),
(14, 'Asuntos Personales', 4),
(15, 'Formacion o Capacitacion', 5),
(16, 'Actividades Academicas', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

DROP TABLE IF EXISTS `perfil`;
CREATE TABLE IF NOT EXISTS `perfil` (
  `id` smallint NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `apellido` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sexo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `area` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `puesto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `User_ID` smallint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `User_ID` (`User_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id`, `nombre`, `apellido`, `sexo`, `area`, `puesto`, `create_at`, `update_at`, `User_ID`) VALUES
(13, 'Adolfo Angel', 'Chan Marin', 'Masculino', 'Jefe de Departamento de Carreras Profesionales', 'Administrativo', '2023-05-29 18:39:46', '2023-05-29 18:39:46', 17),
(14, 'Angel1', 'Marin', 'Masculino', 'Jefe Directo - Planeacion y Vinculacion', 'Administrativo', '2023-05-29 18:44:00', '2023-05-29 18:44:00', 18),
(15, 'Angel2', 'Marin', 'Masculino', 'Jefe de Departamento de Recursos Humanos', 'Administrativo', '2023-05-29 18:46:23', '2023-05-29 18:46:23', 19),
(16, 'Jesus', 'Guadalupe', 'Masculino', 'Ingenieria En Sistemas Computacionales', 'Docente', '2023-05-29 18:47:37', '2023-05-29 18:47:37', 20),
(17, 'David', 'Balam', 'Masculino', 'Ingenieria Ambiental', 'Docente', '2023-05-30 13:58:31', '2023-05-30 13:58:31', 21),
(20, 'pedro', 'marin', 'Masculino', 'Ingenieria En Gestion Empresarial', 'Docente', '2023-08-11 17:56:54', '2023-08-11 17:56:54', 24),
(21, 'Dario', 'Balam', 'Masculino', ' Jefe Directo - Subdireccion Academica', 'Administrativo', '2023-09-05 17:08:21', '2023-09-05 17:08:21', 25),
(22, 'Gonzalo', 'Cen', 'Masculino', 'Jefe Directo - Administraci', 'Administrativo', '2023-09-05 17:16:55', '2023-09-05 17:16:55', 26),
(23, 'Armando', 'Camal', 'Masculino', 'Jefe Directo', 'Administrativo', '2023-09-14 00:54:45', '2023-09-14 00:54:45', 27),
(24, 'Armando', 'Camal', 'Masculino', 'Jefe Directo', 'Administrativo', '2023-09-14 00:55:09', '2023-09-14 00:55:09', 28),
(25, 'Armando', 'Camal', 'Masculino', 'Jefe Directo', 'Administrativo', '2023-09-14 00:55:20', '2023-09-14 00:55:20', 29),
(26, 'Armando', 'Camal', 'Masculino', 'Jefe Directo', 'Administrativo', '2023-09-14 01:01:19', '2023-09-14 01:01:19', 30),
(28, 'Guadalupe', 'Balam', 'Masculino', 'Jefe Directo', 'Administrativo', '2023-09-14 13:19:24', '2023-09-14 13:19:24', 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reposicion`
--

DROP TABLE IF EXISTS `reposicion`;
CREATE TABLE IF NOT EXISTS `reposicion` (
  `ID` smallint NOT NULL AUTO_INCREMENT,
  `Reposicion_nombre` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Reposicion_valor` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reposicion`
--

INSERT INTO `reposicion` (`ID`, `Reposicion_nombre`, `Reposicion_valor`) VALUES
(8, 'Con reposicion de Horario', 1),
(9, 'Sin reposicion de Horario', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `ID` smallint NOT NULL AUTO_INCREMENT,
  `Rol_nombre` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Rol_valor` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`ID`, `Rol_nombre`, `Rol_valor`) VALUES
(21, 'Personal', 8),
(22, 'Jefe', 9),
(23, 'Administrador', 10),
(24, 'Recursos_Humanos', 11),
(25, 'Inactivo', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

DROP TABLE IF EXISTS `solicitud`;
CREATE TABLE IF NOT EXISTS `solicitud` (
  `ID` smallint NOT NULL AUTO_INCREMENT,
  `Tipo_solicitud_ID` smallint DEFAULT NULL,
  `Request_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `de_fecha` datetime DEFAULT NULL,
  `a_fecha` datetime DEFAULT NULL,
  `reposicion` text COLLATE utf8mb4_general_ci,
  `fecha_r1` datetime DEFAULT NULL,
  `fecha_r2` datetime DEFAULT NULL,
  `sueldo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `hora_establecida` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Hora_modificada` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `motivo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `otro` text COLLATE utf8mb4_general_ci,
  `adjunto` longblob,
  `motivo_id` smallint DEFAULT NULL,
  `User_ID` smallint DEFAULT NULL,
  `Estado_ID` smallint DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Tipo_solicitud_ID` (`Tipo_solicitud_ID`),
  KEY `User_ID` (`User_ID`),
  KEY `Estado_ID` (`Estado_ID`),
  KEY `motivo_id` (`motivo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud`
--

INSERT INTO `solicitud` (`ID`, `Tipo_solicitud_ID`, `Request_at`, `de_fecha`, `a_fecha`, `reposicion`, `fecha_r1`, `fecha_r2`, `sueldo`, `hora_establecida`, `Hora_modificada`, `motivo`, `otro`, `adjunto`, `motivo_id`, `User_ID`, `Estado_ID`) VALUES
(4, 41, '2023-05-30 14:33:16', '2023-05-07 14:33:00', '2023-05-08 14:33:00', 'Sin reposicion', NULL, NULL, ' Sin Gose de sueldo', NULL, NULL, 'Enfermedad', NULL, NULL, NULL, 21, 32),
(8, 42, '2023-07-04 21:34:49', '2023-07-02 21:34:00', '2023-07-04 21:34:00', 'Con reposicion', '2023-07-06 21:34:00', '2023-07-07 21:34:00', 'Con Gose de sueldo', NULL, NULL, 'Enfermedad', NULL, 0x2e2e2f41646a756e746f735f746d702f6d6172696f2e6a7067, NULL, 20, 31),
(9, 41, '2023-07-12 13:48:16', '2023-07-12 04:49:00', '2023-07-13 13:46:00', 'Sin reposicion', NULL, NULL, ' Sin Gose de sueldo', NULL, NULL, 'Viaje Academico', '', NULL, NULL, 20, 33),
(11, 41, '2023-10-13 18:02:28', '2023-10-08 18:02:00', '2023-10-09 18:02:00', 'Sin reposicion', NULL, NULL, 'Con Gose de sueldo', NULL, NULL, 'Asuntos Personales', NULL, NULL, NULL, 20, 31),
(13, 43, '2023-10-13 18:23:09', NULL, NULL, NULL, NULL, NULL, NULL, '18:22 - 19:22', '22:22 - 23:27', 'Formacion o Capacitacion', '', NULL, NULL, 20, 31);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_solicitud`
--

DROP TABLE IF EXISTS `tipo_solicitud`;
CREATE TABLE IF NOT EXISTS `tipo_solicitud` (
  `ID` smallint NOT NULL AUTO_INCREMENT,
  `Tipo_solicitud_nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Tipo_solicitud_valor` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_solicitud`
--

INSERT INTO `tipo_solicitud` (`ID`, `Tipo_solicitud_nombre`, `Tipo_solicitud_valor`) VALUES
(41, 'Permiso', 3),
(42, 'Justificación Médica', 6),
(43, 'Cambio de horario o Compactación', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `ID` smallint NOT NULL AUTO_INCREMENT,
  `Tipo_usuario_nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Tipo_usuario_valor` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`ID`, `Tipo_usuario_nombre`, `Tipo_usuario_valor`) VALUES
(15, 'Docente', 1),
(16, 'NO docente', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` smallint NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `auth_key` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Rol_ID` smallint DEFAULT NULL,
  `Tipo_usuario_ID` smallint DEFAULT NULL,
  `area_usuario_id` smallint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Tipo_usuario_ID` (`Tipo_usuario_ID`),
  KEY `Rol_ID` (`Rol_ID`),
  KEY `area_usuario_id` (`area_usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `create_at`, `update_at`, `Rol_ID`, `Tipo_usuario_ID`, `area_usuario_id`) VALUES
(17, 'admin', NULL, '$2y$10$TvFhT2kYdY2JzZPxe2p.Cuz2YNHaGtFo3i4pnmg/uI0TKd/1o1DM.', NULL, 'adolfoangel@gmail.com', '2023-05-29 18:39:46', '2023-09-05 15:35:26', 23, 16, NULL),
(18, 'jefe1', NULL, '$2y$10$JrLe8MUqwn4Ba9KszOJ.pu2e2Lg2qSX6BuHT9kJcD4vy/B2T/Myn.', NULL, 'angel@mail.com', '2023-05-29 18:44:00', '2023-09-05 17:17:41', 22, 16, 2),
(19, 'Jef.R.H', NULL, '$2y$10$yZt9uuj310dZnFDhC4CSnOgbU.qFjatpbJ2Bbi9Ih8rA.D8wlIQ/e', NULL, 'angel@gmail.com', '2023-05-29 18:46:23', '2023-09-05 16:11:07', 24, 16, NULL),
(20, 'jesus', NULL, '$2y$10$nrszl039nP4l5oixf/74l.VZhiDwLn3hQiqQSiMNf3RD5J4rWvIiq', NULL, 'adolfoangelchanmarin8@gmail.com', '2023-05-29 18:47:37', '2023-09-06 23:13:51', 21, 15, 1),
(21, 'david', NULL, '$2y$10$nvLz9j4KNNcpZl2k27cnDu1PTcF4ZNS.a3377Vx43deIBOstaVSDi', NULL, 'david@mail.com', '2023-05-30 13:58:30', '2023-09-06 23:24:10', 21, 15, 2),
(24, 'pedro', NULL, '$2y$10$rpNQhjXWU71x1LN7es.Rcu5vfMcV2AOH26u2pIsD5Jt6PCSYOmQn6', NULL, 'pedro@mail.com', '2023-08-11 17:56:54', '2023-09-05 17:19:26', 25, 15, 3),
(25, 'jefeD3', NULL, '$2y$10$GTh80QwoasBmBGYLSebw2ufvZTUTRT01InSEhcwyr7hkhC712r1Za', NULL, 'dario@mail.com', '2023-09-05 17:08:21', '2023-09-05 17:08:21', 22, 16, 1),
(26, 'jefeD2', NULL, '$2y$10$ns.xeLWkcE89/frq.dP3XusQyIWNjxhCAp8HfbOnd2N8NnwKslJLm', NULL, 'gonzalo@mail.com', '2023-09-05 17:16:55', '2023-09-05 17:16:55', 22, 16, 3),
(27, 'david', NULL, '$2y$10$4J8LOhbHD0grUQ6B8qIhauqPVWwmOzkpGX.MUKI5QFPgGFSrGcmiy', NULL, 'armando@mail.com', '2023-09-14 00:54:45', '2023-09-14 00:54:45', 22, 16, 1),
(28, 'david', NULL, '$2y$10$ceZHSD3sZ5e.PJAIZO4j9eu8m.vfQ8PKHFEKcKWd7eu3j3ITl14nu', NULL, 'armando@mail.com', '2023-09-14 00:55:09', '2023-09-14 00:55:09', 22, 16, 1),
(29, 'armando', NULL, '$2y$10$ZFjUTLxDg3Dzese8Pdmd/eO8D7W9FDlmNmucLCJxiv/kp7ZeWvd62', NULL, 'armando@mail.com', '2023-09-14 00:55:20', '2023-09-14 00:55:20', 22, 16, 1),
(30, 'armando', NULL, '$2y$10$ezfxOFUL7qX7PVi5RqAPt.Qx.zMn9O2fttetCrlZWC09NzQenTd6i', NULL, 'armando@mail.com', '2023-09-14 01:01:19', '2023-09-14 01:01:19', 22, 16, 1),
(32, 'guadalupe', NULL, '$2y$10$DQEjp/oWeOJUq0LRX3ScKegJqLtotAfMAj5ip8X3FbkEUfU6IFccW', NULL, 'guadalupe@mail.com', '2023-09-14 13:19:24', '2023-09-14 13:19:24', 22, 16, 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD CONSTRAINT `perfil_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD CONSTRAINT `solicitud_ibfk_1` FOREIGN KEY (`Estado_ID`) REFERENCES `estado` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `solicitud_ibfk_2` FOREIGN KEY (`Tipo_solicitud_ID`) REFERENCES `tipo_solicitud` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `solicitud_ibfk_3` FOREIGN KEY (`User_ID`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `solicitud_ibfk_4` FOREIGN KEY (`motivo_id`) REFERENCES `motivo` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`Rol_ID`) REFERENCES `rol` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`Tipo_usuario_ID`) REFERENCES `tipo_usuario` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`area_usuario_id`) REFERENCES `area_usuario` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
