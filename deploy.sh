#!/bin/bash

# Script de Deploy para Préstamos Tool
# Ejecutar en el servidor de producción

set -e

echo "📦 Iniciando deploy de Préstamos Tool..."

# 1. Actualizar código
echo "📥 Actualizando código..."
git pull origin main

# 2. Instalar dependencias PHP
echo "📚 Instalando dependencias PHP..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# 3. Configurar variables de entorno
echo "⚙️ Configurando variables de entorno..."
if [ ! -f .env ]; then
    cp .env.production .env
    php artisan key:generate
fi

# 4. Instalar dependencias Node
echo "📦 Instalando dependencias Node..."
npm ci

# 5. Compilar assets
echo "🏗️ Compilando assets..."
npm run build

# 6. Limpiar caché
echo "🧹 Limpiando caché..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 7. Ejecutar migraciones
echo "📊 Ejecutando migraciones..."
php artisan migrate --force

# 8. Establecer permisos correctos
echo "🔐 Estableciendo permisos..."
chown -R www-data:www-data .
chmod -R 775 storage bootstrap/cache

echo "✅ ¡Deploy completado exitosamente!"
echo "🌐 Accede a tu aplicación en: https://tudominio.com"
