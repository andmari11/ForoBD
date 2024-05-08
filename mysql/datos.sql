-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 08-05-2024 a las 12:44:27
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
-- Base de datos: `abd`
--

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `email`, `password`, `rol`, `imagen`, `salt`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$xoDmWOinxwlyAYxlnXo5JeM1n1mQoKK6z4UaAKtT7CziCrJaoQKX2', 'a', NULL, 580752289),
(2, 'usuario1', 'usuario1@ucm.es', '$2y$10$5y9eFMhVow9hiodyqvn3Ye4mOHeau4AXPN/d3xLMTtazrM/H1PVTW', 'm', 'img/usuarios/images.jpeg', 1184907616),
(3, 'usuario2', 'usuario2@ucm.es', '$2y$10$wgeKrGaME5saF6AtoYghvuO8liMr6ZiM/6Aw/dPxRzVVdQmgPkYsm', 'u', 'img/usuarios/persona.jpeg', 447971337),
(4, 'usuario3', 'usuario3@ucm.es', '$2y$10$WVPGM18GFRAj7EeGpNMSRODBy7T18.4nVgyCYsGsxWcac3vivqLbu', 'u', NULL, 202657812);

--
-- Volcado de datos para la tabla `foro`
--

INSERT INTO `foro` (`id`, `titulo`, `descripcion`, `fecha`, `favoritos`, `destacado`, `imagen`) VALUES
(1, 'Anécdotas de la ITV', 'Descubre relatos curiosos y experiencias detrás de las ITV. Desde momentos divertidos hasta lecciones sobre seguridad vial.', '2024-02-15', 3, 1, 'img/foros/ITV_logo.svg.png'),
(3, '¿Es Toyota el coche más fiable?', 'Explora la reputación de Toyota como líder en fiabilidad automotriz. Analiza datos, testimonios y comparativas para descubrir si Toyota es realmente el coche más fiable.', '2024-05-08', 1, 1, 'img/foros/toyota.png'),
(4, 'Duda sobre las etiquetas medioambientales', 'Hola buenas tardes, soy de Toledo y vengo este fin de semana a visitar a mi primo de Madrid. Mi coche es un hyundai i10 1.2 del 2011. ¿A qué zonas puedo acceder?', '2024-05-08', 1, 0, 'img/foros/22152-9xjicrnr-distintivo-ambiental-dgt-2.png');

--
-- Volcado de datos para la tabla `mensaje`
--

INSERT INTO `mensaje` (`id`, `foro_id`, `usuario_id`, `text`, `fecha`, `hora`, `likes`, `imagen`) VALUES
(6, 3, 1, 'Siempre Toyota!!! Nunca me decepcionan ', '2024-05-08', '12:22:51', 2, 'img/mensajes/applause.gif'),
(7, 1, 1, 'Son unos ladrones!!', '2024-05-08', '12:26:21', 3, 'img/mensajes/8X6a.gif'),
(8, 3, 2, 'Nunca me cansaré de decir lo buenos que son!!', '2024-05-08', '12:28:05', 1, ''),
(9, 1, 2, 'La tengo que pasar en un par de semanas... ', '2024-05-08', '12:28:41', 1, ''),
(10, 4, 2, 'Es de gasolina o diesel?', '2024-05-08', '12:33:09', 1, ''),
(11, 1, 4, 'Hubo una vez que me tiraron la itv por tener una rajita minúscula en un retrovisor... a veces es tener mala suerte con quién te hace la revisión', '2024-05-08', '12:34:56', 0, ''),
(12, 4, 4, 'Es gasolina', '2024-05-08', '12:35:24', 0, ''),
(13, 4, 2, 'En teoría sí,te adjunto la siguiente información:\"Las etiquetas \"C\" por lo tanto corresponden a los coches de gasolina puestos en la calle desde enero de 2006 y diésel desde 2014\"', '2024-05-08', '12:37:21', 1, ''),
(14, 4, 4, 'Gracias!!', '2024-05-08', '12:37:53', 0, '');


--
-- Volcado de datos para la tabla `favoritos_foro`
--

INSERT INTO `favoritos_foro` (`id`, `usuario_id`, `foro_id`) VALUES
(2, 1, 3),
(3, 2, 1),
(4, 4, 4);


--
-- Volcado de datos para la tabla `likes_mensajes`
--

INSERT INTO `likes_mensajes` (`id`, `usuario_id`, `mensaje_id`) VALUES
(1, 1, 6),
(2, 1, 7),
(4, 2, 6),
(6, 2, 7),
(3, 2, 8),
(5, 2, 9),
(7, 4, 7),
(8, 4, 10),
(9, 4, 13);



COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
