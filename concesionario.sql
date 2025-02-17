-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 13-02-2025 a las 10:49:03
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `concesionario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alquileres`
--

CREATE TABLE `alquileres` (
  `id_alquiler` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED DEFAULT NULL,
  `id_coche` int(10) UNSIGNED DEFAULT NULL,
  `prestado` datetime DEFAULT NULL,
  `devuelto` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alquileres`
--

INSERT INTO `alquileres` (`id_alquiler`, `id_usuario`, `id_coche`, `prestado`, `devuelto`) VALUES
(15, 16, 9, '2025-02-10 12:04:55', NULL);

--
-- Disparadores `alquileres`
--
DELIMITER $$
CREATE TRIGGER `trg_alquiler_devolver` AFTER UPDATE ON `alquileres` FOR EACH ROW BEGIN
  IF NEW.devuelto IS NOT NULL AND OLD.devuelto IS NULL THEN
    INSERT INTO log_alquileres (id_alquiler, id_usuario, id_coche, prestado, devuelto)
    VALUES (OLD.id_alquiler, OLD.id_usuario, OLD.id_coche, OLD.prestado, NEW.devuelto);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coches`
--

CREATE TABLE `coches` (
  `id_coche` int(10) UNSIGNED NOT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `alquilado` tinyint(1) DEFAULT '0',
  `foto` varchar(300) DEFAULT NULL,
  `id_vendedor` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `coches`
--

INSERT INTO `coches` (`id_coche`, `modelo`, `marca`, `color`, `precio`, `alquilado`, `foto`, `id_vendedor`) VALUES
(5, 'Fiesta', 'Ford', 'Blanco', 15000, 0, 'fiesta.webp', 1),
(6, 'Corolla', 'Toyota', 'Azul', 18000, 0, 'corolla.jpg', 0),
(7, 'Formentor', 'Cupra', 'Gris', 32000, 0, 'formentor.jpg', 1),
(9, 'AMG', 'Mercedes', 'Negro', 95000, 1, 'mercedes.png', 1),
(29, 'Jose Luis', 'Abad', 'Negra', 15000, 0, 'perro.jpg', 15),
(31, 'Coche Guay', 'Mercedes', 'Negro', 94000, 0, 'Captura de pantalla 2025-02-03 122943.png', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_alquileres`
--

CREATE TABLE `log_alquileres` (
  `id_log` int(11) NOT NULL,
  `id_alquiler` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_coche` int(11) NOT NULL,
  `prestado` datetime NOT NULL,
  `devuelto` datetime NOT NULL,
  `log_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `log_alquileres`
--

INSERT INTO `log_alquileres` (`id_log`, `id_alquiler`, `id_usuario`, `id_coche`, `prestado`, `devuelto`, `log_date`) VALUES
(5, 16, 16, 5, '2025-02-10 12:31:59', '2025-02-10 12:36:29', '2025-02-10 11:36:29'),
(6, 14, 16, 7, '2025-02-10 11:56:49', '2025-02-10 12:49:36', '2025-02-10 11:49:36'),
(7, 17, 16, 5, '2025-02-11 09:26:45', '2025-02-11 09:27:18', '2025-02-11 08:27:18'),
(8, 18, 16, 5, '2025-02-11 09:33:39', '2025-02-11 09:36:55', '2025-02-11 08:36:55'),
(9, 19, 16, 5, '2025-02-11 09:38:37', '2025-02-11 09:44:50', '2025-02-11 08:44:50'),
(10, 20, 16, 29, '2025-02-11 12:32:40', '2025-02-11 12:38:27', '2025-02-11 11:38:27'),
(11, 21, 16, 29, '2025-02-13 10:41:21', '2025-02-13 10:41:24', '2025-02-13 09:41:24'),
(12, 22, 16, 29, '2025-02-13 10:54:32', '2025-02-13 10:55:10', '2025-02-13 09:55:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `dni` varchar(9) DEFAULT NULL,
  `saldo` float DEFAULT NULL,
  `tipo_usuario` enum('administrador','vendedor','comprador') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `password`, `nombre`, `apellidos`, `dni`, `saldo`, `tipo_usuario`) VALUES
(1, '$2y$10$R3Il2nJ2RqLuLZRYmlyqRuDYQt9/A3UbCeXpG9aMJp7cayMqBB81C', 'root', 'ROOT', 'root', 150000, 'administrador'),
(4, 'zxc987', 'Ana', 'Martínez', '45678901D', 300.2, 'administrador'),
(5, 'lmn654', 'Pedro', 'García', '56789012E', 50, 'administrador'),
(6, 'jkl321', 'Laura', 'Fernández', '67890123F', 400.1, 'administrador'),
(7, 'vbn123', 'Miguel', 'Rodríguez', '78901234G', 120.75, 'administrador'),
(8, 'ghj456', 'Sofía', 'Hernández', '89012345H', 250, 'administrador'),
(9, 'poi789', 'Andrés', 'Ruiz', '90123456I', 180.9, 'administrador'),
(14, '$2y$10$qjo2t0fsTwR0Qq0Xqz2WUu2vK/2/AXMN20sQ89biDbCvyQyugRdt.', 'Diego', 'Li', 'X7553643Y', 1, 'vendedor'),
(15, '$2y$10$9ZkEzi4KGo42cXgRjM9D0.wE5daGc6aRJYTDde6ZN/cNKBg9OsFWy', 'Vendedor', 'Vendedor', 'Vendedor', 27000, 'vendedor'),
(16, '$2y$10$GqCJcopy2g5apZhMJA8W/OAo3uQk4dgkHJsgD5U4PpG.QS/pApHla', 'Comprador', 'Comprador', 'Comprador', 85000, 'comprador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alquileres`
--
ALTER TABLE `alquileres`
  ADD PRIMARY KEY (`id_alquiler`);

--
-- Indices de la tabla `coches`
--
ALTER TABLE `coches`
  ADD PRIMARY KEY (`id_coche`);

--
-- Indices de la tabla `log_alquileres`
--
ALTER TABLE `log_alquileres`
  ADD PRIMARY KEY (`id_log`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alquileres`
--
ALTER TABLE `alquileres`
  MODIFY `id_alquiler` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `coches`
--
ALTER TABLE `coches`
  MODIFY `id_coche` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `log_alquileres`
--
ALTER TABLE `log_alquileres`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
