-- Crear la base de datos
CREATE DATABASE demosys;

-- Usar la base de datos
USE demosys;

-- Crear la tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'cobrador', 'cliente') NOT NULL
);

-- Insertar algunos usuarios de prueba
INSERT INTO usuarios (username, password, role) VALUES
('admin', 'admin123', 'admin'),
('cobrador', 'cobrador123', 'cobrador'),
('cliente', 'cliente123', 'cliente');
