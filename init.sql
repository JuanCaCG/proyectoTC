CREATE DATABASE IF NOT EXISTS biblioteca_digital;
USE biblioteca_digital;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('usuario', 'administrador') DEFAULT 'usuario'
);

CREATE TABLE IF NOT EXISTS libros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    anio INT NOT NULL,
    genero VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS lista_lectura (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    libro_id INT NOT NULL,
    favorito BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (libro_id) REFERENCES libros(id) ON DELETE CASCADE
);

-- Crear un usuario administrador
INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Admin', 'juan@TC.com', MD5('admin'), 'administrador');
