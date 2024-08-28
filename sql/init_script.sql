CREATE TABLE bodegas (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

CREATE TABLE sucursales (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    bodega_id INT REFERENCES bodegas(id)
);

CREATE TABLE monedas (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

CREATE TABLE productos (
    id SERIAL PRIMARY KEY,
    codigo VARCHAR(15) UNIQUE NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    bodega_id INT REFERENCES bodegas(id),
    sucursal_id INT REFERENCES sucursales(id),
    moneda_id INT REFERENCES monedas(id),
    precio DECIMAL(10, 2) NOT NULL,
    descripcion TEXT NOT NULL
);

CREATE TABLE materiales (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

CREATE TABLE producto_material (
    producto_id INT REFERENCES productos(id),
    material_id INT REFERENCES materiales(id),
    PRIMARY KEY (producto_id, material_id)
);


-- Insertar datos en la tabla bodegas
INSERT INTO bodegas (nombre) VALUES 
('Bodega Central'),
('Bodega Norte'),
('Bodega Sur');

-- Insertar datos en la tabla sucursales
INSERT INTO sucursales (nombre, bodega_id) VALUES 
('Sucursal A', 1),
('Sucursal B', 1),
('Sucursal C', 2),
('Sucursal D', 3);

-- Insertar datos en la tabla monedas
INSERT INTO monedas (nombre) VALUES 
('Dólar'),
('Euro'),
('Peso'),
('Libra');

-- Insertar datos en la tabla materiales
INSERT INTO materiales (nombre) VALUES 
('Material A'),
('Material B'),
('Material C'),
('Material D');
