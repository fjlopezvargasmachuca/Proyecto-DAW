-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2023 a las 21:07:30
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `eligecoche`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesorios`
--

CREATE TABLE `accesorios` (
  `id` int(4) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Precio` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `accesorios`
--

INSERT INTO `accesorios` (`id`, `Nombre`, `Precio`) VALUES
(1, 'volante para conductores de 1 mano', '1500.00'),
(2, 'palanca de cambios integrado al volante', '2000.00'),
(3, 'llave magnética', '2500.00'),
(4, 'GPS por voz con internet', '3000.00'),
(5, 'Asientos plegables', '15000.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carroceria`
--

CREATE TABLE `carroceria` (
  `id` int(4) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Precio` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `carroceria`
--

INSERT INTO `carroceria` (`id`, `Nombre`, `Precio`) VALUES
(1, 'Sedán', '5000.00'),
(2, 'SUV', '8000.00'),
(3, 'Coupé', '7000.00'),
(4, 'Hatchback', '4000.00'),
(5, 'Descapotable', '10000.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `DNI` varchar(20) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Direccion` varchar(200) DEFAULT NULL,
  `contrasena` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`DNI`, `Nombre`, `Email`, `Telefono`, `Direccion`, `contrasena`) VALUES
('12345678A', 'Juan Pérez', 'juan@example.com', '123456789', 'Calle Principal 123', '1234'),
('23456789B', 'María Rodríguez', 'maria@example.com', '987654321', 'Avenida Central 456', '1234'),
('34567890C', 'Pedro Gómez', 'pedro@example.com', '456789123', 'Plaza Mayor 789', '1234'),
('45678901D', 'Laura López', 'laura@example.com', '321654987', 'Calle Secundaria 234', '1234'),
('56789012E', 'Carlos Martínez', 'carlos@example.com', '654987321', 'Avenida Norte 567', '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coches`
--

CREATE TABLE `coches` (
  `id` int(11) NOT NULL,
  `Motor_ID` int(4) DEFAULT NULL,
  `Ruedas_ID` int(4) DEFAULT NULL,
  `Carroceria_ID` int(4) DEFAULT NULL,
  `Pintura_ID` int(4) DEFAULT NULL,
  `Traccion_ID` int(4) DEFAULT NULL,
  `Puertas_ID` int(4) DEFAULT NULL,
  `Accesorios_ID` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `coches`
--

INSERT INTO `coches` (`id`, `Motor_ID`, `Ruedas_ID`, `Carroceria_ID`, `Pintura_ID`, `Traccion_ID`, `Puertas_ID`, `Accesorios_ID`) VALUES
(1, 1, 2, 2, 2, 2, 2, 2),
(2, 1, 3, 2, 3, 3, 3, 5),
(3, 2, 1, 1, 3, 1, 2, 1),
(4, 4, 1, 4, 2, 1, 5, 2),
(5, 2, 2, 1, 4, 1, 1, 3),
(6, 3, 3, 1, 1, 2, 4, 1),
(7, 1, 4, 1, 3, 3, 3, 1),
(8, 5, 1, 3, 2, 1, 1, 2),
(9, 1, 4, 2, 5, 5, 2, 3),
(10, 2, 5, 5, 4, 1, 1, 2),
(11, 3, 2, 3, 2, 3, 4, 1),
(12, 1, 1, 1, 1, 1, 1, NULL),
(13, 1, 1, 1, 1, 1, 1, NULL),
(14, 1, 1, 1, 1, 1, 1, NULL),
(15, 1, 1, 1, 1, 1, 1, NULL),
(16, 1, 1, 1, 1, 1, 1, NULL),
(17, 1, 1, 1, 1, 1, 1, NULL),
(18, 1, 1, 1, 1, 1, 1, NULL),
(19, 1, 1, 1, 1, 1, 1, NULL),
(20, 1, 1, 1, 1, 1, 1, NULL),
(21, 1, 1, 1, 1, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encargo`
--

CREATE TABLE `encargo` (
  `idencargo` int(11) NOT NULL,
  `id_factura` int(11) DEFAULT NULL,
  `dni_operario` varchar(9) DEFAULT NULL,
  `estadoEncargoId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `encargo`
--

INSERT INTO `encargo` (`idencargo`, `id_factura`, `dni_operario`, `estadoEncargoId`) VALUES
(1, 1, '11111111A', NULL),
(6, 12345688, '11111111A', NULL),
(7, 12345689, '11111111A', NULL),
(8, 12345690, '11111111A', NULL),
(9, 12345691, '11111111A', NULL),
(10, 12345692, '11111111A', NULL),
(11, 12345693, '11111111A', NULL),
(12, 12345694, '11111111A', NULL),
(13, 12345695, '11111111A', NULL),
(14, 12345696, '11111111A', NULL),
(15, 12345697, '11111111A', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadoencargo`
--

CREATE TABLE `estadoencargo` (
  `id` int(11) NOT NULL,
  `encargoId` int(11) DEFAULT NULL,
  `motor` tinyint(1) DEFAULT 0,
  `ruedas` tinyint(1) DEFAULT 0,
  `carroceria` tinyint(1) DEFAULT 0,
  `pintura` tinyint(1) DEFAULT 0,
  `traccion` tinyint(1) DEFAULT 0,
  `puertas` tinyint(1) DEFAULT 0,
  `accesorios` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factaveria`
--

CREATE TABLE `factaveria` (
  `id` int(11) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `matricula` varchar(20) DEFAULT NULL,
  `detalles` varchar(100) DEFAULT NULL,
  `dni_cliente` varchar(10) DEFAULT NULL,
  `CIF_taller` varchar(10) DEFAULT NULL,
  `dni_mover` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `factaveria`
--

INSERT INTO `factaveria` (`id`, `direccion`, `modelo`, `marca`, `matricula`, `detalles`, `dni_cliente`, `CIF_taller`, `dni_mover`) VALUES
(11, 'Calle Principal 123', 'Modelo A', 'Marca A', '1234AB', 'Bollo en la parte delantera', '12345678A', 'ABC123', '1234567890'),
(12, 'Avenida Central 456', 'Modelo B', 'Marca B', '5678CD', 'Avería B', '12345678A', 'DEF456', '1234567890'),
(13, 'Plaza Mayor 789', 'Modelo C', 'Marca C', '9012EF', 'Avería C', '23456789B', 'GHI789', '5678901234'),
(14, 'Calle Secundaria 456', 'Modelo D', 'Marca D', '3456GH', 'Avería D', '23456789B', 'JKL012', '9876543210'),
(15, 'Avenida Principal 789', 'Modelo E', 'Marca E', '7890IJ', 'Avería E', '45678901D', 'MNO345', '5678901234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id` int(11) NOT NULL,
  `ClientesID` varchar(20) DEFAULT NULL,
  `CochesID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id`, `ClientesID`, `CochesID`) VALUES
(1, '12345678A', 1),
(12345688, '12345678A', 12),
(12345689, '12345678A', 13),
(12345690, '12345678A', 14),
(12345691, '12345678A', 15),
(12345692, '12345678A', 16),
(12345693, '12345678A', 17),
(12345694, '12345678A', 18),
(12345695, '12345678A', 19),
(12345696, '12345678A', 20),
(12345697, '12345678A', 21),
(12345698, '12345678A', 12),
(12345700, '12345678A', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motor`
--

CREATE TABLE `motor` (
  `id` int(4) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Precio` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `motor`
--

INSERT INTO `motor` (`id`, `Nombre`, `Precio`) VALUES
(1, 'Motor V6', '15000.00'),
(2, 'Motor Turbo', '18000.00'),
(3, 'Motor Híbrido', '20000.00'),
(4, 'Motor Eléctrico', '25000.00'),
(5, 'Motor V8', '30000.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movers`
--

CREATE TABLE `movers` (
  `dni` varchar(10) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `movers`
--

INSERT INTO `movers` (`dni`, `nombre`, `apellidos`, `telefono`) VALUES
('1234567890', 'Juan', 'Pérez', '123456789'),
('4321098765', 'Laura', 'Martínez', '432109876'),
('5678901234', 'Pedro', 'López', '567890123'),
('8765432109', 'Carlos', 'Fernández', '876543210'),
('9876543210', 'María', 'García', '987654321');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operarios`
--

CREATE TABLE `operarios` (
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contrasena` varchar(15) DEFAULT NULL,
  `trabajador` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `operarios`
--

INSERT INTO `operarios` (`dni`, `nombre`, `apellido`, `email`, `contrasena`, `trabajador`) VALUES
('11111111A', 'Juan', 'Perez', 'juan@example.com', '1234', 't'),
('22222222B', 'Ana', 'Lopez', 'ana@example.com', '1234', 't'),
('33333333C', 'Pedro', 'Gomez', 'pedro@example.com', '1234', 't'),
('44444444D', 'María', 'Rodriguez', 'maria@example.com', '1234', 't'),
('55555555E', 'Luis', 'Hernandez', 'luis@example.com', '1234', 't');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pintura`
--

CREATE TABLE `pintura` (
  `id` int(9) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Precio` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pintura`
--

INSERT INTO `pintura` (`id`, `Nombre`, `Precio`) VALUES
(1, 'Negro', '1000.00'),
(2, 'Blanco', '800.00'),
(3, 'Rojo', '1200.00'),
(4, 'Azul', '1000.00'),
(5, 'Gris', '900.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puertas`
--

CREATE TABLE `puertas` (
  `id` int(4) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Precio` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `puertas`
--

INSERT INTO `puertas` (`id`, `Nombre`, `Precio`) VALUES
(1, '2 Puertas', '1500.00'),
(2, '3 Puertas', '2000.00'),
(3, '4 Puertas', '2500.00'),
(4, '5 Puertas', '3000.00'),
(5, '6 Puertas', '3500.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ruedas`
--

CREATE TABLE `ruedas` (
  `id` int(4) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Precio` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ruedas`
--

INSERT INTO `ruedas` (`id`, `Nombre`, `Precio`) VALUES
(1, 'Ruedas de Aleación', '1000.00'),
(2, 'Ruedas de Acero', '800.00'),
(3, 'Ruedas de Invierno', '1200.00'),
(4, 'Ruedas Todo Terreno', '1500.00'),
(5, 'Ruedas Deportivas', '2000.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taller`
--

CREATE TABLE `taller` (
  `CIF` varchar(10) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `telefono` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `taller`
--

INSERT INTO `taller` (`CIF`, `nombre`, `direccion`, `telefono`) VALUES
('ABC123', 'Taller A', 'Calle Principal 123', '123456789'),
('BCD890', 'Taller J', 'Calle Central 234', '901234567'),
('DEF456', 'Taller B', 'Avenida Central 456', '987654321'),
('GHI789', 'Taller C', 'Plaza Mayor 789', '567890123'),
('JKL012', 'Taller D', 'Calle Secundaria 456', '432109876'),
('MNO345', 'Taller E', 'Avenida Principal 789', '876543210'),
('PQR678', 'Taller F', 'Plaza Central 012', '012345678'),
('STU901', 'Taller G', 'Calle Mayor 345', '901234567'),
('VWX234', 'Taller H', 'Avenida Secundaria 678', '234567890'),
('YZA567', 'Taller I', 'Plaza Secundaria 901', '567890123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traccion`
--

CREATE TABLE `traccion` (
  `id` int(4) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Precio` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `traccion`
--

INSERT INTO `traccion` (`id`, `Nombre`, `Precio`) VALUES
(1, 'Tracción Delantera', '2000.00'),
(2, 'Tracción Trasera', '2500.00'),
(3, 'Tracción en las Cuatro Ruedas', '3000.00'),
(4, 'Tracción Integral', '3500.00'),
(5, 'Tracción Variable', '4000.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `Marca` varchar(50) DEFAULT NULL,
  `Modelo` varchar(50) DEFAULT NULL,
  `Kilometros` int(8) DEFAULT NULL,
  `Cliente` varchar(9) DEFAULT NULL,
  `Precio` decimal(7,2) DEFAULT NULL,
  `Descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `Marca`, `Modelo`, `Kilometros`, `Cliente`, `Precio`, `Descripcion`) VALUES
(6, 'Toyota', 'Corolla', 5000, '12345678A', '15000.00', 'Coche en excelente estado, único dueño'),
(7, 'Ford', 'Focus', 8000, '12345678A', '12000.00', 'Vehículo en buen estado, ideal para ciudad'),
(8, 'BMW', 'Serie 3', 30000, '23456789B', '25000.00', 'Excelente coche deportivo, perfecto para los amantes de la velocidad'),
(9, 'Volkswagen', 'Golf', 15000, '34567890C', '18000.00', 'Coche compacto en muy buen estado, bajo consumo de combustible'),
(10, 'Mercedes-Benz', 'Clase C', 2000, '34567890C', '35000.00', 'Elegante y potente, perfecto para los amantes del lujo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesorios`
--
ALTER TABLE `accesorios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `carroceria`
--
ALTER TABLE `carroceria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`DNI`);

--
-- Indices de la tabla `coches`
--
ALTER TABLE `coches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Motor_ID` (`Motor_ID`),
  ADD KEY `Ruedas_ID` (`Ruedas_ID`),
  ADD KEY `Carroceria_ID` (`Carroceria_ID`),
  ADD KEY `Pintura_ID` (`Pintura_ID`),
  ADD KEY `Traccion_ID` (`Traccion_ID`),
  ADD KEY `Puertas_ID` (`Puertas_ID`),
  ADD KEY `Accesorios_ID` (`Accesorios_ID`);

--
-- Indices de la tabla `encargo`
--
ALTER TABLE `encargo`
  ADD PRIMARY KEY (`idencargo`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `dni_operario` (`dni_operario`),
  ADD KEY `FK_encargo_estadoEncargo` (`estadoEncargoId`);

--
-- Indices de la tabla `estadoencargo`
--
ALTER TABLE `estadoencargo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `encargoId` (`encargoId`);

--
-- Indices de la tabla `factaveria`
--
ALTER TABLE `factaveria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dni_cliente` (`dni_cliente`),
  ADD KEY `CIF_taller` (`CIF_taller`),
  ADD KEY `dni_mover` (`dni_mover`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ClientesID` (`ClientesID`),
  ADD KEY `CochesID` (`CochesID`);

--
-- Indices de la tabla `motor`
--
ALTER TABLE `motor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `movers`
--
ALTER TABLE `movers`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `operarios`
--
ALTER TABLE `operarios`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `pintura`
--
ALTER TABLE `pintura`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `puertas`
--
ALTER TABLE `puertas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ruedas`
--
ALTER TABLE `ruedas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `taller`
--
ALTER TABLE `taller`
  ADD PRIMARY KEY (`CIF`);

--
-- Indices de la tabla `traccion`
--
ALTER TABLE `traccion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Cliente` (`Cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accesorios`
--
ALTER TABLE `accesorios`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `carroceria`
--
ALTER TABLE `carroceria`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `coches`
--
ALTER TABLE `coches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `encargo`
--
ALTER TABLE `encargo`
  MODIFY `idencargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `estadoencargo`
--
ALTER TABLE `estadoencargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factaveria`
--
ALTER TABLE `factaveria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12345705;

--
-- AUTO_INCREMENT de la tabla `motor`
--
ALTER TABLE `motor`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pintura`
--
ALTER TABLE `pintura`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `puertas`
--
ALTER TABLE `puertas`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ruedas`
--
ALTER TABLE `ruedas`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `traccion`
--
ALTER TABLE `traccion`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `coches`
--
ALTER TABLE `coches`
  ADD CONSTRAINT `coches_ibfk_1` FOREIGN KEY (`Motor_ID`) REFERENCES `motor` (`id`),
  ADD CONSTRAINT `coches_ibfk_2` FOREIGN KEY (`Ruedas_ID`) REFERENCES `ruedas` (`id`),
  ADD CONSTRAINT `coches_ibfk_3` FOREIGN KEY (`Carroceria_ID`) REFERENCES `carroceria` (`id`),
  ADD CONSTRAINT `coches_ibfk_4` FOREIGN KEY (`Pintura_ID`) REFERENCES `pintura` (`id`),
  ADD CONSTRAINT `coches_ibfk_5` FOREIGN KEY (`Traccion_ID`) REFERENCES `traccion` (`id`),
  ADD CONSTRAINT `coches_ibfk_6` FOREIGN KEY (`Puertas_ID`) REFERENCES `puertas` (`id`),
  ADD CONSTRAINT `coches_ibfk_7` FOREIGN KEY (`Accesorios_ID`) REFERENCES `accesorios` (`id`);

--
-- Filtros para la tabla `encargo`
--
ALTER TABLE `encargo`
  ADD CONSTRAINT `FK_encargo_estadoEncargo` FOREIGN KEY (`estadoEncargoId`) REFERENCES `estadoencargo` (`id`),
  ADD CONSTRAINT `encargo_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id`),
  ADD CONSTRAINT `encargo_ibfk_2` FOREIGN KEY (`dni_operario`) REFERENCES `operarios` (`dni`);

--
-- Filtros para la tabla `estadoencargo`
--
ALTER TABLE `estadoencargo`
  ADD CONSTRAINT `estadoencargo_ibfk_1` FOREIGN KEY (`encargoId`) REFERENCES `encargo` (`idencargo`);

--
-- Filtros para la tabla `factaveria`
--
ALTER TABLE `factaveria`
  ADD CONSTRAINT `factaveria_ibfk_1` FOREIGN KEY (`dni_cliente`) REFERENCES `clientes` (`DNI`),
  ADD CONSTRAINT `factaveria_ibfk_2` FOREIGN KEY (`CIF_taller`) REFERENCES `taller` (`CIF`),
  ADD CONSTRAINT `factaveria_ibfk_3` FOREIGN KEY (`dni_mover`) REFERENCES `movers` (`dni`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`ClientesID`) REFERENCES `clientes` (`DNI`),
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`CochesID`) REFERENCES `coches` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`Cliente`) REFERENCES `clientes` (`DNI`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
