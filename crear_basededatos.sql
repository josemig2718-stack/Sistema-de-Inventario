-- ==========================================================
--  crear_basededatos.sql
--  Crea la base "Inventario", las tablas necesarias para el
--  almacén y carga registros de ejemplo.
--
--  Cómo usarlo:
--    1) Abrí http://localhost/phpmyadmin
--    2) Pestaña "SQL"
--    3) Pegá TODO el contenido de este archivo
--    4) Pulsá "Continuar"
-- ==========================================================

-- 1) Crear la base de datos con soporte UTF-8 (tildes, ñ, emojis)
CREATE DATABASE IF NOT EXISTS Inventario
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- 2) Usar esa base para las siguientes instrucciones
USE Inventario;

-- 3) Borrar las tablas anteriores si existen (en orden inverso a las relaciones)
DROP TABLE IF EXISTS movimientos;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS categorias;

-- 4) Crear las tablas del sistema (Mínimo 3 tablas con relaciones)

-- Tabla 1: Categorías (No depende de nadie)
CREATE TABLE categorias (
    ID_Categoria    INT AUTO_INCREMENT PRIMARY KEY,
    Nombre          VARCHAR(100) NOT NULL,
    Descripcion     VARCHAR(255)
);

-- Tabla 2: Productos (Depende de Categorías)
CREATE TABLE productos (
    ID_Producto     INT AUTO_INCREMENT PRIMARY KEY,
    Nombre          VARCHAR(150) NOT NULL,
    Stock           INT DEFAULT 0,
    Precio          DECIMAL(10,2),
    ID_Categoria    INT,                              -- Llave Foránea
    creado_en       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_Categoria) REFERENCES categorias(ID_Categoria) ON DELETE SET NULL
);

-- Tabla 3: Movimientos (Depende de Productos para registrar Entradas/Salidas)
CREATE TABLE movimientos (
    ID_Movimiento   INT AUTO_INCREMENT PRIMARY KEY,
    ID_Producto     INT,                              -- Llave Foránea
    Tipo            VARCHAR(50) NOT NULL,             -- Ej: 'Entrada' o 'Salida'
    Cantidad        INT NOT NULL,
    Fecha           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_Producto) REFERENCES productos(ID_Producto) ON DELETE CASCADE
);

-- 5) Insertar registros de ejemplo
-- Llenamos categorías primero
INSERT INTO categorias (Nombre, Descripcion) VALUES
('Hardware', 'Componentes físicos de computadora'),
('Periféricos', 'Teclados, mouses, monitores, etc.'),
('Redes', 'Equipos de conectividad y cableado');

-- Llenamos productos
INSERT INTO productos (Nombre, Stock, Precio, ID_Categoria) VALUES
('Monitor Samsung 24"', 15, 120.50, 2),
('Disco Duro SSD 1TB', 30, 85.00, 1),
('Router Cisco', 20, 45.00, 3),
('Memoria RAM 16GB', 50, 60.00, 1),
('Teclado Mecánico', 25, 35.00, 2);

-- Llenamos algunos movimientos iniciales
INSERT INTO movimientos (ID_Producto, Tipo, Cantidad) VALUES
(1, 'Entrada', 15),
(2, 'Entrada', 30),
(3, 'Entrada', 20),
(4, 'Entrada', 50),
(5, 'Entrada', 25);

-- 6) Verificar que se cargaron correctamente
SELECT COUNT(*) AS total_productos FROM productos;