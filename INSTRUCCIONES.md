# 🔧 Sistema de Gestión de Préstamos de Herramientas

Sistema interactivo para gestionar préstamos de herramientas a técnicos, construido con Laravel 11, Tailwind CSS, SortableJS y Driver.js.

## 🎯 Características

- **Dashboard Interactivo**: Asigna herramientas a técnicos usando drag & drop
- **CRUD de Técnicos**: Gestión completa de empleados técnicos
- **CRUD de Herramientas**: Gestión del inventario de herramientas
- **Préstamos con Seguimiento**: Registra y rastrea préstamos activos
- **Tutorial Integrado**: Guía interactiva con Driver.js
- **Interfaz Intuitiva**: Diseño limpio y fácil de usar con Tailwind CSS

## 📋 Requisitos

- PHP 8.2 o superior
- Composer
- Node.js y npm
- MySQL/PostgreSQL/SQLite

## 🚀 Instalación

1. **Clonar el repositorio e instalar dependencias de PHP:**
```bash
composer install
```

2. **Instalar dependencias de JavaScript:**
```bash
npm install
```

3. **Configurar el archivo de entorno:**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurar la base de datos en `.env`:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=prestamos_tool
DB_USERNAME=root
DB_PASSWORD=
```

5. **Ejecutar migraciones y seeders:**
```bash
php artisan migrate --seed
```

6. **Compilar assets:**
```bash
npm run build
# o para desarrollo con recarga automática:
npm run dev
```

7. **Iniciar el servidor:**
```bash
php artisan serve
```

Visita: http://localhost:8000

## 📖 Uso del Sistema

### Dashboard Principal (/)
- **Panel Izquierdo**: Muestra todas las herramientas disponibles
- **Panel Derecho**: Lista de técnicos activos
- **Asignar Préstamo**: Arrastra una herramienta desde el panel izquierdo y suéltala sobre un técnico
- **Tutorial**: Haz clic en "📖 Iniciar Tutorial" para ver una guía interactiva

### Gestión de Técnicos (/tecnicos)
- Crear nuevos técnicos con información de contacto
- Editar datos de técnicos existentes
- Activar/desactivar técnicos
- Eliminar técnicos del sistema

### Gestión de Herramientas (/herramientas)
- Registrar nuevas herramientas con código único
- Editar información de herramientas
- Cambiar estados: Disponible, Prestada, Mantenimiento
- Eliminar herramientas del inventario

### Préstamos Activos
- Ver todos los préstamos en curso
- Registrar devoluciones
- Consultar historial con notas

## 🛠️ Tecnologías Utilizadas

- **Backend**: Laravel 11
- **Frontend**: Blade Templates + Tailwind CSS 4
- **Drag & Drop**: SortableJS
- **Tutorial**: Driver.js
- **Base de Datos**: MySQL/PostgreSQL/SQLite
- **Build Tool**: Vite

## 📁 Estructura del Proyecto

```
app/
├── Http/Controllers/
│   ├── TecnicoController.php       # CRUD de técnicos
│   ├── HerramientaController.php   # CRUD de herramientas
│   └── PrestamoController.php      # Gestión de préstamos
└── Models/
    ├── Tecnico.php                 # Modelo de técnico
    ├── Herramienta.php             # Modelo de herramienta
    └── Prestamo.php                # Modelo de préstamo

resources/
├── views/
│   ├── layouts/app.blade.php       # Layout principal
│   ├── prestamos/index.blade.php   # Dashboard
│   ├── tecnicos/                   # Vistas CRUD técnicos
│   └── herramientas/               # Vistas CRUD herramientas
├── js/app.js                       # JavaScript principal
└── css/app.css                     # Estilos Tailwind

database/
├── migrations/                     # Migraciones de BD
└── seeders/DatabaseSeeder.php      # Datos de ejemplo
```

## 🎨 Características Especiales

### Drag & Drop con SortableJS
- Las herramientas se pueden arrastrar y soltar
- Clonación automática (la herramienta original permanece)
- Animaciones suaves de arrastre
- Feedback visual inmediato

### Tutorial con Driver.js
- 7 pasos guiados
- Resalta elementos interactivos
- Explicaciones contextuales
- Progreso visible

### Diseño Responsivo
- Funciona en desktop y tablet
- Grid adaptativo
- Componentes optimizados para móvil

## 🔄 Comandos Útiles

```bash
# Desarrollo con recarga automática
npm run dev

# Compilar para producción
npm run build

# Limpiar caché de Laravel
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Resetear base de datos
php artisan migrate:fresh --seed
```

## 📝 Notas Importantes

- Los técnicos deben estar **activos** para aparecer en el dashboard
- Las herramientas deben estar **disponibles** para poder asignarse
- Al asignar una herramienta, se puede agregar notas opcionales
- La devolución actualiza automáticamente el estado de la herramienta
- El tutorial se puede iniciar en cualquier momento

## 🐛 Solución de Problemas

**Las herramientas no se arrastran:**
- Verifica que los assets estén compilados: `npm run build`
- Revisa la consola del navegador para errores JavaScript

**Error en base de datos:**
- Verifica la configuración en `.env`
- Asegúrate que la BD existe: `CREATE DATABASE prestamos_tool;`

**Estilos no se aplican:**
- Limpia caché: `php artisan view:clear`
- Recompila assets: `npm run build`

## 📄 Licencia

Este proyecto es de código abierto y está disponible bajo la licencia MIT.
