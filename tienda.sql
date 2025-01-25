CREATE DATABASE tienda;
USE tienda;

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255),
    descripcion TEXT,
    precio DECIMAL(10, 2),
    categoria VARCHAR(100),
    stock INT,
    fecha_vencimiento DATE
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    direccion VARCHAR(255),
    telefono VARCHAR(50)
);


CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2),
    metodo_pago VARCHAR(50),
    direccion_envio VARCHAR(255),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);


CREATE TABLE detalles_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT,
    producto_id INT,
    cantidad INT,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);

CREATE TABLE reseñas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT,
    usuario_id INT,
    comentario TEXT,
    calificacion INT CHECK (calificacion BETWEEN 1 AND 5),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (producto_id) REFERENCES productos(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE facturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT,
    fecha_emision TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2),
    metodo_pago VARCHAR(50),
    direccion_envio VARCHAR(255),
    estado VARCHAR(50) DEFAULT 'Pendiente',  -- 'Pendiente', 'Pagada', etc.
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id)
);

CREATE USER 'grupo4'@'localhost' IDENTIFIED BY 'password321';
GRANT ALL PRIVILEGES ON tienda.* TO 'grupo4'@'localhost';
FLUSH PRIVILEGES;

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


INSERT INTO reseñas (producto_id, usuario_id, comentario, calificacion) VALUES
(1, 1, 'Excelente calidad, los plátanos llegaron muy frescos.', 5),
(2, 2, 'El yogur es delicioso, pero esperaba que fuera más cremoso.', 4),
(3, 3, 'Los huevos son frescos, aunque algunos estaban rotos.', 3),
(4, 4, 'El pan integral tiene un sabor muy agradable y fresco.', 5),
(5, 5, 'La pasta de tomate está bien, pero no es muy concentrada.', 4),
(6, 6, 'El aceite de oliva es excelente para ensaladas.', 5),
(7, 7, 'El pollo fresco tenía un buen tamaño, aunque le faltaba limpieza.', 4),
(8, 8, 'Tomates de buena calidad, perfectos para mis recetas.', 5),
(9, 9, 'El cereal de avena es delicioso y saludable.', 5),
(10, 10, 'El jugo de naranja tiene buen sabor, aunque le falta dulzura.', 4);

INSERT INTO usuarios (nombre, email, password, direccion, telefono) VALUES
('Juan Pérez', 'juan.perez@example.com', 'password123', 'Calle 1, Ciudad A', '0987654321'),
('Ana García', 'ana.garcia@example.com', 'password456', 'Avenida B, Ciudad B', '0976543210'),
('Luis Torres', 'luis.torres@example.com', 'password789', 'Calle C, Ciudad C', '0965432109'),
('María López', 'maria.lopez@example.com', 'password101', 'Boulevard D, Ciudad D', '0954321098'),
('Carlos Rojas', 'carlos.rojas@example.com', 'password202', 'Avenida E, Ciudad E', '0943210987'),
('Sofía Gómez', 'sofia.gomez@example.com', 'password303', 'Calle F, Ciudad F', '0932109876'),
('Miguel Ramírez', 'miguel.ramirez@example.com', 'password404', 'Calle G, Ciudad G', '0921098765'),
('Laura Sánchez', 'laura.sanchez@example.com', 'password505', 'Calle H, Ciudad H', '0910987654'),
('Daniel Fernández', 'daniel.fernandez@example.com', 'password606', 'Avenida I, Ciudad I', '0909876543'),
('Carmen Martínez', 'carmen.martinez@example.com', 'password707', 'Calle J, Ciudad J', '0898765432');


ALTER TABLE productos
ADD COLUMN createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE reseñas ADD COLUMN createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE reseñas ADD COLUMN updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE pedidos
ADD COLUMN createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE detalles_pedido
ADD COLUMN createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE facturas ADD COLUMN createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE facturas ADD COLUMN updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

select * from productos;
/*select * from productos;
SELECT * FROM productos WHERE id = 2;

select * from pedidos;
select * from detalles_pedido;

select * from facturas;
*/

ALTER TABLE productos
productosADD imagen VARCHAR(255);

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
/*
INSERT INTO productos (nombre,imagen, descripcion, precio, categoria, stock, fecha_vencimiento) VALUES
('Plátanos','https://statics-cuidateplus.marca.com/cms/platanos_0.jpg', 'Plátanos maduros, ideales para un snack saludable', 1.20, 'Frutas', 120, '2025-05-15'),
('Yogur natural','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQTQfbi36UWCMSLh-AIUZGixqjrbmPdySybtg&s','Yogur sin azúcar, excelente opción para el desayuno', 1.80, 'Lácteos', 180, '2025-03-01'),
('Huevos', 'https://www.infobae.com/resizer/v2/27HIZC22HVGVTIFRDKAKWIE7IY.jpg?auth=2d73895ebb5bc9e50d263e9be7c1008e906f64952e81af4074b3f7f0d7e6db42&smart=true&width=350&height=197&quality=85', 'Huevos frescos, ideales para tus recetas diarias', 2.40, 'Lácteos', 250, '2025-02-20'),
('Pan integral','https://www.infobae.com/resizer/v2/BXHYVKXWTVFC5O7QNNH3LXF32A.jpg?auth=b819a8d08570203c26eed5bd9c4267f02c466eab3f9ee194e87f5dfa808d4817&smart=true&width=1200&height=1200&quality=85', 'Pan integral de trigo, fresco y saludable', 1.50, 'Panadería', 200, '2025-01-30'),
('Pasta de tomate','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQmR-ZvhN5pMSEIrVKHP71Y7GhE7RZxvJZ3nQ&s', 'Pasta de tomate natural, ideal para salsas y recetas italianas', 1.00, 'Conservas', 150, '2025-11-01'),
('Aceite de oliva', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTflZ6FIcyxN-dTvDbDGUyEdqAuhNBCwqdKww&s', 'Aceite de oliva extra virgen, ideal para cocinar y aderezar', 4.50, 'Aceites y vinagres', 100, '2025-06-10'),
('Pollo fresco', 'https://www.avicolaramavi.com/wp-content/webp-express/webp-images/uploads/2024/05/pollo-1.png.webp','Pechugas de pollo frescas, para preparar tus platillos favoritos', 5.99, 'Carnes', 50, '2025-02-28'),
('Tomates', 'https://e00-elmundo.uecdn.es/assets/multimedia/imagenes/2024/03/07/17098165627875.jpg','Tomates frescos, perfectos para ensaladas o cocinar', 2.00, 'Verduras', 150, '2025-03-15'),
('Cereal de avena', 'https://www.nestle-cereals.com/ec/sites/g/files/qirczx961/files/styles/1_1_768px_width/public/2023-02/FITNESS%C2%AE%20ORIGINAL.png.webp?itok=0xhTmgEd','Cereal de avena, saludable para el desayuno', 3.00, 'Cereales', 200, '2025-09-01'),
('Jugo de naranja', 'https://mongos.com.ec/wp-content/uploads/2020/06/JUGO-NARANJA-SQUIZ.jpg','Jugo natural de naranja, fresco y sin azúcar añadida', 2.50, 'Bebidas', 180, '2025-01-10')
*/
