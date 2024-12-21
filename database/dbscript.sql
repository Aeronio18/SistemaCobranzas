CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'cobrador', 'cliente') NOT NULL
);
INSERT INTO usuario (nombre_usuario, password, rol) VALUES
('admin', 'admin123', 'admin'),
('cobrador1', 'cobrador123', 'cobrador'),
('cliente1', 'cliente123', 'cliente');
