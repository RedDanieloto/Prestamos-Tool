-- Script SQL para crear la base de datos en producción
-- Ejecutar con: mysql -u root -p < setup-db.sql

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS prestamos_tool 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Crear usuario
CREATE USER IF NOT EXISTS 'prestamos_user'@'localhost' 
IDENTIFIED BY 'ChangeThisPassword123!';

-- Otorgar permisos
GRANT ALL PRIVILEGES ON prestamos_tool.* 
TO 'prestamos_user'@'localhost';

-- Aplicar cambios
FLUSH PRIVILEGES;

-- Mostrar resultado
SELECT 'Base de datos y usuario creados exitosamente' AS resultado;
