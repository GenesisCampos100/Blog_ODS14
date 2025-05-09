-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-05-2025 a las 15:47:11
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
-- Base de datos: `login`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `usuario` varchar(250) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `apellido_paterno` varchar(250) NOT NULL,
  `apellido_materno` varchar(250) NOT NULL,
  `correo` varchar(250) NOT NULL,
  `contrasenia` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `usuario`, `nombre`, `apellido_paterno`, `apellido_materno`, `correo`, `contrasenia`) VALUES
(2, 'Gejocelyn', 'Genesis', 'Campos', 'Fajardo', 'gcampos10@ucol.mx', '$2y$10$v0lLDdoz6DwGMh.wp98e6eJVKafWYvDyYcrCq/iKvyoDR2uritgl.'),
(3, 'popmevaleverga', 'Vanessa', 'Sibaja', 'Barragan', 'hahasjsjas@gmail.com', '$2y$10$qHWCIggIh.PY2E2yn1.uNuoJxsGfCPd0OXMzsWxYla0s0Rfz2ocEC'),
(4, 'kk', 'ggg', 'Campos', 'Barragan', 'hhh@gmail.com', '$2y$10$pU3ATsslMwsmIFmh7SGapejQLXMNbXCZZasUK2msXXJSF4gZrboMu'),
(5, 'POB', 'Pob', 'mevale', 'vrg', 'vsibaja@uc', '$2y$10$1QwToDl4bt4gjXgS6Vu1F.PY4QblgApRRRNtpGFZqaJhnFbII0N7m'),
(6, 'POB', 'Pob', 'mevale', 'vrg', 'vsibaja@uc', '$2y$10$T5aEPrHDXa04lIIX4hXyuuDZIo6BMdI7xAheJXDxSfW3xlnapEZmm'),
(7, 'a', 'Genesis', 'Campos', 'Barragan', 'vsibaja@uc', '$2y$10$JxfAVg6c0CT1Dc2Wqu.9EO0Evqno7xWamdBm9/fz1ksWc22n9apMG'),
(8, 'gen', 'genesi', 'c', 'f', 'ii', '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(2, 'Conservación de Ecosistemas'),
(1, 'Contaminación Marina'),
(4, 'Educación Oceánica'),
(3, 'Pesca Sostenible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `resumen` text DEFAULT NULL,
  `contenido` text DEFAULT NULL,
  `referencias` text DEFAULT NULL,
  `autor_nombre` varchar(255) DEFAULT NULL,
  `fecha_publicacion` datetime DEFAULT current_timestamp(),
  `categoria_id` int(11) DEFAULT NULL,
  `imagen_portada` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`id`, `titulo`, `resumen`, `contenido`, `referencias`, `autor_nombre`, `fecha_publicacion`, `categoria_id`, `imagen_portada`) VALUES
(22, 'k', '', '<p>a</p>', 'https://www.ejemplos.co/verbos/', 'Genesis Campos', '2025-04-21 11:40:22', 4, 'imagen_portada/1745258161_poo2.png'),
(23, 'PRUEBA 2', 'ola', '<p>n</p>', 'https://www.ejemplos.co/verbos/', 'Genesis Campos', '2025-04-21 12:41:01', 1, 'imagen_portada/1745391169_poo2.png'),
(24, 'OLA', 'cinco', '<p>A</p>', 'SAKAS', 'Genesis Campos', '2025-04-23 13:42:27', 4, 'imagen_portada/680942a376512_poo2.png'),
(26, 'PRUEBA', 'a', '<p>wwwwwww</p>', 'a', 'Genesis Campos', '2025-04-28 11:41:42', 4, ''),
(39, 'PRUEBA', 'OLA', '<p>O</p>', 'SKSKXK', 'Genesis Campos', '2025-05-03 10:58:37', 4, '1746291512_Aesthetic-Orange-2-1.webp'),
(40, 'Protegiendo los Océanos: Un Compromiso con la ODS 14', 'oa<oaoao', '<p>sskdskmd</p>', 'opsl', 'Erick Figueroa', '2025-05-03 10:59:57', 4, '1746291592_poo1.png'),
(41, 'La Importancia de Proteger Nuestros Océanos', 'ola', '<p>ayuda&nbsp;</p>', 'https://github.com/GenesisCampos100/Blog_ODS14/blob/Genesis/agregar_publicacion.php', 'Genesis Campos', '2025-05-03 11:04:52', 1, 'imagen_portada/1746292883_poo2.png'),
(42, 'ADIOS', 'em', '<p>ci</p>', 'o', 'Genesis Campos', '2025-05-03 12:44:11', 4, 'imagen_portada/1746297897_poo1.png'),
(43, 'La Importancia de Proteger Nuestros Océanos', 'ok', '<p>KJBKHGHB,FHVZBHB ,M&nbsp;</p>', 'https://localhost/Blog_ODS14/agregar_publicacion.php', 'Mario ', '2025-05-05 07:22:35', 2, 'imagen_portada/1746451346_Actividad20_CamposFajardoGenesisJocelyn.png'),
(44, 'o', 'ci', '<p>ola</p><figure class=\"image\"><img src=\"imagenes/1746546572_poo1.png\"></figure><p>ola</p><ol><li>uno</li><li>dos&nbsp;</li><li>tres</li></ol><figure class=\"image\"><img src=\"imagenes/1746546591_poo2.png\"></figure>', 'https://localhost/Blog_ODS14/agregar_publicacion.php', 'Genesis Campos', '2025-05-06 09:50:10', 2, 'imagen_portada/1746546601_Aesthetic-Orange-2-1.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion_elementos`
--

CREATE TABLE `publicacion_elementos` (
  `id` int(11) NOT NULL,
  `publicacion_id` int(11) DEFAULT NULL,
  `tipo` enum('texto','imagen') NOT NULL,
  `contenido` text NOT NULL,
  `orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicacion_elementos`
--

INSERT INTO `publicacion_elementos` (`id`, `publicacion_id`, `tipo`, `contenido`, `orden`) VALUES
(429, 22, 'texto', '<p>a</p>', 0),
(502, 24, 'texto', '<p>A</p>', 0),
(504, 26, 'texto', '<p>wwwwwww</p>', 0),
(536, 39, 'texto', '<p>O</p>', 1),
(537, 40, 'texto', '<p>sskdskmd</p>', 1),
(539, 41, 'texto', '<p>ayuda </p>', 0),
(543, 42, 'texto', '<p>ci</p>', 0),
(544, 42, 'texto', '<ol><li>1</li><li>2</li><li>3</li><li>4</li><li>45</li></ol>', 1),
(566, 44, 'texto', '<p>ola</p>', 0),
(567, 44, 'imagen', 'imagenes/1746546572_poo1.png', 1),
(568, 44, 'texto', '<p>ola</p>', 2),
(569, 44, 'texto', '<ol><li>uno</li><li>dos </li><li>tres</li></ol>', 3),
(570, 44, 'imagen', 'imagenes/1746546591_poo2.png', 4),
(573, 23, 'texto', '<p>SI no</p>', 0),
(574, 23, 'imagen', 'imagenes/1745379752_poo2.png', 1),
(579, 43, 'texto', '<p>KJBKHGHB,FHVZBHB ,M </p>', 0),
(580, 43, 'texto', '<p> </p>', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `correo`, `nombre`, `apellidos`, `contrasenia`, `fecha_registro`) VALUES
(1, 'Gejocelyn', 'gcampos10@ucol.mx', 'Genesis', 'Campos', '$2y$10$QAAPdqFxAPGZxGYdTn6bnuoA7BKeyW3P1/Xpj2nLKTNtgONZC0mFC', '2025-05-03 19:56:44'),
(2, 'Ola', 'gene@gmail.com', 'Genesis', 'campos', '$2y$10$wFVYcuPHZYjAcvM1Cl0Xrelxm4dBv5LPbzv4V5Qh4L8ckgbVyUOE6', '2025-05-04 18:22:33'),
(3, 'POB', 'vsibaja@ucol.mx', 'Vanessa', 'campos', '$2y$10$Au2yBfwz5f.GlJJ1kM0QMueNKUifoNwII45Wmlm/F6N12qbPR1rTW', '2025-05-04 18:26:52'),
(4, 'Genesis', 'g@gmail.com', 'Genesis', 'Campos', '$2y$10$Sg0aleL.UPokunsNoO7vJOH81ZclomCob2tZcPHKo3FzbTSpNsla2', '2025-05-04 18:34:22');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `publicacion_elementos`
--
ALTER TABLE `publicacion_elementos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `publicacion_id` (`publicacion_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD UNIQUE KEY `gmail` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `publicacion_elementos`
--
ALTER TABLE `publicacion_elementos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=581;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `publicacion_elementos`
--
ALTER TABLE `publicacion_elementos`
  ADD CONSTRAINT `publicacion_elementos_ibfk_1` FOREIGN KEY (`publicacion_id`) REFERENCES `publicaciones` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
