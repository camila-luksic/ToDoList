Prueba Técnica: Desarrollo de To-Do List

Este proyecto consiste en una aplicación **To-Do List** desarrollada con **Slim Framework**, **PHP**, **MySQL** y **Bootstrap 5**, corriendo en un entorno **XAMPP**.  
 Requisitos previos

- [XAMPP](https://www.apachefriends.org/es/download.html) (Apache + MySQL)
- [Composer](https://getcomposer.org/download/) (para instalar Slim Framework)
- Navegador web
- phpMyAdmin (incluido en XAMPP)

 **Instalación y configuración**

1. Clonar o copiar el proyecto dentro de la carpeta `htdocs` de XAMPP.  
   Ejemplo: 
   C:\xampp\htdocs\todoApp
2. Instalar dependencias con Composer:
composer require slim/slim:"^4.0"
composer require slim/psr7

3.Encender los servicios en XAMPP:
-Apache 
-MySQL 
**Configuración de puertos**

En este proyecto se usaron puertos personalizados por conflictos locales:

Apache → 8081

MySQL → 3307 

4.Configurar la base de datos:
Ingresar a phpMyAdmin
-Crear una base de datos:
CREATE DATABASE todo_app;
-Crear la tabla todos:
CREATE TABLE todos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  is_done TINYINT(1) DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
**Rutas del proyecto**
Front-End (interfaz con Bootstrap + AlertifyJS)
http://localhost:8081/todoApp/public/app.php

API REST (Slim Framework)
Base URL: http://localhost:8081/todoApp/public/todos

- GET /todos → Listar todas las tareas  
- POST /todos → Crear una nueva tarea  
- PUT /todos/{id} → Editar una tarea existente  
- DELETE /todos/{id} → Eliminar una tarea  


Eliminar tareas con un clic.

