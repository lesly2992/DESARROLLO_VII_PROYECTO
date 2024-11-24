-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-11-2024 a las 19:09:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agencia_de_viajes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes`
--

CREATE TABLE `paquetes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `destino` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `detalle` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `duracion` varchar(50) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `fecha_de_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paquetes`
--

INSERT INTO `paquetes` (`id`, `nombre`, `destino`, `descripcion`, `detalle`, `precio`, `duracion`, `imagen`, `estado`, `fecha_de_creacion`) VALUES
(1, 'Escapada de Madrid a Venecia', 'España, Francia, Italia', 'descripcion corta\r\n', 'Embárcate en una aventura única que te llevará a descubrir los encantos del Mediterráneo en un recorrido que abarca tres de los países más cautivadores de Europa: España, Francia e Italia. Desde la vibrante energía de Madrid hasta la serenidad romántica de Venecia, este viaje de 11 días y 9 noches te sumergirá en un mundo de cultura, historia y paisajes impresionantes. Con paradas en ciudades icónicas como Barcelona, Roma, Florencia, y más, disfrutarás de una mezcla perfecta entre exploración urbana y momentos de relajación en la Costa Azul', 2999.00, '11 días y 9 noches', '1732397911_escapada-meditarranea-600x600.png.webp', 'activo', '2024-11-04 06:48:54'),
(2, 'Cartagena Colombia', 'Colombia', 'rtertetertertertert', 'Déjate cautivar por la belleza y el encanto de Cartagena con nuestro paquete turístico por persona en habitación doble. Cartagena, conocida por su impresionante arquitectura colonial, sus murallas históricas y sus hermosas playas, te espera para una experiencia inolvidable. Descubre todo lo que este destino tiene para ofrecer con las siguientes inclusiones:\r\n\r\nIncluye\r\n\r\nTraslados: aeropuerto – hotel – aeropuerto.\r\n3 noches de alojamiento.\r\nDesayunos por cada noche de alojamiento.\r\nCity tour histórico y cultural en chiva turística.\r\nVisita y tour guiado al Castillo de San Felipe.\r\nTour náutico compartido a las Islas del Rosario y playas de Barú.\r\nImpuestos turísticos.\r\nGuía local.', 7373.00, '3 noches ', '1732398015_CARTAGENA.jpg', 'activo', '2024-11-04 07:09:15'),
(3, 'Mega Turquía y Dubái', 'Turquía y Dubái', 'Conoce los encantos de Turquía y Dubái en una experiencia inolvidable de 15 días\r\n\r\n', 'Un paquete mágico que te llevará a recorrer los contrastes de dos mundos fascinantes: la rica historia de Turquía y la modernidad deslumbrante de Dubái. Este viaje te ofrece la oportunidad de descubrir los tesoros culturales, paisajes impresionantes y maravillas arquitectónicas que hacen de estos destinos lugares únicos. Desde los antiguos bazares de Estambul y las formaciones volcánicas de Capadocia hasta el lujo y esplendor de Dubái, vivirás momentos inolvidables rodeado de historia, tradición y modernidad.', 3199.00, '15 días / 13 noches', '1732398120_Mega-Mega-Turquia-y-Dubai-600x600.png', 'activo', '2024-11-04 22:49:51'),
(4, 'Corazón de España – Madrid, Cáceres, Córdoba, Sevilla', 'España', 'Este es un viaje ideal para aquellos que buscan sumergirse en el auténtico corazón de España, explorando sus ciudades más emblemáticas y su rica cultura.', 'detalle', 2599.00, '10 dias', '1732408664_corazon-de-espana.png.webp', 'activo', '2024-11-23 21:36:20'),
(5, 'Descubre Francia y los Países Bajos', 'Francia y los Países Bajos', 'sfsdfseswefssfsfsfsfsf', 'detalle', 3799.00, '12 días y 10 noches.', '1732412199_Descubre-Francia-y-los-Paises-Bajos-600x600.png', 'activo', '2024-11-24 01:36:39'),
(6, 'Escapada Romántica a París', 'Francia', 'Descubre el encanto de la Ciudad de la Luz en un viaje inolvidable.', 'París, conocida como la Ciudad de la Luz, te espera con su arquitectura icónica y atmósfera romántica. Disfruta de un recorrido completo que incluye visitas a la Torre Eiffel, el Museo del Louvre y un paseo en barco por el río Sena. Este paquete está diseñado para parejas que buscan momentos especiales, con alojamiento en hoteles boutique y cenas románticas. Ideal para una escapada que combina historia, cultura y amor en cada rincón.', 2599.00, '5 días y 4 noches', '1732462605_Paris1.jpg', 'activo', '2024-11-24 15:05:57'),
(7, 'Aventura en la Patagonia', 'Chile y Argentina', 'Explora los paisajes más asombrosos de la Patagonia.', 'La Patagonia es un destino único que combina naturaleza virgen y paisajes espectaculares. Este paquete incluye caminatas guiadas por los glaciares Perito Moreno y exploración en el Parque Nacional Torres del Paine. Disfruta de la majestuosidad de los Andes, la flora y fauna autóctona, y vistas panorámicas que te dejarán sin aliento. También incluye navegación por el lago Argentino y alojamiento en cómodos lodges. Perfecto para quienes buscan aventura y tranquilidad en un solo viaje.', 3299.00, '8 días y 7 noches', '1732462727_patagonia.jpg.avif', 'activo', '2024-11-24 15:05:57'),
(8, 'Maravillas de Japón', 'Japón', 'Sumérgete en la cultura y tecnología de Japón.', 'Japón es un país que mezcla tradición y modernidad. En este viaje visitarás Tokio, Kioto y Osaka, explorando templos antiguos, jardines zen y los mercados tradicionales más vibrantes. Disfruta de la belleza del Monte Fuji y del encanto de los cerezos en flor (según temporada). Este paquete incluye transporte en tren bala, alojamiento en hoteles premium y experiencias gastronómicas que te sumergirán en la rica cultura japonesa.', 3899.00, '10 días y 9 noches', '1732462808_japon.avif', 'activo', '2024-11-24 15:05:57'),
(9, 'Safari en Kenia y Tanzania', 'África', 'Vive una experiencia única de safari en África.', 'Descubre los paisajes más impresionantes de África con este safari que te llevará al corazón de Kenia y Tanzania. Recorre el Serengeti y el Masái Mara, donde podrás observar la Gran Migración y una variedad única de fauna salvaje. Este paquete incluye safaris en jeep con guías expertos, alojamiento en lodges de lujo, y visitas a comunidades locales. Una experiencia inolvidable para amantes de la naturaleza y la fotografía.', 4999.00, '12 días y 11 noches', '1732462967_africa.avif', 'activo', '2024-11-24 15:05:57'),
(10, 'Lujo en Dubái y Abu Dhabi', 'Emiratos Árabes Unidos', 'Descubre el lujo y la modernidad de Dubái.', 'Dubái y Abu Dhabi son sinónimos de lujo y modernidad. Este paquete incluye alojamiento en hoteles de 5 estrellas, experiencias únicas como un tour en el desierto, entradas al Burj Khalifa y visitas guiadas a la Gran Mezquita de Abu Dhabi. También disfrutarás de compras en los centros comerciales más exclusivos y de espectáculos culturales que enriquecen la experiencia. Perfecto para quienes buscan lujo y aventura en Oriente Medio.', 4299.00, '7 días y 6 noches', '1732463051_dubai.avif', 'activo', '2024-11-24 15:05:57'),
(11, 'Tesoros de Egipto', 'Egipto', 'Explora las pirámides y el Nilo en un viaje único.', 'Egipto es un destino lleno de historia y misticismo. Este paquete incluye un crucero por el río Nilo, visitas guiadas a las pirámides de Giza, el Templo de Luxor y la Gran Esfinge. Experimenta la vida local en mercados tradicionales y disfruta de la rica gastronomía egipcia. Ideal para amantes de la arqueología y la cultura antigua. El alojamiento en barcos y hoteles de 4 estrellas garantiza comodidad en cada etapa del viaje.', 3299.00, '10 días y 9 noches', '1732463066_ejipto.avif', 'activo', '2024-11-24 15:05:57'),
(12, 'Encantos de Italia', 'Italia', 'Descubre la belleza de Roma, Florencia y Venecia.', 'Italia es un país lleno de cultura, arte y gastronomía. Este paquete incluye visitas a Roma, Florencia y Venecia, con tours guiados por el Coliseo, la Capilla Sixtina y los canales venecianos. Degusta la auténtica cocina italiana mientras exploras las calles históricas y plazas icónicas. Además, disfruta de experiencias como clases de cocina y catas de vino en la región de la Toscana. Una experiencia completa para explorar la esencia de Italia.', 3099.00, '9 días y 8 noches', '1732463125_italia-en-vespa-600x600.png.webp', 'activo', '2024-11-24 15:05:57'),
(13, 'Explorando Perú', 'Perú', 'Descubre los secretos de Machu Picchu y la cultura andina.', 'Perú es un destino que combina historia, naturaleza y cultura. Este paquete incluye tours por Cusco, el Valle Sagrado y Machu Picchu, uno de los destinos más icónicos del mundo. También disfrutarás de experiencias únicas como visitas a mercados locales, talleres de artesanía andina y degustaciones de platos tradicionales. Ideal para quienes buscan una inmersión cultural completa.', 2599.00, '7 días y 6 noches', '1732463385_IMG_1433-2-819x1024.jpg', 'activo', '2024-11-24 15:05:57'),
(14, 'Bellezas de Canadá', 'Canadá', 'Explora las maravillas naturales de Canadá.', 'Incluye visitas a Banff, Jasper y las Cataratas del Niágara. Perfecto para amantes de la naturaleza, con paseos en bote y caminatas guiadas.', 3499.00, '10 días y 9 noches', '1732463709_canada.jpg', 'activo', '2024-11-24 15:26:32'),
(15, 'Aventura en Nueva Zelanda', 'Nueva Zelanda', 'Descubre los paisajes de película en Nueva Zelanda.', 'Incluye visitas a Hobbiton, Queenstown y el Parque Nacional Tongariro. Ideal para explorar paisajes volcánicos y cultura maorí.', 4599.00, '12 días y 11 noches', '1732463669_nuevaza.webp', 'activo', '2024-11-24 15:26:32'),
(16, 'Caribe Mexicano: Cancún y Tulum', 'México', 'Relájate en las playas más hermosas del Caribe.', 'Incluye alojamiento en resorts de lujo, tours por ruinas mayas y experiencias de snorkel en cenotes.', 2299.00, '6 días y 5 noches', '1732463643_mexico.avif', 'activo', '2024-11-24 15:26:32');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
