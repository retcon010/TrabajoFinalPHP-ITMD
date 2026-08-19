SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `sistema_itmd` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sistema_itmd`;

-- Tabla users_data (incluye todos los campos de perfil)
CREATE TABLE IF NOT EXISTS `users_data` (
  `idUser` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `apellidos` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `telefono` VARCHAR(20) DEFAULT NULL,
  `fecha_nacimiento` DATE NOT NULL,
  `direccion` TEXT DEFAULT NULL,
  `sexo` VARCHAR(20) DEFAULT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla users_login
CREATE TABLE IF NOT EXISTS `users_login` (
  `idLogin` INT(11) NOT NULL AUTO_INCREMENT,
  `idUser` INT(11) NOT NULL,
  `usuario` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `rol` ENUM('admin','user') NOT NULL,
  PRIMARY KEY (`idLogin`),
  UNIQUE KEY `idUser` (`idUser`),
  UNIQUE KEY `usuario` (`usuario`),
  CONSTRAINT `fk_user_login` FOREIGN KEY (`idUser`) REFERENCES `users_data` (`idUser`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla noticias (con soporte para nombres de imágenes subidas)
CREATE TABLE IF NOT EXISTS `noticias` (
  `idNoticia` INT(11) NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(200) NOT NULL,
  `imagen` VARCHAR(255) NOT NULL,
  `texto` TEXT NOT NULL,
  `fecha` DATE NOT NULL,
  `idUser` INT(11) NOT NULL,
  PRIMARY KEY (`idNoticia`),
  UNIQUE KEY `titulo` (`titulo`),
  CONSTRAINT `fk_noticia_user` FOREIGN KEY (`idUser`) REFERENCES `users_data` (`idUser`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla citas
CREATE TABLE IF NOT EXISTS `citas` (
  `idCita` INT(11) NOT NULL AUTO_INCREMENT,
  `idUser` INT(11) NOT NULL,
  `fecha_cita` DATE NOT NULL,
  `motivo_cita` TEXT DEFAULT NULL,
  PRIMARY KEY (`idCita`),
  CONSTRAINT `fk_cita_user` FOREIGN KEY (`idUser`) REFERENCES `users_data` (`idUser`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. DATOS INICIALES (Admin: admin / Contraseña: admin123)
INSERT INTO `users_data` (`idUser`, `nombre`, `apellidos`, `email`, `telefono`, `fecha_nacimiento`, `direccion`, `sexo`) VALUES 
(1, 'Administrador', 'Sistema', 'admin@itmd.com', '600000000', '1990-01-01', 'Calle Principal 1', 'Otro');

INSERT INTO `users_login` (`idUser`, `usuario`, `password`, `rol`) VALUES 
(1, 'admin', 'admin123', 'admin');

COMMIT;