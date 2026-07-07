-- 1. CREACION DE LA BASE DE DATOS
CREATE DATABASE IF NOT EXISTS 'sistema_itmd' DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE 'sistema_itmd';

-- 2. TABLA: users_data
CREATE TABLE 'users_data' (
  'idUser' int(11) NOT NULL AUTO_INCREMENT,
  'nombre' varchar(100) NOT NULL,
  'apellidos' varchar(100) NOT NULL,
  'email' varchar(100) NOT NULL,
  'telefono' varchar(20) NOT NULL,
  'fecha_nacimiento' date NOT NULL,
  'direccion' text DEFAULT NULL,
  'sexo' varchar(20) DEFAULT NULL,
  PRIMARY KEY ('idUser'),
  UNIQUE KEY 'email' ('email')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. TABLA: users_login
CREATE TABLE 'users_login' (
  'idLogin' int(11) NOT NULL AUTO_INCREMENT,
  'idUser' int(11) NOT NULL,
  'usuario' varchar(50) NOT NULL,
  'password' varchar(255) NOT NULL,
  'rol' enum('admin','user') NOT NULL,
  PRIMARY KEY ('idLogin'),
  UNIQUE KEY 'idUser' ('idUser'),
  UNIQUE KEY 'usuario' ('usuario'),
  CONSTRAINT 'fk_user_login' FOREIGN KEY ('idUser') REFERENCES 'users_data' ('idUser') ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. TABLA: noticias
CREATE TABLE 'noticias' (
  'idNoticia' int(11) NOT NULL AUTO_INCREMENT,
  'titulo' varchar(200) NOT NULL,
  'imagen' varchar(255) NOT NULL,
  'texto' text NOT NULL,
  'fecha' date NOT NULL,
  'idUser' int(11) NOT NULL,
  PRIMARY KEY ('idNoticia'),
  UNIQUE KEY 'titulo' ('titulo'),
  CONSTRAINT 'fk_noticia_user' FOREIGN KEY ('idUser') REFERENCES 'users_data' ('idUser') ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. TABLA: citas
CREATE TABLE 'citas' (
  'idCita' int(11) NOT NULL AUTO_INCREMENT,
  'idUser' int(11) NOT NULL,
  'fecha_cita' date NOT NULL,
  'motivo_cita' text DEFAULT NULL,
  PRIMARY KEY ('idCita'),
  CONSTRAINT 'fk_cita_user' FOREIGN KEY ('idUser') REFERENCES 'users_data' ('idUser') ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. DATOS INICIALES
-- Admin (Pass: admin123)
INSERT INTO 'users_data' ('idUser', 'nombre', 'apellidos', 'email', 'telefono', 'fecha_nacimiento') 
VALUES (2, 'Admin', 'Sistema', 'admin@itmd.com', '000', '1990-01-01');

INSERT INTO 'users_login' ('idUser', 'usuario', 'password', 'rol') 
VALUES (2, 'admin', '$2y$10$89vIe6.7S/uS6XN6WpApxO3v/0.m2A8v5E5MvGvW2YqUf9rD1r/2y', 'admin');

-- Usuario Prueba (Pass: usuario123)
INSERT INTO 'users_data' ('idUser', 'nombre', 'apellidos', 'email', 'telefono', 'fecha_nacimiento') 
VALUES (7, 'Usuario', 'Prueba', 'test@itmd.com', '111', '2000-01-01');

INSERT INTO 'users_login' ('idUser', 'usuario', 'password', 'rol') 
VALUES (7, 'usuario', '$2y$10$fV3.vO77M8K1P.Qx7N7qUeYqf7vH2f6v9Mv/WvXGv7YqUf9rD1r/2', 'user');

-- Noticias
INSERT INTO 'noticias' ('titulo', 'imagen', 'texto', 'fecha', 'idUser') VALUES
('Seguridad en ITMD', 'noticia1.jpg', 'Implementamos encriptacion BCrypt para proteger tus datos.', CURDATE(), 2),
('Nueva Sede', 'noticia2.jpg', 'Inauguramos infraestructura digital en la nube.', CURDATE(), 2);