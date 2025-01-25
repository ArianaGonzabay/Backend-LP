-- Crear base de datos y seleccionar su uso
CREATE DATABASE IF NOT EXISTS tienda;
USE tienda;

-- Crear tabla productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    categoria VARCHAR(100) NOT NULL,
    stock INT DEFAULT 0,
    fecha_vencimiento DATE,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Crear tabla usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    direccion VARCHAR(255),
    telefono VARCHAR(50),
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Crear tabla pedidos
CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2) NOT NULL,
    metodo_pago VARCHAR(50) NOT NULL,
    direccion_envio VARCHAR(255),
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Crear tabla detalles_pedido
CREATE TABLE IF NOT EXISTS detalles_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);

-- Crear tabla reseñas
CREATE TABLE IF NOT EXISTS reseñas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    usuario_id INT NOT NULL,
    comentario TEXT NOT NULL,
    calificacion INT CHECK (calificacion BETWEEN 1 AND 5),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (producto_id) REFERENCES productos(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Crear tabla facturas
CREATE TABLE IF NOT EXISTS facturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    fecha_emision TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2) NOT NULL,
    metodo_pago VARCHAR(50) NOT NULL,
    direccion_envio VARCHAR(255),
    estado VARCHAR(50) DEFAULT 'Pendiente',
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id)
);

-- Insertar datos iniciales en la tabla productos
INSERT INTO productos (nombre, descripcion, precio, categoria, stock, fecha_vencimiento) VALUES
('Plátanos', 'Plátanos maduros, ideales para un snack saludable', 1.20, 'Frutas', 120, '2025-05-15'),
('Yogur natural', 'Yogur sin azúcar, excelente opción para el desayuno', 1.80, 'Lácteos', 180, '2025-03-01'),
('Huevos', 'Huevos frescos, ideales para tus recetas diarias', 2.40, 'Lácteos', 250, '2025-02-20'),
('Pan integral', 'Pan integral de trigo, fresco y saludable', 1.50, 'Panadería', 200, '2025-01-30'),
('Pasta de tomate', 'Pasta de tomate natural, ideal para salsas y recetas italianas', 1.00, 'Conservas', 150, '2025-11-01'),
('Aceite de oliva', 'Aceite de oliva extra virgen, ideal para cocinar y aderezar', 4.50, 'Aceites y vinagres', 100, '2025-06-10'),
('Pollo fresco', 'Pechugas de pollo frescas, para preparar tus platillos favoritos', 5.99, 'Carnes', 50, '2025-02-28'),
('Tomates', 'Tomates frescos, perfectos para ensaladas o cocinar', 2.00, 'Verduras', 150, '2025-03-15'),
('Cereal de avena', 'Cereal de avena, saludable para el desayuno', 3.00, 'Cereales', 200, '2025-09-01'),
('Jugo de naranja', 'Jugo natural de naranja, fresco y sin azúcar añadida', 2.50, 'Bebidas', 180, '2025-01-10');

-- Agregar columna imagen a la tabla productos
ALTER TABLE productos ADD COLUMN imagen VARCHAR(255);

-- Actualizar las imágenes de los productos
UPDATE productos SET imagen = 'https://statics-cuidateplus.marca.com/cms/platanos_0.jpg' WHERE id = 1;
UPDATE productos SET imagen = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQTQfbi36UWCMSLh-AIUZGixqjrbmPdySybtg&s' WHERE id = 2;
UPDATE productos SET imagen = 'https://www.infobae.com/resizer/v2/27HIZC22HVGVTIFRDKAKWIE7IY.jpg?auth=2d73895ebb5bc9e50d263e9be7c1008e906f64952e81af4074b3f7f0d7e6db42&smart=true&width=350&height=197&quality=85' WHERE id = 3;
UPDATE productos SET imagen = 'https://www.infobae.com/resizer/v2/BXHYVKXWTVFC5O7QNNH3LXF32A.jpg?auth=b819a8d08570203c26eed5bd9c4267f02c466eab3f9ee194e87f5dfa808d4817&smart=true&width=1200&height=1200&quality=85' WHERE id = 4;
UPDATE productos SET imagen = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQmR-ZvhN5pMSEIrVKHP71Y7GhE7RZxvJZ3nQ&s' WHERE id = 5;
UPDATE productos SET imagen = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTflZ6FIcyxN-dTvDbDGUyEdqAuhNBCwqdKww&s' WHERE id = 6;
UPDATE productos SET imagen = 'https://www.avicolaramavi.com/wp-content/webp-express/webp-images/uploads/2024/05/pollo-1.png.webp' WHERE id = 7;
UPDATE productos SET imagen = 'https://e00-elmundo.uecdn.es/assets/multimedia/imagenes/2024/03/07/17098165627875.jpg' WHERE id = 8;
UPDATE productos SET imagen = 'https://www.nestle-cereals.com/ec/sites/g/files/qirczx961/files/styles/1_1_768px_width/public/2023-02/FITNESS%C2%AE%20ORIGINAL.png.webp?itok=0xhTmgEd' WHERE id = 9;
UPDATE productos SET imagen = 'https://mongos.com.ec/wp-content/uploads/2020/06/JUGO-NARANJA-SQUIZ.jpg' WHERE id = 10;