ReservasPro 
Sistema Inteligente de Reservas de Espacios

Proyecto final desarrollado en Laravel para la gestión moderna de reservas de salas, auditorios, laboratorios y espacios colaborativos.

Desarrollado por

Juanita Martínez Gutiérrez
Estudiante de Ingeniería en Informática

Proyecto académico — Framework Laravel para Desarrollo Web

Descripción general

ReservasPro es una plataforma web moderna e intuitiva que permite administrar reservas de espacios compartidos en tiempo real.

El sistema fue desarrollado con una arquitectura robusta utilizando Laravel, Jetstream, Inertia y Vue, ofreciendo una experiencia dinámica, responsive y profesional tanto para usuarios como administradores.

La aplicación permite:

Consultar disponibilidad de salas
Realizar reservas
Aprobar o rechazar solicitudes
Bloquear horarios
Gestionar espacios
Exportar información en PDF
Enviar correos automáticos
Visualizar estadísticas y calendario administrativo

Objetivo del proyecto

Desarrollar una solución web completa para la administración eficiente de espacios compartidos, optimizando el proceso de reservas mediante validaciones automáticas, disponibilidad en tiempo real y gestión administrativa centralizada.

Características principales
-  Módulo Usuario

Los usuarios autenticados pueden:

- Registrarse e iniciar sesión
- Recuperar contraseña vía correo electrónico
- Consultar salas disponibles
- Visualizar información detallada de cada espacio
- Ver capacidad y precios
- Consultar disponibilidad en tiempo real
- Realizar reservas
- Ver historial de reservas
- Descargar reservas en PDF
- Consultar calendario de reservas

 Módulo Administrador:

El administrador cuenta con un panel completo para:

- Gestionar salas mediante CRUD
- Crear, editar y eliminar espacios
- Aprobar reservas
- Rechazar reservas
- Cancelar reservas
- Bloquear horarios manualmente
- Ver estadísticas del sistema
- Visualizar calendario administrativo
- Gestionar disponibilidad
- Controlar usuarios y reservas

Gestión de disponibilidad:
- El sistema implementa validaciones avanzadas:

- Prevención de reservas solapadas
- Validación de horarios en backend
- Detección automática de conflictos
- Restricción de horarios bloqueados
- Control de disponibilidad por sala


Sistema de bloqueos

El administrador puede bloquear horarios específicos por:

- Mantenimiento
- Eventos internos
- Restricciones administrativas
- Uso exclusivo

Las reservas sobre horarios bloqueados son rechazadas automáticamente.

Sistema de correos automáticos

El proyecto integra Mailtrap para pruebas de envío de correos electrónicos.

Se envían notificaciones cuando:

- Se crea una reserva
- Una reserva es aprobada
- Una reserva es rechazada
- Una reserva es cancelada
- El usuario recupera su contraseña

Exportación PDF:
- Los usuarios y administradores pueden exportar reservas en formato PDF mediante DomPDF.

Incluye:
- Información de salas
- Fechas
- Horarios
- Estados de reserva
- Usuario responsable

Diseño UI/UX:
- El sistema cuenta con:

- Diseño responsive
- Interfaz moderna
- Dark mode
- Dashboard interactivo
- Navegación intuitiva
- Componentes dinámicos con Vue
- Experiencia fluida con Inertia.js

| Tecnología  | Uso                |
| ----------- | ------------------ |
| Laravel 12  | Backend            |
| PHP 8       | Lenguaje principal |
| MySQL       | Base de datos      |
| Vue 3       | Frontend           |
| Inertia.js  | SPA moderna        |
| Jetstream   | Autenticación      |
| TailwindCSS | Diseño UI          |
| Mailtrap    | Correos            |
| DomPDF      | Exportación PDF    |


Base de datos:
Entidades principales
- Space:
- Representa las salas o espacios disponibles.

- Reservation:
- Gestiona las reservas realizadas por usuarios.

- Availability:
- Controla la disponibilidad semanal de cada sala.

- BlockedSlot:
- Gestiona bloqueos manuales de horarios.

- User:
- Usuarios autenticados y administradores.

Roles del sistema:
- Administrador:
- Acceso total al sistema.

- Usuario:
- Acceso limitado a reservas y consultas.

nstalación del proyecto:
1️.Clonar repositorio
git clone URL_DEL_REPOSITORIO


2️. Entrar al proyecto
cd Proyecto_Final_Salas

3️. Instalar dependencias
composer install

npm install


4️. Configurar variables de entorno

Copiar archivo:
cp .env.example .env


5️. Generar clave de Laravel
php artisan key:generate

6️. Configurar base de datos

Editar .env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reservaspro
DB_USERNAME=root
DB_PASSWORD=


7️. Configurar Mailtrap
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=TU_USERNAME
MAIL_PASSWORD=TU_PASSWORD
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="reservaspro@gmail.com"
MAIL_FROM_NAME="ReservasPro"

8️. Ejecutar migraciones y seeders
php artisan migrate:fresh --seed

9️. Ejecutar backend
php artisan serve

10. Ejecutar frontend
npm run dev

 Usuarios de prueba
- Administrador
Correo: admin@gmail.com
Contraseña: Admin1234

Usuario
Correo: juanitamartinezgutierrez9@gmail.com
Contraseña: JuanitaM0108+ 

o también se puede crear un nuevo usuario desde el login.

| Funcionalidad                 | Estado |
| ----------------------------- | ------ |
| CRUD de salas                 | ✅      |
| Reservas                      | ✅      |
| Calendario                    | ✅      |
| Dashboard administrativo      | ✅      |
| Correos automáticos           | ✅      |
| Recuperación de contraseña    | ✅      |
| Exportación PDF               | ✅      |
| Bloqueo de horarios           | ✅      |
| Validación backend            | ✅      |
| Roles de usuario              | ✅      |
| Disponibilidad en tiempo real | ✅      |
| Diseño responsive             | ✅      |

Aprendizajes obtenidos:

Durante el desarrollo del proyecto se aplicaron conocimientos relacionados con:

Arquitectura MVC
Relaciones Eloquent
Middleware y autenticación
Componentes Vue
Validaciones backend
Gestión de estados
Integración de correos
Exportación de documentos
Diseño responsive
Desarrollo SPA con Inertia


Evidencias del sistema:
- El proyecto incluye evidencia funcional de:

- Consulta de disponibilidad
- Creación de reservas
- Correos automáticos
- Dashboard administrativo
- Calendario
- Gestión de estados
- Bloqueos de horarios
- Exportación PDF


eservasPro es una solución web completa y escalable que centraliza la gestión de reservas de espacios, automatizando procesos administrativos y mejorando la experiencia de usuario mediante tecnologías modernas y buenas prácticas de desarrollo.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
