-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-04-2024 a las 18:28:49
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
-- Base de datos: `goallink_1`
--

--
-- Volcado de datos para la tabla `foro`
--

INSERT INTO `foro` (`id`, `titulo`, `descripcion`, `fecha`, `favoritos`, `destacado`, `imagen`) VALUES
(1, 'Foro 1', 'Descripción foro 1', '2024-02-15', 2, 1, 'img/foros/WCDEES6F4BIFXAGUDCSWNJLJNY.jpg'),
(2, 'Foro 2', 'Descripción foro 2', '2024-03-15', 20, 1, 'img/foros/WCDEES6F4BIFXAGUDCSWNJLJNY.jpg');


--
-- Volcado de datos para la tabla `usuario`
--


INSERT INTO `usuario` (`id`, `nombre`, `email`, `password`, `rol`, `imagen`, `salt`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$xoDmWOinxwlyAYxlnXo5JeM1n1mQoKK6z4UaAKtT7CziCrJaoQKX2', 'a',  NULL, 580752289),
(2, 'usuario1', 'usuario1@ucm.es', '$2y$10$5y9eFMhVow9hiodyqvn3Ye4mOHeau4AXPN/d3xLMTtazrM/H1PVTW', 'e',  NULL, 1184907616),
(3, 'usuario2', 'usuario2@ucm.es', '$2y$10$wgeKrGaME5saF6AtoYghvuO8liMr6ZiM/6Aw/dPxRzVVdQmgPkYsm', 'u',  NULL, 447971337);



--
-- Volcado de datos para la tabla `mensaje`
--

INSERT INTO `mensaje` (`id`, `foro_id`, `usuario_id`, `text`, `fecha`, `hora`, `likes`) VALUES
(1, 2, 1, 'dsadsasdasdasdasdasdasd', '2024-04-15', '00:00:00', 0),
(2, 2, 1, 'dsadsasdasdasdasdasdasd', '2024-04-15', '00:00:00', 0),
(3, 2, 1, 'aaaaaaaaaaaaaaaaaaa', '2024-04-15', '18:04:05', 0),
(4, 2, 1, 'asasasas', '2024-04-15', '18:25:24', 0),
(5, 2, 1, 'asasasasasa', '2024-04-15', '18:25:27', 0);


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
