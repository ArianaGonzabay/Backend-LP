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

ALTER TABLE productos
ADD COLUMN createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

select * from productos;
SELECT * FROM productos WHERE id = 2;


