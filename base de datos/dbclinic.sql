-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-07-2025 a las 05:48:18
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbclinic`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `AdministradorId` int(11) NOT NULL,
  `UsuarioId` int(11) NOT NULL,
  `FechaIngreso` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`AdministradorId`, `UsuarioId`, `FechaIngreso`) VALUES
(3, 3, '2024-11-26'),
(4, 8, '2024-11-29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistentes`
--

CREATE TABLE `asistentes` (
  `AsistenteId` int(11) NOT NULL,
  `UsuarioId` int(11) NOT NULL,
  `FechaIngreso` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistentes`
--

INSERT INTO `asistentes` (`AsistenteId`, `UsuarioId`, `FechaIngreso`) VALUES
(1, 5, '2024-11-26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `CitaId` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `PacienteId` int(11) NOT NULL,
  `DoctorId` int(11) NOT NULL,
  `AsistenteId` int(11) DEFAULT NULL,
  `Estado` enum('Agendada','Cancelada','Completada') DEFAULT 'Agendada',
  `Notas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`CitaId`, `Fecha`, `Hora`, `PacienteId`, `DoctorId`, `AsistenteId`, `Estado`, `Notas`) VALUES
(5, '2024-11-27', '08:00:00', 2, 2, NULL, 'Completada', 'prueba1'),
(6, '2024-11-27', '11:00:00', 2, 2, NULL, 'Completada', 'prueba'),
(7, '2024-11-28', '09:00:00', 1, 2, NULL, 'Agendada', 'prueba2'),
(8, '2024-11-29', '08:00:00', 2, 2, NULL, 'Agendada', 'PRUEBA 1'),
(9, '2024-12-03', '08:00:00', 2, 2, NULL, 'Agendada', 'prueba hoy'),
(10, '2025-06-27', '09:30:00', 2, 3, NULL, 'Completada', '6ythhy'),
(13, '2025-07-07', '08:00:00', 2, 3, NULL, 'Agendada', 'vgft4w'),
(14, '2025-07-08', '08:30:00', 5, 3, NULL, 'Agendada', 'DIA '),
(15, '2025-07-08', '09:30:00', 2, 3, NULL, 'Agendada', 'prueba'),
(16, '2025-07-09', '09:00:00', 2, 3, NULL, 'Agendada', 'rvssb');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctores`
--

CREATE TABLE `doctores` (
  `DoctorId` int(11) NOT NULL,
  `UsuarioId` int(11) NOT NULL,
  `EspecialidadId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `doctores`
--

INSERT INTO `doctores` (`DoctorId`, `UsuarioId`, `EspecialidadId`) VALUES
(2, 4, 1),
(3, 6, 1),
(4, 7, 1),
(5, 9, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `EspecialidadId` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especialidades`
--

INSERT INTO `especialidades` (`EspecialidadId`, `Nombre`) VALUES
(1, 'Odontopediatría '),
(2, 'Ortodoncia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `HorarioId` int(11) NOT NULL,
  `DoctorId` int(11) NOT NULL,
  `Dia` enum('Lunes','Martes','Miércoles','Jueves','Viernes') NOT NULL,
  `Hora_Inicio` time NOT NULL,
  `Hora_Fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`HorarioId`, `DoctorId`, `Dia`, `Hora_Inicio`, `Hora_Fin`) VALUES
