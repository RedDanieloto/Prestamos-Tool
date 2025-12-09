#!/bin/bash

# Script de Desempaquetado en Servidor de Producción
# Ejecutar esto en el servidor después de subir el archivo

set -e

INSTALL_PATH="/var/www"
PROJECT_NAME="Prestamos-Tool"
ARCHIVE_FILE="Prestamos-Tool-production.tar.gz"

echo "======================================"
echo "  Instalador - Préstamos Tool v1.0"
echo "======================================"

# Verificar que el archivo existe
if [ ! -f "$ARCHIVE_FILE" ]; then
    echo "❌ Error: No se encuentra $ARCHIVE_FILE"
    echo "📍 Asegúrate de ejecutar este script en el directorio donde está el archivo."
    exit 1
fi

# Crear directorio si no existe
if [ ! -d "$INSTALL_PATH/$PROJECT_NAME" ]; then
    echo "📁 Creando directorio de instalación..."
    sudo mkdir -p "$INSTALL_PATH/$PROJECT_NAME"
fi

# Desempaquetar
echo "📦 Desempaquetando archivos..."
sudo tar -xzf "$ARCHIVE_FILE" -C "$INSTALL_PATH/"

cd "$INSTALL_PATH/$PROJECT_NAME"

# Crear carpetas necesarias
echo "📁 Creando carpetas necesarias..."
sudo mkdir -p storage/app/private
sudo mkdir -p storage/app/public
sudo mkdir -p storage/framework/cache
sudo mkdir -p storage/framework/sessions
sudo mkdir -p storage/framework/testing
sudo mkdir -p storage/framework/views
sudo mkdir -p storage/logs

# Instalar dependencias PHP
echo "📚 Instalando dependencias PHP..."
sudo composer install --no-interaction --prefer-dist --optimize-autoloader

# Instalar dependencias Node
echo "📦 Instalando dependencias Node..."
sudo npm ci

# Compilar assets
echo "🏗️  Compilando assets..."
sudo npm run build

# Configurar permisos
echo "🔐 Configurando permisos..."
sudo chown -R www-data:www-data .
sudo chmod -R 775 storage bootstrap/cache
sudo chmod -R 755 public

# Crear .env
echo "⚙️  Configurando variables de entorno..."
if [ ! -f .env ]; then
    sudo cp .env.production .env
    sudo chown www-data:www-data .env
    sudo chmod 600 .env
    
    # Generar clave
    sudo -u www-data php artisan key:generate
    
    echo ""
    echo "⚠️  IMPORTANTE: Editar el archivo .env con tus valores:"
    echo "   APP_URL=https://tudominio.com"
    echo "   DB_HOST=localhost"
    echo "   DB_DATABASE=prestamos_tool"
    echo "   DB_USERNAME=prestamos_user"
    echo "   DB_PASSWORD=tu_contraseña"
    echo ""
    echo "Ejecuta: sudo nano .env"
    echo ""
fi

echo ""
echo "======================================"
echo "✅ Pre-instalación completada!"
echo "======================================"
echo ""
echo "📋 Siguientes pasos:"
echo "1. Editar .env: sudo nano .env"
echo "2. Crear BD: mysql -u root -p < setup-db.sql"
echo "3. Ejecutar migraciones: sudo -u www-data php artisan migrate --force"
echo "4. Ejecutar seeders: sudo -u www-data php artisan db:seed --force"
echo "5. Optimizar: sudo -u www-data php artisan optimize"
echo ""
echo "📞 Para más ayuda, revisa DEPLOYMENT.md"
