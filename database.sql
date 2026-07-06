-- ========================================================
-- ESTRUCTURA DE LA TABLA: users_login
-- ========================================================

CREATE TABLE IF NOT EXISTS `users_login` (
  `idLogin` INT(11) NOT NULL AUTO_INCREMENT,
  `idUser` INT(11) NOT NULL,
  `usuario` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `rol` ENUM('admin', 'user') NOT NULL,
  PRIMARY KEY (`idLogin`),
  UNIQUE KEY `idUser` (`idUser`),
  UNIQUE KEY `usuario` (`usuario`),
  CONSTRAINT `fk_user_login` FOREIGN KEY (`idUser`) 
    REFERENCES `users_data` (`idUser`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================================
-- VOLCADO DE DATOS: Usuarios del Sistema
-- ========================================================

INSERT INTO `users_login` (`idLogin`, `idUser`, `usuario`, `password`, `rol`) VALUES
(2, 2, 'admin', '$2y$10$BzpPL44U4GuYbTbO5e.5AuL2GBRKVeSjhqOeCnUU2EvGzRopqnkzK', 'admin'),
(5, 7, 'usuario-test', '$2y$10$QJanpdmAUPLz6YYdaktUE.5Sr125woHZHj8QMBuG0rH97xo1g3mNa', 'user');