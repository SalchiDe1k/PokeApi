-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-05-2024 a las 15:53:46
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
-- Base de datos: `pokemon_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moves`
--

CREATE TABLE `moves` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pokemons`
--

CREATE TABLE `pokemons` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pokemons`
--

INSERT INTO `pokemons` (`id`, `name`, `image_url`, `type_id`) VALUES
(5, 'Bulbasaur', 'https://example.com/bulbasaur.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pokemon_moves`
--

CREATE TABLE `pokemon_moves` (
  `pokemon_id` int(11) NOT NULL,
  `move_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pokemon_types`
--

CREATE TABLE `pokemon_types` (
  `pokemon_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trainers`
--

CREATE TABLE `trainers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trainer_pokemons`
--

CREATE TABLE `trainer_pokemons` (
  `trainer_id` int(11) NOT NULL,
  `pokemon_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `types`
--

INSERT INTO `types` (`id`, `name`) VALUES
(1, 'Planta'),
(2, 'Fuego'),
(3, 'Agua'),
(4, 'Eléctrico');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `moves`
--
ALTER TABLE `moves`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pokemons`
--
ALTER TABLE `pokemons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indices de la tabla `pokemon_moves`
--
ALTER TABLE `pokemon_moves`
  ADD KEY `pokemon_id` (`pokemon_id`),
  ADD KEY `move_id` (`move_id`);

--
-- Indices de la tabla `pokemon_types`
--
ALTER TABLE `pokemon_types`
  ADD KEY `pokemon_id` (`pokemon_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indices de la tabla `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trainer_pokemons`
--
ALTER TABLE `trainer_pokemons`
  ADD KEY `trainer_id` (`trainer_id`),
  ADD KEY `pokemon_id` (`pokemon_id`);

--
-- Indices de la tabla `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `moves`
--
ALTER TABLE `moves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pokemons`
--
ALTER TABLE `pokemons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pokemons`
--
ALTER TABLE `pokemons`
  ADD CONSTRAINT `pokemons_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`);

--
-- Filtros para la tabla `pokemon_moves`
--
ALTER TABLE `pokemon_moves`
  ADD CONSTRAINT `pokemon_moves_ibfk_1` FOREIGN KEY (`pokemon_id`) REFERENCES `pokemons` (`id`),
  ADD CONSTRAINT `pokemon_moves_ibfk_2` FOREIGN KEY (`move_id`) REFERENCES `moves` (`id`);

--
-- Filtros para la tabla `pokemon_types`
--
ALTER TABLE `pokemon_types`
  ADD CONSTRAINT `pokemon_types_ibfk_1` FOREIGN KEY (`pokemon_id`) REFERENCES `pokemons` (`id`),
  ADD CONSTRAINT `pokemon_types_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`);

--
-- Filtros para la tabla `trainer_pokemons`
--
ALTER TABLE `trainer_pokemons`
  ADD CONSTRAINT `trainer_pokemons_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`),
  ADD CONSTRAINT `trainer_pokemons_ibfk_2` FOREIGN KEY (`pokemon_id`) REFERENCES `pokemons` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
