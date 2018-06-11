-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 23-05-2018 a las 09:22:05
-- Versión del servidor: 5.7.19
-- Versión de PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyectos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expiracion` datetime NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `token`, `expiracion`, `nombre`, `activo`) VALUES
(5, 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', '', '2018-04-30 03:10:06', 'Administrador', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anotaciones`
--

DROP TABLE IF EXISTS `anotaciones`;
CREATE TABLE IF NOT EXISTS `anotaciones` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `anotacion` varchar(255) NOT NULL,
  `fecha` varchar(255) NOT NULL,
  `ficha_id` int(65) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `anotaciones`
--

INSERT INTO `anotaciones` (`id`, `anotacion`, `fecha`, `ficha_id`) VALUES
(9, 'Proyecto mejorable', '06/06/17', 43),
(10, 'Anotación al proyecto', '09/06/17', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
CREATE TABLE IF NOT EXISTS `comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fichaproyecto_id` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comentario` tinytext CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `fecha_comentario` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `componentes`
--

DROP TABLE IF EXISTS `componentes`;
CREATE TABLE IF NOT EXISTS `componentes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fichaproyecto_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C474BC88383E1E4A` (`fichaproyecto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `componentes`
--

INSERT INTO `componentes` (`id`, `fichaproyecto_id`, `nombre`, `email`, `imagen`) VALUES
(30, 43, 'Daniel Valera González', 'danvaleragonzalez@hotmail.com', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Diciembre/ASIR/proyecto_43/ponente.jpg'),
(32, 28, 'Rafael Miguel Cruz Álvarez', 'rafamcruza10@gmail.com', ''),
(33, 28, 'Javier Frí­as Serrano', 'javifs94@gmail.com', ''),
(53, 128, 'David Peralvo', 'davidperalvo@gmail.com', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/DAW/proyecto_128/tallerempresarial4.jpg'),
(54, 130, 'Roberto Carlos Flores Gómez', 'r.carlosfloresgomez@gmail.com', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/DAW/proyecto_130/mifoto.jpg'),
(56, 134, 'Miguel Ángel Zamora Blanco', 'mazetuski22@gmail.com', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/DAW/proyecto_134/yo.jpg'),
(57, 131, 'Juan Antonio Cubero López', 'cuberolopez96@gmail.com', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/DAW/proyecto_131/cubero.jpg'),
(58, 129, 'Adrian Antonio Talavera Ruano', 'adriantalavera.93@gmail.com', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/ASIR/proyecto_129/adrian.PNG'),
(59, 136, 'David Santacruz Castilo', 'davidsantacruzcastillo@gmail.com', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/ASIR/proyecto_136/Foto.jpg'),
(60, 133, 'Emilio José Velasco Varo', 'emilio.velasco14@gmail.com', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/ASIR/proyecto_133/Homer-Simpson-e1496257632621.jpg'),
(61, 135, 'Manuel Mariscal', 'mmr4637@gmail.com', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/ASIR/proyecto_135/Selección_009.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convocatorias`
--

DROP TABLE IF EXISTS `convocatorias`;
CREATE TABLE IF NOT EXISTS `convocatorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `convocatoria` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `estado` (`estado`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `convocatorias`
--

INSERT INTO `convocatorias` (`id`, `convocatoria`, `estado`) VALUES
(11, '2016/2017-Diciembre', 'Cerrada'),
(39, '2016/2017-Junio', 'Cerrada'),
(40, '2017/2018-Diciembre', 'Abierta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

DROP TABLE IF EXISTS `estados`;
CREATE TABLE IF NOT EXISTS `estados` (
  `estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`estado`) VALUES
('Abierta'),
('Actual'),
('Cerrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichaproyecto`
--

DROP TABLE IF EXISTS `fichaproyecto`;
CREATE TABLE IF NOT EXISTS `fichaproyecto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proyecto_id` int(11) DEFAULT NULL,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enlaceinterno` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enlaceexterno` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enlacerepositorio` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codigo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fechaPresentacion` date DEFAULT NULL,
  `horaPresentacion` time DEFAULT NULL,
  `logo` longtext COLLATE utf8_unicode_ci,
  `calificacion` int(10) DEFAULT NULL,
  `comentarios` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `etiquetas` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `activarEdicion` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5E77E912F625D1BA` (`proyecto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `fichaproyecto`
--

INSERT INTO `fichaproyecto` (`id`, `proyecto_id`, `titulo`, `descripcion`, `enlaceinterno`, `enlaceexterno`, `enlacerepositorio`, `codigo`, `fechaPresentacion`, `horaPresentacion`, `logo`, `calificacion`, `comentarios`, `etiquetas`, `activarEdicion`) VALUES
(27, 43, 'ANSIBLE', 'Ansible es una herramienta que nos permita automatizar el despliegue y configuración de sistemas, evitando las tareas repetitivas que de no utilizar software de este tipo los administradores deberán realizar repetida y manualmente. ', 'http://localhost/repaso/php/gestion_proyectos/index1.php', 'http://localhost/repaso/php/gestion_proyectos/index2.php', 'http://localhost/repaso/php/gestion_proyectos/index3.php', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Diciembre/ASIR/proyecto_43/PROYECTO_FIN_DE_CICLO.zip', '2016-12-19', '10:30:00', 'https://ejosh.co/de/wp-content/uploads/2015/04/ansible_logo_black_square.png', 5, '0', 'ansible automatizar asir', 1),
(28, 48, 'Proyecto Docker', 'Nuestro proyecto se basa en la creación de contenedores dockers para implementar diferentes proyectos que tienen el instituto creados en varias máquinas virtuales y así disminuir los recursos.\r\n', '#', '#', '#', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Diciembre/ASIR/proyecto_48/ProyectoDocker-CruzAlvarezRafaelMiguel-FriasSerranoJavier.zip', '2016-12-19', NULL, 'http://dev.solace.com/wp-content/uploads/2017/03/docker-logo.png', NULL, '0', 'docker virtualizacion contenedores asir', 1),
(48, 128, 'Gestión de proyectos', 'Gestión de proyectos IES Gran Capitán', '#', '#', '#', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/DAW/proyecto_128/proyectogestion.zip', '2017-06-19', '10:00:00', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/DAW/proyecto_128/logoproyecto.jpg', 5, '1', 'proyectos gestion herramienta aplicacion daw', 0),
(49, 130, 'Actividades al Aire Libre', 'Aplicación de quedadas para realizar actividades al aire libre.', '#', '#', '#', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/DAW/proyecto_130/actividadesairelibreFloresGomezRobertoCarlos.rar', '2017-06-19', '10:30:00', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/DAW/proyecto_130/logoActividades.jpg', 0, '0', 'exterior aplicacion actividades asir', 0),
(51, 134, 'Convivencia', 'Sistema de gestión de partes, sanciones y aula convivencia', '#', '#', '#', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/DAW/proyecto_134/Convivencia.zip', '0000-00-00', '00:00:00', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/DAW/proyecto_134/2.png', 0, '0', 'convivencia gestion herramientas asir', 0),
(52, 131, 'Reservas Restaurante IES Gran Capitán', 'Aplicación web para llevar la gestión de las reservas del Restaurante-Escuela del IES Gran Capitán, que consta con dos partes: Administración y Cliente.\r\n\r\nSe encarga de llevar un control de las reservas en el restaurante, los servicios para reservar, los', '#', '#', '#', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/DAW/proyecto_131/reservasGC.JuanAntonioCuberoEstelaMunoz.zip', '0000-00-00', '00:00:00', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/DAW/proyecto_131/image948-e1447362808491.png', 0, '0', 'restaurante gestion aplicacion daw', 0),
(53, 129, 'W2016Server', 'Implantación de Servidor Windows 2016 Server core administrado desde un equipo Windows 10 PRO', '#', '#', '#', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/ASIR/proyecto_129/W2016Sever.rar', '0000-00-00', '00:00:00', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/ASIR/proyecto_129/logo.jpg', 0, '0', 'server asir', 0),
(54, 136, 'Calendario Colaborativo', 'Creación de un calendario automáticamente en Google Calendar utilizando la API ofrecida de Google Calendar', 'http://calendario.iesgrancapitan.org', '#', '#', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/ASIR/proyecto_136/Calendario Colaborativo David Santacruz.zip', '0000-00-00', '00:00:00', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/ASIR/proyecto_136/google-calendar-api.png', 0, '0', 'calendario daw', 0),
(55, 133, 'Automatización Smart TV', 'Automatización se smart tv de la entrada, haciendo que las noticias se publiquen en TWitter y en la Web del IES Gran Capitán.', '#', 'http://tv.iesgrancapitan.org', '#', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/ASIR/proyecto_133/Proyecto Integrado-Emilio J. Velasco.rar', '0000-00-00', '00:00:00', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/ASIR/proyecto_133/Homer-Simpson-e1496257632621.jpg', 0, '0', 'smart aplicacion asir daw', 0),
(56, 135, 'Red Social Corporativa', 'Servicios, seguridad y alta disponibilidad para un entorno web.', '#', '#', '#', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/ASIR/proyecto_135/proyecto_mariscal_moreno.zip', '0000-00-00', '00:00:00', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Junio/ASIR/proyecto_135/Selección_010.png', 0, '0', 'red asir aplicacion', 0),
(57, 137, 'Administración del aula 219', 'Proyecto acerca de la administración remota del aula 219 con Orchestrator y Active Directory.', '#', '#', '#', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Diciembre/ASIR/proyecto_137/Proyecto_ArandaGutierrezCristianEmanuel.zip', '2016-05-17', '09:00:00', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Diciembre/ASIR/proyecto_137/image_thumb6.png', 0, '0', 'gestion administracion asir', 0),
(60, 139, 'Shikoba - Sawabona', 'Ampliación y mejora de la app shikoba', '192.168.12.241/app.php/login', 'http://cpd.iesgrancapitan.org:9117/app.php/login', '#', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Diciembre/DAW/proyecto_139/shikoba.rar', '2016-05-17', '10:00:00', 'http://cpd.iesgrancapitan.org:9683/pryintegrados/repositorio/2016_2017/Diciembre/DAW/proyecto_139/logo3.png', 0, '0', 'shikoba daw aplicacion gestion', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

DROP TABLE IF EXISTS `proyectos`;
CREATE TABLE IF NOT EXISTS `proyectos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `convocatoria_id` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `codigo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expiracion` date NOT NULL,
  `registrado` tinyint(1) NOT NULL,
  `ciclo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A9DC16214EE93BE6` (`convocatoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id`, `convocatoria_id`, `email`, `codigo`, `expiracion`, `registrado`, `ciclo`) VALUES
(43, 11, 'danvaleragonzalez@hotmail.com', 'b076857b1a854e5854c4a71', '2016-12-17', 1, 'ASIR'),
(48, 11, 'rafamcruza10@gmail.com', '35f5f511cd75fa023bde58e', '2016-12-20', 1, 'ASIR'),
(128, 39, 'davidperalvo@gmail.com', 'b5b61000ecbefcc0dba7d7b7e0335eb2', '2017-06-21', 1, 'DAW'),
(129, 39, 'adriantr22@gmail.com', '860bd12761d5333d8ddc50e3bcab4d92', '2017-06-21', 1, 'ASIR'),
(130, 39, 'r.carlosfloresgomez@gmail.com', 'f8d65b188e095275367fbb3784cd458f', '2017-06-21', 1, 'DAW'),
(131, 39, 'cuberolopez96@gmail.com', '46a939f97a441110184021c19a2c324a', '2017-06-21', 1, 'DAW'),
(133, 39, 'emilio.velasco14@gmail.com', '7fd6642f6b59b2e13c7d313c3a78c5ce', '2017-06-21', 1, 'ASIR'),
(134, 39, 'mazetuski22@gmail.com', '9b2e0c57c5d1a61cfc1140d07c13b1ed', '2017-06-21', 1, 'DAW'),
(135, 39, 'sergiomorenourbano@gmail.com', '10a7a05cda6a091e9fa13884ba01aced', '2017-06-21', 1, 'ASIR'),
(136, 39, 'davidsantacruzcastillo@gmail.com', '98f0ce1abd22752f9b0df5299d7807ed', '2017-06-22', 1, 'ASIR'),
(137, 40, 'cristianemanuelaranda@gmail.com', '69889c93eda4f027d088d7f5b7552088', '2017-12-22', 1, 'ASIR'),
(139, 40, 'josemagp94@gmail.com', 'd313486783933c52f54e822228582dea', '2017-12-22', 1, 'DAW'),
(140, 40, 'davidcambroneromartinez@gmail.com', '060abf6b2058c31621150f645eccef64', '2017-12-22', 1, 'ASIR'),
(141, 39, 'fjagui@gmail.com', '0dbde34eeeee8a5d4e0c42d693949502', '2018-04-17', 1, 'DAW');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoraciones`
--

DROP TABLE IF EXISTS `valoraciones`;
CREATE TABLE IF NOT EXISTS `valoraciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fichaproyecto_id` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `valoracion` int(10) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `convocatorias`
--
ALTER TABLE `convocatorias`
  ADD CONSTRAINT `fkEstados` FOREIGN KEY (`estado`) REFERENCES `estados` (`estado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
