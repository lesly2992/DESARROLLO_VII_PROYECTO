-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2024 at 07:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agencia_de_viajes`
--

-- --------------------------------------------------------

--
-- Table structure for table `paquetes`
--

CREATE TABLE `paquetes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `destino` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `duracion` varchar(50) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `fecha_de_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paquetes`
--

INSERT INTO `paquetes` (`id`, `nombre`, `destino`, `descripcion`, `precio`, `duracion`, `imagen`, `estado`, `fecha_de_creacion`) VALUES
(3, 'Aventura en Laponia Finlandesa', 'Finlandia', 'efertert', 7373.00, '6 noches', '1730760591_Captura de pantalla 2024-05-10 150906.png', 'activo', '2024-11-04 22:49:51'),
(4, 'ERWR', 'Finlandia', 'etert5e4t54e5t64e5', 7373.00, '6 noches', '1732343686_Captura de pantalla 2024-11-22 222308.png', 'activo', '2024-11-23 06:34:46'),
(5, 'ERWR', 'Finlandia', 'etert5e4t54e5t64e5', 7373.00, '6 noches', '1732343870_Captura de pantalla 2024-11-22 222308.png', 'activo', '2024-11-23 06:37:50');

-- --------------------------------------------------------

--
-- Table structure for table `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `rol` enum('usuario','admin','superAdmin') NOT NULL,
  `modulo` varchar(50) NOT NULL,
  `ver` tinyint(1) DEFAULT 0,
  `seleccionar` tinyint(1) DEFAULT 0,
  `editar` tinyint(1) DEFAULT 0,
  `eliminar` tinyint(1) DEFAULT 0,
  `guardar` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permisos`
--

INSERT INTO `permisos` (`id`, `rol`, `modulo`, `ver`, `seleccionar`, `editar`, `eliminar`, `guardar`) VALUES
(65, 'superAdmin', 'gestorPackage.php', 0, 1, 1, 1, 1),
(66, 'superAdmin', 'gestorReservation.php', 0, 0, 0, 0, 0),
(67, 'superAdmin', 'Usuarios.php', 0, 0, 0, 0, 0),
(68, 'superAdmin', 'permisos.php', 0, 0, 0, 0, 0),
(69, 'admin', 'gestorPackage.php', 1, 1, 1, 0, 1),
(70, 'admin', 'gestorReservation.php', 0, 0, 0, 0, 0),
(71, 'admin', 'Usuarios.php', 0, 0, 0, 0, 0),
(72, 'admin', 'permisos.php', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `nombre_cliente` varchar(255) NOT NULL,
  `email_cliente` varchar(255) NOT NULL,
  `telefono_cliente` varchar(20) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `paquete_id` int(11) NOT NULL,
  `fecha_reserva` timestamp NOT NULL DEFAULT current_timestamp(),
  `hora_reserva` time NOT NULL,
  `estado` enum('pendiente','confirmada','cancelada','') NOT NULL DEFAULT 'pendiente',
  `comentario` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('usuario','admin','superAdmin') DEFAULT 'usuario',
  `reset_token` varchar(64) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `register_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `email`, `password`, `rol`, `reset_token`, `token_expiry`, `register_date`) VALUES
(1, 'enedina', 'leslyortg29@gmail.com', '$2y$10$1Werorpz5xZUyit956zk.OxtX.ooVTiH1pkiMwn4EudGJjUHnU.QC', 'superAdmin', NULL, NULL, '2024-10-27 21:26:12'),
(2, 'admin', 'admin@example.com', 'password_encriptado', 'admin', NULL, NULL, '2024-11-23 21:08:20'),
(9, 'enedinaSuper', 'enedinaSuper@Admin', '$2y$10$A/CK0GaKAf87j64SzXXkeOTC2Vl20sHfbkv1HT0VHb6QZ/RuiGOaG', 'superAdmin', NULL, NULL, '2024-11-24 06:34:07'),
(10, 'test', 'test@ejemplo.com', '$2y$10$1uQNSBubnkLHsHs8kRIbLevU6SDPraiLVRd.q..Rf7FzJqYCXYoce', 'admin', NULL, NULL, '2024-11-24 16:21:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `paquetes`
--
ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_id` (`usuario_id`),
  ADD KEY `fk_paquete_id` (`paquete_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `paquetes`
--
ALTER TABLE `paquetes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_paquete_id` FOREIGN KEY (`paquete_id`) REFERENCES `paquetes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
