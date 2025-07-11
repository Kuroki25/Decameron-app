

# Hoteles Decamerón

> Sistema de gestión hotelera desacoplado:  
> **Back-end** en Laravel 10 + PostgreSQL  
> **Front-end** en Next.js + React + TypeScript

---

## 📋 Descripción

Hoteles Decamerón es una aplicación para que un gerente:
- Cree, liste, edite y elimine hoteles.
- Defina tipos de habitación y acomodaciones.
- Asigne configuraciones (tipo + acomodación + cantidad) a cada hotel con validaciones de capacidad y unicidad.
- Visualice el progreso de configuración de sus hoteles.

---

## 🔧 Requisitos

- **Back-end**  
  - PHP ≥ 8.2  
  - Composer  
  - PostgreSQL ≥ 12  
- **Front-end**  
  - Node.js ≥ 18  
  - npm o yarn  
- Opcionalmente Docker si prefieres contenerizar.

---

## 📁 Estructura del proyecto
backend/
├── app/
│ ├── Console/
│ ├── Exceptions/
│ ├── Http/
│ │ ├── Controllers/
│ │ │ ├── AcomodacionController.php
│ │ │ ├── HotelController.php
│ │ │ ├── HotelTipoAcomodacionController.php
│ │ │ └── TipoHabitacionController.php
│ │ └── Middleware/
│ └── Models/
│ ├── Acomodacion.php
│ ├── Hotel.php
│ ├── HotelTipoAcomodacion.php
│ └── TipoHabitacion.php
├── bootstrap/
├── config/
├── database/
│ ├── factories/
│ ├── migrations/
│ │ ├── yyyy_mm_dd_create_hoteles_table.php
│ │ ├── yyyy_mm_dd_create_tipos_habitacion_table.php
│ │ ├── yyyy_mm_dd_create_acomodaciones_table.php
│ │ └── yyyy_mm_dd_create_hotel_tipo_acomodacion_table.php
│ └── seeders/
│ ├── AcomodacionesTableSeeder.php
│ ├── HotelesTableSeeder.php
│ └── TiposHabitacionTableSeeder.php
├── public/
├── routes/
│ └── api.php
├── storage/
├── tests/
└── .env.example

﻿## Decameron App

---
 
## Crea archivo env
 cp .env.example .env

En local en produccion o staging agrega las credenciales de la base de datos del servicio que este utilizando render, railway etc.

DB_CONNECTION=pgsql
DB_HOST=tu_host
DB_PORT=5432
DB_DATABASE=tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

---

## Genera la clave de la aplicación
- composer install --optimize-autoloader

## Genera la clave de la aplicación
- php artisan key:generate

## Ejecuta migraciones y seeders
- php artisan migrate --seed

## Levanta el servidor local
- php artisan serve --host=0.0.0.0 --port=8000


---

## rutas API
GET	    /api/hoteles
POST	/api/hoteles
GET	    /api/hoteles/{hotel}
PUT	    /api/hoteles/{hotel}
DELETE	/api/hoteles/{hotel}
POST	/api/hoteles/{hotel}/asignaciones
DELETE	/api/hoteles/{hotel}/asignaciones/{asignacion}
GET	    /api/tipos-habitacion
POST	/api/tipos-habitacion
PUT	    /api/tipos-habitacion/{tipo_habitacion}
DELETE	/api/tipos-habitacion/{tipo_habitacion}
GET	    /api/acomodaciones
POST	/api/acomodaciones
PUT	    /api/acomodaciones/{acomodacione}
DELETE	/api/acomodaciones/{acomodacione}


---

## Ver estado de migraciones
php artisan migrate:status

## Rollback últimas migraciones
php artisan migrate:rollback

## Limpiar caché de configuración
php artisan config:clear

## Ejecutar tests