(2, 2, 'Martes', '08:00:00', '10:00:00'),
(3, 2, 'Miércoles', '08:00:00', '18:00:00'),
(4, 2, 'Jueves', '12:00:00', '18:00:00'),
(5, 2, 'Viernes', '08:00:00', '18:00:00'),
(8, 3, 'Miércoles', '08:00:00', '12:00:00'),
(9, 3, 'Viernes', '08:00:00', '12:00:00'),
(10, 3, 'Lunes', '08:00:00', '12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `PacienteId` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Ape_Paterno` varchar(50) NOT NULL,
  `Ape_Materno` varchar(50) NOT NULL,
  `DNI` int(11) NOT NULL,
  `Fecha_Nacimiento` date NOT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `Direccion` varchar(100) DEFAULT NULL,
  `Sexo` enum('Masculino','Femenino') NOT NULL,
  `Estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`PacienteId`, `Nombre`, `Ape_Paterno`, `Ape_Materno`, `DNI`, `Fecha_Nacimiento`, `Telefono`, `Direccion`, `Sexo`, `Estado`) VALUES
(1, 'alex', 'huaman', 'martin', 87654321, '2000-11-09', '983866788', 'jr cajamarca', 'Masculino', 'Activo'),
(2, 'jose', 'burga', 'huaman', 48595852, '2002-10-29', '845926845', 'jr cajamarca', 'Masculino', 'Activo'),
(3, 'jhon', 'llanos', 'llanos', 85843887, '2012-10-02', '985555541', 'jr cajamarca-bagua', 'Masculino', 'Activo'),
(4, 'Juan', 'Perez', 'Lopez', 12345678, '1980-05-15', '987654321', 'Calle Ficticia 123, Lima', 'Masculino', 'Activo'),
(5, 'Maria', 'Gomez', 'Martinez', 23456789, '1992-07-20', '987654322', 'Av. Real 456, Lima', 'Femenino', 'Activo'),
(6, 'Carlos', 'Diaz', 'Sanchez', 34567890, '1975-03-30', '987654323', 'Calle Principal 789, Lima', 'Masculino', 'Activo'),
(7, 'Ana', 'Torres', 'Jimenez', 45678901, '1988-11-12', '987654324', 'Av. de la Paz 123, Arequipa', 'Femenino', 'Activo'),
(8, 'Luis', 'Mendoza', 'Ruiz', 56789012, '1995-10-22', '987654325', 'Calle 25 de Mayo 456, Trujillo', 'Masculino', 'Activo'),
(9, 'Elena', 'Ramirez', 'Morales', 67890123, '1984-01-10', '987654326', 'Jr. San Martin 789, Cusco', 'Femenino', 'Activo'),
(10, 'Pedro', 'Jimenez', 'Hernandez', 78901234, '1990-12-05', '987654327', 'Calle Bolívar 123, Piura', 'Masculino', 'Activo'),
(11, 'Lucia', 'Vargas', 'Fernandez', 89012345, '1983-08-17', '987654328', 'Jr. Belén 456, Arequipa', 'Femenino', 'Activo'),
(12, 'Miguel', 'Castro', 'Lozano', 90123456, '1972-02-28', '987654329', 'Av. Los Álamos 789, Ica', 'Masculino', 'Activo'),
(13, 'Sara', 'Hernandez', 'Mora', 11223344, '1998-09-25', '987654330', 'Calle El Sol 123, Chiclayo', 'Femenino', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `PermisoId` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_permisos`
--

CREATE TABLE `roles_permisos` (
  `TipoUsuario` enum('Administrador','Asistente','Doctor') NOT NULL,
  `PermisoId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `UsuarioId` int(11) NOT NULL,
  `Codigo` int(11) NOT NULL,
  `Contraseña` varchar(255) DEFAULT NULL,
  `TipoUsuario` enum('Administrador','Asistente','Doctor') NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Ape_Paterno` varchar(50) NOT NULL,
  `Ape_Materno` varchar(50) NOT NULL,
  `DNI` int(11) NOT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `Direccion` varchar(100) DEFAULT NULL,
  `Estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`UsuarioId`, `Codigo`, `Contraseña`, `TipoUsuario`, `Nombre`, `Ape_Paterno`, `Ape_Materno`, `DNI`, `Telefono`, `Direccion`, `Estado`) VALUES
(3, 9000, 'c4fe6b6dbe94790f232013154cb80fc5dd3ec9106d433492f20f038b1ce25656', 'Administrador', 'Juan', 'Pérez', 'López', 12345678, '987654321', 'Av. Siempre Viva 123', 'Activo'),
(4, 1005, '0b3baf54fa37185ab5d0b45286cb12a25dc4ba673e1fbbb898696dc96a686e68', 'Doctor', 'María', 'Gómez', 'Martínez', 87654321, '987654325', 'Av. Los Laureles 456', 'Activo'),
(5, 2000, '81a83544cf93c245178cbc1620030f1123f435af867c79d87135983c52ab39d9', 'Asistente', 'Maria', 'Gomez', 'Garcia', 77482947, '988988989', 'jr cajamarca', 'Activo'),
(6, 2001, '85d6385b945c0d602103db39b0b654b2af93b5127938e26a959c123f0789b948', 'Doctor', 'prueba1', 'ver', 'details', 15668566, '985562154', 'jr bagua', 'Activo'),
(7, 3000, '0b3baf54fa37185ab5d0b45286cb12a25dc4ba673e1fbbb898696dc96a686e68', 'Doctor', 'marcos', 'enrique', 'llanos', 54879868, '986865356', 'los andes', 'Activo'),
(8, 5555, 'c1f330d0aff31c1c87403f1e4347bcc21aff7c179908723535f2b31723702525', 'Administrador', 'prueba', 'prueba', 'prueba', 48595852, '983866788', 'bagua', 'Activo'),
(9, 8000, 'bca2a540549124799ac42a78cbc2df0eeedceea7da0518744ab12d0855e9e17c', 'Doctor', 'prueb', 'prueba', 'prueba', 41522525, '983686533', 'bagua', 'Activo');

--
-- Disparadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `after_insert_usuario` AFTER INSERT ON `usuarios` FOR EACH ROW BEGIN
    -- Verificar si el TipoUsuario es 'Doctor'
    IF NEW.TipoUsuario = 'Doctor' THEN
        INSERT INTO Doctores (UsuarioId, EspecialidadId)
        VALUES (NEW.UsuarioId, 1); -- Cambiar 1 por un ID de especialidad predeterminado si es necesario
    END IF;

    -- Verificar si el TipoUsuario es 'Asistente'
    IF NEW.TipoUsuario = 'Asistente' THEN
        INSERT INTO Asistentes (UsuarioId, FechaIngreso)
        VALUES (NEW.UsuarioId, CURDATE()); -- Usa la fecha actual como FechaIngreso
    END IF;

    -- Verificar si el TipoUsuario es 'Administrador'
    IF NEW.TipoUsuario = 'Administrador' THEN
        INSERT INTO Administradores (UsuarioId, FechaIngreso)
        VALUES (NEW.UsuarioId, CURDATE()); -- Usa la fecha actual como FechaIngreso
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_insert_Usuarios` BEFORE INSERT ON `usuarios` FOR EACH ROW BEGIN
    -- Encripta la contraseña usando SHA2 con 256 bits
    SET NEW.Contraseña = SHA2(NEW.Contraseña, 256);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_update_Usuarios` BEFORE UPDATE ON `usuarios` FOR EACH ROW BEGIN
    -- Encripta la contraseña usando SHA2 con 256 bits
    SET NEW.Contraseña = SHA2(NEW.Contraseña, 256);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_update_tipo_usuario` BEFORE UPDATE ON `usuarios` FOR EACH ROW BEGIN
    -- Verificar si el TipoUsuario está cambiando
    IF OLD.TipoUsuario != NEW.TipoUsuario THEN
        -- Si el usuario anterior era 'Administrador', eliminarlo de la tabla Administradores
        IF OLD.TipoUsuario = 'Administrador' THEN
            DELETE FROM Administradores WHERE UsuarioId = OLD.UsuarioId;
        END IF;

        -- Si el usuario anterior era 'Asistente', eliminarlo de la tabla Asistentes
        IF OLD.TipoUsuario = 'Asistente' THEN
            DELETE FROM Asistentes WHERE UsuarioId = OLD.UsuarioId;
        END IF;

        -- Si el usuario anterior era 'Doctor', eliminarlo de la tabla Doctores
        IF OLD.TipoUsuario = 'Doctor' THEN
            DELETE FROM Doctores WHERE UsuarioId = OLD.UsuarioId;
        END IF;

        -- Si el nuevo tipo de usuario es 'Administrador', agregarlo a la tabla Administradores
        IF NEW.TipoUsuario = 'Administrador' THEN
            INSERT INTO Administradores (UsuarioId, FechaIngreso)
            VALUES (NEW.UsuarioId, CURDATE());
        END IF;

        -- Si el nuevo tipo de usuario es 'Asistente', agregarlo a la tabla Asistentes
        IF NEW.TipoUsuario = 'Asistente' THEN
            INSERT INTO Asistentes (UsuarioId, FechaIngreso)
            VALUES (NEW.UsuarioId, CURDATE());
        END IF;

        -- Si el nuevo tipo de usuario es 'Doctor', agregarlo a la tabla Doctores
        IF NEW.TipoUsuario = 'Doctor' THEN
            INSERT INTO Doctores (UsuarioId, EspecialidadId)
            VALUES (NEW.UsuarioId, 1); -- Cambiar 1 por un ID de especialidad predeterminado si es necesario
        END IF;
    END IF;
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`AdministradorId`),
  ADD KEY `UsuarioId` (`UsuarioId`);

--
-- Indices de la tabla `asistentes`
--
ALTER TABLE `asistentes`
  ADD PRIMARY KEY (`AsistenteId`),
  ADD KEY `UsuarioId` (`UsuarioId`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`CitaId`),
  ADD KEY `PacienteId` (`PacienteId`),
  ADD KEY `DoctorId` (`DoctorId`),
  ADD KEY `AsistenteId` (`AsistenteId`);

--
-- Indices de la tabla `doctores`
--
ALTER TABLE `doctores`
  ADD PRIMARY KEY (`DoctorId`),
  ADD KEY `UsuarioId` (`UsuarioId`),
  ADD KEY `EspecialidadId` (`EspecialidadId`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`EspecialidadId`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`HorarioId`),
  ADD KEY `DoctorId` (`DoctorId`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`PacienteId`),
  ADD UNIQUE KEY `DNI` (`DNI`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`PermisoId`);

--
-- Indices de la tabla `roles_permisos`
--
ALTER TABLE `roles_permisos`
  ADD PRIMARY KEY (`TipoUsuario`,`PermisoId`),
  ADD KEY `PermisoId` (`PermisoId`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`UsuarioId`),
  ADD UNIQUE KEY `DNI` (`DNI`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `AdministradorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `asistentes`
--
ALTER TABLE `asistentes`
  MODIFY `AsistenteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `CitaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `doctores`
--
ALTER TABLE `doctores`
  MODIFY `DoctorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `EspecialidadId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `HorarioId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `PacienteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `PermisoId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `UsuarioId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD CONSTRAINT `administradores_ibfk_1` FOREIGN KEY (`UsuarioId`) REFERENCES `usuarios` (`UsuarioId`) ON DELETE CASCADE;

--
-- Filtros para la tabla `asistentes`
--
ALTER TABLE `asistentes`
  ADD CONSTRAINT `asistentes_ibfk_1` FOREIGN KEY (`UsuarioId`) REFERENCES `usuarios` (`UsuarioId`) ON DELETE CASCADE;

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`PacienteId`) REFERENCES `pacientes` (`PacienteId`) ON DELETE CASCADE,
  ADD CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`DoctorId`) REFERENCES `doctores` (`DoctorId`) ON DELETE CASCADE,
  ADD CONSTRAINT `citas_ibfk_3` FOREIGN KEY (`AsistenteId`) REFERENCES `asistentes` (`AsistenteId`) ON DELETE SET NULL;

--
-- Filtros para la tabla `doctores`
--
ALTER TABLE `doctores`
  ADD CONSTRAINT `doctores_ibfk_1` FOREIGN KEY (`UsuarioId`) REFERENCES `usuarios` (`UsuarioId`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctores_ibfk_2` FOREIGN KEY (`EspecialidadId`) REFERENCES `especialidades` (`EspecialidadId`) ON DELETE CASCADE;

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `horarios_ibfk_1` FOREIGN KEY (`DoctorId`) REFERENCES `doctores` (`DoctorId`) ON DELETE CASCADE;

--
-- Filtros para la tabla `roles_permisos`
--
ALTER TABLE `roles_permisos`
  ADD CONSTRAINT `roles_permisos_ibfk_1` FOREIGN KEY (`PermisoId`) REFERENCES `permisos` (`PermisoId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
