-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 01-08-2025 a las 12:03:14
-- Versión del servidor: 5.7.38
-- Versión de PHP: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `permisos`
--

DELIMITER $$
--
-- Procedimientos
--
$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area_usuario`
--

CREATE TABLE `area_usuario` (
  `ID` smallint(6) NOT NULL,
  `area_usuario_nombre` varchar(45) DEFAULT NULL,
  `area_usuario_valor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

CREATE TABLE `estado` (
  `ID` smallint(6) NOT NULL,
  `Estado_nombre` varchar(45) DEFAULT NULL,
  `Estado_valor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

CREATE TABLE `motivo` (
  `ID` smallint(6) NOT NULL,
  `Motivo_nombre` varchar(45) DEFAULT NULL,
  `Motivo_valor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `motivo`
--

INSERT INTO `motivo` (`ID`, `Motivo_nombre`, `Motivo_valor`) VALUES
(11, 'Viaje Academico', 1),
(12, 'Enfermedad', 2),
(13, 'Cita Medica', 3),
(14, 'Asuntos Personales', 4),
(15, 'Formacion o Capacitacion', 5),
(16, 'Actividades Academicas', 6),
(17, 'gripa', 4),
(18, 'Viaje Medico', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id` smallint(6) NOT NULL,
  `nombre` text NOT NULL,
  `apellido` text NOT NULL,
  `sexo` varchar(50) NOT NULL,
  `area` text NOT NULL,
  `puesto` text NOT NULL,
  `create_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `User_ID` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(28, 'Guadalupe', 'Balam', 'Masculino', 'Jefe Directo', 'Administrativo', '2023-09-14 13:19:24', '2023-09-14 13:19:24', 32),
(32, 'Oscar Daniel', 'Vazquez Alcocer', 'Masculino', 'Ingenieria En Sistemas Computacionales', 'Administrativo', '2023-11-15 16:26:19', '2023-11-15 16:26:19', 36),
(33, 'DIONISIO', 'CANO NOH', 'Masculino', 'Jefe Directo', 'Administrativo', '2023-12-07 14:25:59', '2023-12-07 14:25:59', 37),
(34, 'Darryl ', 'Cervera', 'Masculino', 'Jefe Directo', 'Administrativo', '2023-12-07 14:52:56', '2023-12-07 14:52:56', 38),
(35, 'yamili', 'garrido', 'Femenino', 'Jefe Directo', 'Administrativo', '2023-12-07 15:05:41', '2023-12-07 15:05:41', 39),
(36, 'Jesus', 'Gonzalez', 'Masculino', 'Ingenieria En Sistemas Computacionales', 'Docente', '2024-05-30 11:12:08', '2024-05-30 11:12:08', 40),
(37, 'Pedro Pedro', 'Gonzales Dominguez', 'Masculino', 'Ingenieria En Sistemas Computacionales', 'Docente', '2024-05-30 14:32:43', '2024-05-30 14:32:43', 41),
(38, 'Felipe Santiago', 'Pool Tamay', 'Masculino', 'Ingenieria En Sistemas Computacionales', 'Docente', '2025-07-31 11:34:58', '2025-07-31 11:34:58', 42),
(39, 'Felipe Santiago', 'Pool Tamay', 'Masculino', 'Ingenieria En Sistemas Computacionales', 'Administrativo', '2025-07-31 19:15:23', '2025-07-31 19:15:23', 43);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reposicion`
--

CREATE TABLE `reposicion` (
  `ID` smallint(6) NOT NULL,
  `Reposicion_nombre` varchar(45) DEFAULT NULL,
  `Reposicion_valor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

CREATE TABLE `rol` (
  `ID` smallint(6) NOT NULL,
  `Rol_nombre` varchar(45) DEFAULT NULL,
  `Rol_valor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`ID`, `Rol_nombre`, `Rol_valor`) VALUES
(21, 'Personal', 8),
(22, 'Jefe Directo', 9),
(23, 'Administrador', 10),
(24, 'Recursos Humanos', 11),
(25, 'Inactivo', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

CREATE TABLE `solicitud` (
  `ID` smallint(6) NOT NULL,
  `Tipo_solicitud_ID` smallint(6) DEFAULT NULL,
  `Request_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `de_fecha` datetime DEFAULT NULL,
  `a_fecha` datetime DEFAULT NULL,
  `reposicion` text,
  `fecha_r1` datetime DEFAULT NULL,
  `fecha_r2` datetime DEFAULT NULL,
  `sueldo` text,
  `hora_establecida` varchar(50) DEFAULT NULL,
  `Hora_modificada` varchar(50) DEFAULT NULL,
  `motivo` text,
  `otro` text,
  `adjunto` longblob,
  `mensaje` text,
  `User_ID` smallint(6) DEFAULT NULL,
  `Estado_ID` smallint(6) DEFAULT NULL,
  `modified_by` varchar(250) DEFAULT NULL,
  `notificacion` int(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `solicitud`
--

INSERT INTO `solicitud` (`ID`, `Tipo_solicitud_ID`, `Request_at`, `de_fecha`, `a_fecha`, `reposicion`, `fecha_r1`, `fecha_r2`, `sueldo`, `hora_establecida`, `Hora_modificada`, `motivo`, `otro`, `adjunto`, `mensaje`, `User_ID`, `Estado_ID`, `modified_by`, `notificacion`) VALUES
(4, 41, '2023-05-30 14:33:16', '2023-05-07 14:33:00', '2023-05-08 14:33:00', 'Sin reposicion', NULL, NULL, ' Sin Gose de sueldo', NULL, NULL, 'Enfermedad', NULL, NULL, NULL, 21, 32, NULL, 0),
(8, 42, '2023-07-04 21:34:49', '2023-07-02 21:34:00', '2023-07-04 21:34:00', 'Con reposicion', '2023-07-06 21:34:00', '2023-07-07 21:34:00', 'Con Gose de sueldo', NULL, NULL, 'Enfermedad', NULL, 0x2e2e2f41646a756e746f735f746d702f6d6172696f2e6a7067, NULL, 20, 32, NULL, 1),
(9, 41, '2023-07-12 13:48:16', '2023-07-12 04:49:00', '2023-07-13 13:46:00', 'Sin reposicion', NULL, NULL, ' Sin Gose de sueldo', NULL, NULL, 'Viaje Academico', '', NULL, NULL, 20, 33, NULL, 1),
(11, 41, '2023-10-13 18:02:28', '2023-10-08 18:02:00', '2023-10-09 18:02:00', 'Sin reposicion', NULL, NULL, 'Con Gose de sueldo', NULL, NULL, 'Asuntos Personales', NULL, NULL, NULL, 20, 33, NULL, 1),
(13, 43, '2023-10-13 18:23:09', NULL, NULL, NULL, NULL, NULL, NULL, '18:22 - 19:22', '22:22 - 23:27', 'Formacion o Capacitacion', '', NULL, 'me la pelas', 20, 33, 'Jefe Directo - Subdireccion Academica', 1),
(25, 41, '2023-11-15 16:27:54', '2023-11-18 18:22:00', '2023-11-15 18:22:00', 'Sin reposicion', NULL, NULL, 'Con Gose de sueldo', NULL, NULL, 'otro', '0', NULL, NULL, 36, 33, NULL, 1),
(26, 41, '2023-12-06 15:28:51', '2023-12-11 09:00:00', '2023-12-11 17:00:00', 'Sin reposicion', NULL, NULL, 'Con gose de sueldo', NULL, NULL, 'otro', 'Dia Economico', NULL, 'Porque cumple con los requisitos establecidos', 36, 32, NULL, 1),
(27, 41, '2023-12-07 14:35:40', '2023-12-08 14:25:00', '2023-12-08 14:26:00', 'Sin reposicion', NULL, NULL, '', NULL, NULL, 'otro', 'Dia Economico no.3', NULL, 'fechas ocupadas', 37, 33, NULL, 1),
(28, 41, '2023-12-07 14:45:01', '2023-12-08 14:35:00', '2023-12-08 14:35:00', 'Con reposicion', '2023-12-09 14:37:00', '2023-12-09 14:37:00', 'Con gose de sueldo', NULL, NULL, 'Asuntos Personales', NULL, NULL, 'jjjs', 37, 32, NULL, 0),
(29, 41, '2023-12-07 14:55:49', '2023-12-08 14:48:00', '2023-12-08 14:48:00', 'Con reposicion', '2023-12-09 14:48:00', '2023-12-09 14:48:00', NULL, NULL, NULL, 'Asuntos Personales', NULL, NULL, NULL, 37, 33, NULL, 1),
(30, 41, '2024-01-08 13:47:50', '2024-01-05 13:42:00', '2024-01-06 13:42:00', 'Sin reposicion', NULL, NULL, NULL, NULL, NULL, 'Viaje Academico', NULL, NULL, NULL, 36, 33, NULL, 1),
(31, 41, '2024-01-08 16:00:08', '2024-01-08 15:54:00', '2024-01-09 15:54:00', 'Sin reposicion', NULL, NULL, 'Con gose de sueldo', NULL, NULL, 'Cita Medica', NULL, NULL, 'efwef', 20, 32, NULL, 1),
(32, 41, '2024-01-08 17:59:59', '2024-01-09 08:57:00', '2024-01-09 17:54:00', 'Sin reposicion', NULL, NULL, NULL, NULL, NULL, 'Cita Medica', NULL, NULL, NULL, 18, 33, NULL, 1),
(33, 41, '2024-01-09 13:04:44', '2024-01-09 14:01:00', '2024-01-09 12:59:00', 'Sin reposicion', NULL, NULL, 'Sin gose de sueldo', NULL, NULL, 'Asuntos Personales', NULL, NULL, 'gdfd', 20, 32, NULL, 1),
(34, 41, '2024-05-28 15:03:05', '2024-05-30 09:00:00', '2024-05-30 17:00:00', 'Sin reposicion', NULL, NULL, NULL, NULL, NULL, 'otro', 'dia economico', NULL, NULL, 36, 31, NULL, 0),
(35, 41, '2024-05-30 11:39:31', '2024-05-31 10:27:00', '2024-05-31 10:27:00', 'Sin reposicion', NULL, NULL, 'Con gose de sueldo', NULL, NULL, 'Viaje Medico', NULL, NULL, '', 20, 32, 'Recursos Humanos', 1),
(36, 43, '2024-05-30 11:45:08', NULL, NULL, NULL, NULL, NULL, NULL, '02:33 - 04:33', '00:33 - 02:33', 'Viaje Medico', '', NULL, 'No cumple con los requisitos', 20, 33, 'Personal - Subdireccion Academica', 1),
(37, 43, '2024-05-30 14:34:00', NULL, NULL, NULL, NULL, NULL, 'Con gose de sueldo', '13:21 - 15:21', '16:21 - 18:21', 'Formacion o Capacitacion', '', NULL, '', 41, 32, 'Recursos Humanos', 1),
(38, 41, '2025-07-31 11:36:15', '2025-07-31 10:32:00', '2025-08-04 10:32:00', 'Sin reposicion', NULL, NULL, NULL, NULL, NULL, 'gripa', NULL, NULL, NULL, 42, 34, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_solicitud`
--

CREATE TABLE `tipo_solicitud` (
  `ID` smallint(6) NOT NULL,
  `Tipo_solicitud_nombre` varchar(45) DEFAULT NULL,
  `Tipo_solicitud_valor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

CREATE TABLE `tipo_usuario` (
  `ID` smallint(6) NOT NULL,
  `Tipo_usuario_nombre` varchar(45) DEFAULT NULL,
  `Tipo_usuario_valor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

CREATE TABLE `usuario` (
  `id` smallint(6) NOT NULL,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `create_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Rol_ID` smallint(6) DEFAULT NULL,
  `Tipo_usuario_ID` smallint(6) DEFAULT NULL,
  `area_usuario_id` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `create_at`, `update_at`, `Rol_ID`, `Tipo_usuario_ID`, `area_usuario_id`) VALUES
(17, 'admin', NULL, '$2y$10$TvFhT2kYdY2JzZPxe2p.Cuz2YNHaGtFo3i4pnmg/uI0TKd/1o1DM.', NULL, 'adolfoangel@gmail.com', '2023-05-29 18:39:46', '2023-09-05 15:35:26', 23, 16, NULL),
(18, 'jefe1', NULL, '$2y$10$JrLe8MUqwn4Ba9KszOJ.pu2e2Lg2qSX6BuHT9kJcD4vy/B2T/Myn.', NULL, 'angel@mail.com', '2023-05-29 18:44:00', '2023-09-05 17:17:41', 22, 16, 2),
(19, 'Jef.R.H', NULL, '$2y$10$yZt9uuj310dZnFDhC4CSnOgbU.qFjatpbJ2Bbi9Ih8rA.D8wlIQ/e', NULL, 'angel@gmail.com', '2023-05-29 18:46:23', '2023-09-05 16:11:07', 24, 16, NULL),
(20, 'jesus', NULL, '$2y$10$nrszl039nP4l5oixf/74l.VZhiDwLn3hQiqQSiMNf3RD5J4rWvIiq', NULL, 'yisusgonzalz1203@gmail.com', '2023-05-29 18:47:37', '2024-01-18 14:31:35', 21, 16, 1),
(21, 'david', NULL, '$2y$10$nvLz9j4KNNcpZl2k27cnDu1PTcF4ZNS.a3377Vx43deIBOstaVSDi', NULL, 'david@mail.com', '2023-05-30 13:58:30', '2023-09-06 23:24:10', 21, 15, 2),
(24, 'pedro', NULL, '$2y$10$rpNQhjXWU71x1LN7es.Rcu5vfMcV2AOH26u2pIsD5Jt6PCSYOmQn6', NULL, 'pedro@mail.com', '2023-08-11 17:56:54', '2024-01-18 14:32:02', 22, 15, 3),
(25, 'jefeD3', NULL, '$2y$10$GTh80QwoasBmBGYLSebw2ufvZTUTRT01InSEhcwyr7hkhC712r1Za', NULL, 'dario@mail.com', '2023-09-05 17:08:21', '2023-09-05 17:08:21', 22, 16, 1),
(26, 'jefeD2', NULL, '$2y$10$ns.xeLWkcE89/frq.dP3XusQyIWNjxhCAp8HfbOnd2N8NnwKslJLm', NULL, 'gonzalo@mail.com', '2023-09-05 17:16:55', '2023-09-05 17:16:55', 22, 16, 3),
(27, 'david', NULL, '$2y$10$4J8LOhbHD0grUQ6B8qIhauqPVWwmOzkpGX.MUKI5QFPgGFSrGcmiy', NULL, 'armando@mail.com', '2023-09-14 00:54:45', '2023-09-14 00:54:45', 22, 16, 1),
(28, 'david', NULL, '$2y$10$ceZHSD3sZ5e.PJAIZO4j9eu8m.vfQ8PKHFEKcKWd7eu3j3ITl14nu', NULL, 'armando@mail.com', '2023-09-14 00:55:09', '2023-09-14 00:55:09', 22, 16, 1),
(29, 'armando', NULL, '$2y$10$ZFjUTLxDg3Dzese8Pdmd/eO8D7W9FDlmNmucLCJxiv/kp7ZeWvd62', NULL, 'armando@mail.com', '2023-09-14 00:55:20', '2023-09-14 00:55:20', 22, 16, 1),
(30, 'armando', NULL, '$2y$10$ezfxOFUL7qX7PVi5RqAPt.Qx.zMn9O2fttetCrlZWC09NzQenTd6i', NULL, 'armando@mail.com', '2023-09-14 01:01:19', '2023-09-14 01:01:19', 22, 16, 1),
(32, 'guadalupe', NULL, '$2y$10$DQEjp/oWeOJUq0LRX3ScKegJqLtotAfMAj5ip8X3FbkEUfU6IFccW', NULL, 'guadalupe@mail.com', '2023-09-14 13:19:24', '2023-09-14 13:19:24', 22, 16, 1),
(36, 'oscar.va', NULL, '$2y$10$CxXmoVbuR7gmWkkz02Q9bOzJ968ZVnyIM8UjoosWZkGPqPtEpg7fS', NULL, 'oscar.va@valladolid.tecnm.mx', '2023-11-15 16:26:19', '2023-11-15 16:26:19', 21, 16, 3),
(37, 'dionisio.cn', NULL, '$2y$10$rFKQucUdrlJ3VPiqUmlF8uV7kzSx6DHGIPnsFmQ0SMI6trbIWq1qW', NULL, 'DIONISIO.CN@Valladolid.tecnm.mx', '2023-12-07 14:25:59', '2023-12-07 14:25:59', 21, 16, 3),
(38, 'darryl.cc', NULL, '$2y$10$0Unzydo17tXoG.vTA6WeIuDfCKs/pW/ZPLSWubhIWrPI2eKIkBSZ2', NULL, 'darryl.cc@valladolid.tecnm.mx', '2023-12-07 14:52:56', '2023-12-07 14:52:56', 22, 16, 3),
(39, 'yamili.ccc', NULL, '$2y$10$hX3.Q3viAbKDoVbNoVAGNeW1ta1okcalUFnOwwKUhm93HRxEGGYqq', NULL, 'oscar.va@valladolid.tecnm.m', '2023-12-07 15:05:41', '2023-12-07 15:05:41', 24, 16, 3),
(40, 'l20070036', NULL, '$2y$10$fTSEuwtDE2bfDVUNW1Y/wu3lY7GGjyEKQdV.CawoLAYH7v83mvz1O', NULL, 'l20070036@valladolid.tecnm.mx', '2024-05-30 11:12:08', '2024-05-30 16:03:51', 22, 16, 1),
(41, 'adolfoangelchanmarin8', NULL, '$2y$10$8CQzQGSQ4o5J1cFLj2v8H.1cUempCO0otxLzP721AugPh3NfWCcum', NULL, 'adolfoangelchanmarin8@gmail.com', '2024-05-30 14:32:43', '2024-05-30 14:32:43', 21, 15, 1),
(42, 'l22070087', NULL, '$2y$10$nA1hrmst7gaBE0EJfy69GuOjaKqM.mPuFlZGSSnuVw5aBu5/8QMfm', NULL, 'l22070087@valladolid.tecnm.mx', '2025-07-31 11:34:58', '2025-07-31 12:10:58', 21, 15, 2),
(43, 'santiagopool513', NULL, '$2y$10$lyMjXvat7qOkr/rl.hD9NO5iQtyA4wta9YxEaWuU898LXzRxwjgLy', NULL, 'santiagopool513@gmail.com', '2025-07-31 19:15:23', '2025-07-31 19:15:23', 24, 15, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `area_usuario`
--
ALTER TABLE `area_usuario`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `motivo`
--
ALTER TABLE `motivo`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indices de la tabla `reposicion`
--
ALTER TABLE `reposicion`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Tipo_solicitud_ID` (`Tipo_solicitud_ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Estado_ID` (`Estado_ID`);

--
-- Indices de la tabla `tipo_solicitud`
--
ALTER TABLE `tipo_solicitud`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Tipo_usuario_ID` (`Tipo_usuario_ID`),
  ADD KEY `Rol_ID` (`Rol_ID`),
  ADD KEY `area_usuario_id` (`area_usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `area_usuario`
--
ALTER TABLE `area_usuario`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `motivo`
--
ALTER TABLE `motivo`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `reposicion`
--
ALTER TABLE `reposicion`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `tipo_solicitud`
--
ALTER TABLE `tipo_solicitud`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

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
  ADD CONSTRAINT `solicitud_ibfk_3` FOREIGN KEY (`User_ID`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
