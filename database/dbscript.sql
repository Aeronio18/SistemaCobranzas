-- Crear tabla usuario
CREATE TABLE IF NOT EXISTS usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'cobrador', 'asist') NOT NULL
);

-- Crear tabla clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    direccion TEXT NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    giro_negocio VARCHAR(255) NOT NULL,
    tipo_producto VARCHAR(255) NOT NULL,
    foto_local VARCHAR(255) NOT NULL,
    ubicacion_google_maps TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla asesores
CREATE TABLE IF NOT EXISTS asesores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    contacto VARCHAR(15) NOT NULL,
    numero_asesor VARCHAR(8) NOT NULL UNIQUE,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla creditos
CREATE TABLE IF NOT EXISTS creditos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    asesor_id INT NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_termino DATE NOT NULL,
    importe DECIMAL(10,2) NOT NULL,
    abono DECIMAL(10,2) NOT NULL DEFAULT 0,
    saldo_pendiente DECIMAL(10,2) GENERATED ALWAYS AS (importe - abono) STORED,
    estado ENUM('pendiente', 'pagado', 'vencido') NOT NULL DEFAULT 'pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY (asesor_id) REFERENCES asesores(id) ON DELETE CASCADE
);

-- Crear tabla pagos
CREATE TABLE IF NOT EXISTS pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    credito_id INT NOT NULL,
    monto DECIMAL(10, 2) NOT NULL,
    fecha_pago DATE NOT NULL,
    metodo_pago VARCHAR(50) NOT NULL,
    FOREIGN KEY (credito_id) REFERENCES creditos(id) ON DELETE CASCADE
);
