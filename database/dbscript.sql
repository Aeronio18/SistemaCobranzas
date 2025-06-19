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
ALTER TABLE clientes 
ADD fecha_nacimiento DATE,
ADD lugar_nacimiento VARCHAR(255),
ADD estado_civil ENUM('Soltero', 'Casado', 'Divorciado', 'Viudo'),
ADD sexo ENUM('Masculino', 'Femenino', 'Otro'),
ADD colonia VARCHAR(255),
ADD municipio VARCHAR(255),
ADD estado VARCHAR(255),
ADD codigo_postal VARCHAR(10),
ADD nss VARCHAR(20),
ADD curp VARCHAR(20),
ADD escolaridad VARCHAR(100),
ADD ocupacion VARCHAR(100),
ADD lugar_trabajo VARCHAR(255),

ADD nombre_negocio VARCHAR(255),
ADD negocio_domicilio VARCHAR(255),
ADD negocio_municipio VARCHAR(255),
ADD negocio_estado VARCHAR(255),
ADD negocio_codigo_postal VARCHAR(10),
ADD negocio_antiguedad VARCHAR(50),
ADD negocio_rfc VARCHAR(20),
ADD negocio_telefono VARCHAR(20),
ADD negocio_ingreso_mensual DECIMAL(10,2),

ADD conyuge_nombre VARCHAR(255),
ADD conyuge_fecha_nacimiento DATE,
ADD conyuge_telefono VARCHAR(20),
ADD conyuge_ocupacion VARCHAR(100),
ADD conyuge_lugar_trabajo VARCHAR(255),
ADD conyuge_ingreso_mensual DECIMAL(10,2),

ADD ref_fam_nombre VARCHAR(255),
ADD ref_fam_parentesco VARCHAR(100),
ADD ref_fam_telefono VARCHAR(20),
ADD ref_fam_domicilio VARCHAR(255),
ADD ref_fam_colonia VARCHAR(255),
ADD ref_fam_municipio VARCHAR(255),
ADD ref_fam_estado VARCHAR(255),
ADD ref_fam_codigo_postal VARCHAR(10),

ADD ref_no_fam_nombre VARCHAR(255),
ADD ref_no_fam_parentesco VARCHAR(100),
ADD ref_no_fam_telefono VARCHAR(20),
ADD ref_no_fam_domicilio VARCHAR(255),
ADD ref_no_fam_colonia VARCHAR(255),
ADD ref_no_fam_municipio VARCHAR(255),
ADD ref_no_fam_estado VARCHAR(255),
ADD ref_no_fam_codigo_postal VARCHAR(10),

ADD asesor_id INT,
ADD fecha_inicio DATE,
ADD fecha_termino DATE,
ADD importe DECIMAL(10,2);


-- Crear tabla asesores
CREATE TABLE IF NOT EXISTS asesores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    contacto VARCHAR(15) NOT NULL,
    nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
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
ALTER TABLE pagos
ADD COLUMN latitud DECIMAL(10, 7) NULL,
ADD COLUMN longitud DECIMAL(10, 7) NULL;

