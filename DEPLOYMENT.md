# 📦 Guía de Despliegue a Producción - Préstamos Tool

## 🚀 Requisitos del Servidor

- **PHP 8.2+** con extensiones: curl, mbstring, pdo, pdo_mysql, gd, json
- **Composer** última versión
- **Node.js 18+** y npm
- **MySQL 5.7+** o MariaDB 10.2+
- **Git** para el control de versiones
- **OpenSSL** para certificados HTTPS

## 📋 Pasos de Instalación en Producción

### 1️⃣ Preparar el Servidor

```bash
# Conectarse al servidor
ssh usuario@tudominio.com

# Navegar a la carpeta de aplicaciones
cd /var/www

# Clonar el repositorio
git clone https://github.com/tuusuario/Prestamos-Tool.git
cd Prestamos-Tool

# Crear carpeta de permisos
sudo chown -R www-data:www-data .
chmod -R 775 storage bootstrap/cache
```

### 2️⃣ Configurar Variables de Entorno

```bash
# Copiar configuración de producción
cp .env.production .env

# Generar clave de aplicación (si no la tiene)
php artisan key:generate

# IMPORTANTE: Editar .env con tus valores reales
nano .env
```

**Variables a actualizar en `.env`:**
```env
APP_URL=https://tudominio.com
DB_HOST=localhost
DB_DATABASE=prestamos_tool
DB_USERNAME=prestamos_user
DB_PASSWORD=tu_contraseña_segura
MAIL_FROM_ADDRESS=noreply@tudominio.com
```

### 3️⃣ Instalar Dependencias

```bash
# PHP
composer install --no-interaction --prefer-dist --optimize-autoloader

# Node.js
npm ci
npm run build
```

### 4️⃣ Crear Base de Datos

```bash
# Acceder a MySQL
mysql -u root -p

# Crear usuario y base de datos
CREATE DATABASE prestamos_tool;
CREATE USER 'prestamos_user'@'localhost' IDENTIFIED BY 'tu_contraseña_segura';
GRANT ALL PRIVILEGES ON prestamos_tool.* TO 'prestamos_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 5️⃣ Ejecutar Migraciones

```bash
php artisan migrate --force
php artisan db:seed --force
```

### 6️⃣ Optimizar la Aplicación

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 7️⃣ Configurar Web Server (Nginx)

Crear archivo `/etc/nginx/sites-available/prestamos-tool`:

```nginx
server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name tudominio.com www.tudominio.com;
    
    # SSL
    ssl_certificate /etc/letsencrypt/live/tudominio.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/tudominio.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    
    root /var/www/Prestamos-Tool/public;
    index index.php;

    # Logs
    access_log /var/log/nginx/prestamos-tool.access.log;
    error_log /var/log/nginx/prestamos-tool.error.log;

    # Gzip
    gzip on;
    gzip_types text/plain text/css text/js application/json application/javascript;

    # Seguridad
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;

    # PHP
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
    }

    # Rewrite
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Estáticos
    location ~* ^/public/.*\.(?:css|js|jpg|jpeg|gif|png|webp|svg|ico|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}

# Redirigir HTTP a HTTPS
server {
    listen 80;
    listen [::]:80;
    server_name tudominio.com www.tudominio.com;
    return 301 https://$server_name$request_uri;
}
```

Habilitar el sitio:
```bash
sudo ln -s /etc/nginx/sites-available/prestamos-tool /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 8️⃣ Configurar SSL con Let's Encrypt

```bash
sudo apt-get install certbot python3-certbot-nginx
sudo certbot certonly --nginx -d tudominio.com -d www.tudominio.com
```

### 9️⃣ Configurar Supervisor para Queue (Opcional)

Crear `/etc/supervisor/conf.d/prestamos-tool.conf`:

```ini
[program:prestamos-tool-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/Prestamos-Tool/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
numprocs=4
redirect_stderr=true
stdout_logfile=/var/log/prestamos-tool-worker.log
```

## 🔄 Actualizaciones Futuras

Ejecutar el script automático:
```bash
cd /var/www/Prestamos-Tool
chmod +x deploy.sh
./deploy.sh
```

O manualmente:
```bash
git pull origin main
composer install --no-interaction
npm ci && npm run build
php artisan migrate --force
php artisan config:cache && php artisan route:cache
```

## 🛡️ Checklist de Seguridad

- [ ] `APP_DEBUG=false` en `.env`
- [ ] `APP_ENV=production` configurado
- [ ] Base de datos con usuario con permisos limitados
- [ ] HTTPS/SSL configurado
- [ ] Archivo `.env` con permisos 600 (no legible públicamente)
- [ ] Carpeta `storage/` con permisos correctos
- [ ] Backups automáticos configurados
- [ ] Logs rotados y monitoreados
- [ ] Firewall configurado (solo puertos 80, 443)
- [ ] Rate limiting habilitado para login

## 📊 Monitoreo Recomendado

```bash
# Ver logs
tail -f storage/logs/laravel.log

# Verificar estado del servidor
php artisan tinker
# Ejecutar: App\Models\Tecnico::count()
```

## 🆘 Solución de Problemas

**Error 500 - Storage sin permisos:**
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

**Migraciones sin ejecutar:**
```bash
php artisan migrate --force
php artisan view:clear
```

**Assets no se cargan:**
```bash
npm run build
php artisan view:cache
```

## 📞 Soporte

Para problemas, consulta:
- Logs: `storage/logs/laravel.log`
- Documentación Laravel: https://laravel.com/docs
- Issues del proyecto: GitHub repository

---

**¡Tu aplicación está lista para producción! 🚀**
