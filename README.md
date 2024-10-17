# Api de Tareas

## Descripción

Esta API permite a los usuarios crear, leer, actualizar y eliminar tareas.

## Funcionalidades

+ Los usuarios pueden registrarse y loguearse.
+ Los usuarios pueden crear, leer, actualizar y eliminar tareas.
+ Las tareas tienen los siguientes campos:
    - Título: El título de la tarea.
    - Descripción: Una descripción de la tarea.
    - Fecha de vencimiento: La fecha en la que la tarea vence.
    - Prioridad: La prioridad de la tarea (high, medium, low).
    - Estado: El estado de la tarea (pending, in_progress, completed, cancelled).
    - Las tareas deben estar ordenadas por fecha de vencimiento.
    - Los usuarios deben poder buscar tareas por título o descripción.
+ Las tareas estan ordenadas por fecha de vencimiento.
+ Los usuarios pueden buscar tareas por título o descripción.
## Reglas de negocio
+ Solo usuarios registrados pueden hacer operaciones sobre la api.
+ Los usuarios solo tienen permitido hacer las operaciones básicas (CRUD) sobre las tareas que **_ellos mismos creen_**.

## Pasos para ejecutar el proyecto
1. Descarga o clona el proyecto
2. Ejecuta el comando **`composer install`**
4. Copia en archivo **.env.example** y renombralo a **.env**
5. Edita las variables de entorno para la conexión a la base de datos
6. Ejecuta el comando **`php artisan key:generate`**
7. Ejecuta el comando **`php artisan migrate`**
8. Ejecuta el comnado **`php artisan serve`**
9. Visita la url [http://127.0.0.1:8000](http://127.0.0.1:8000)

## EndPoints
### Registrarse

* **Método:** POST
* **URL:** api/register
* **Descripción:** Registrarse para poder hacer las operaciones
* **Ejemplo de body de la solicitud:**
  ```json
    {
      "name": "Juan Pérez",
      "email": "juan@juan.com",
      "password": "123456789"
    },
* **Respuesta: código 201**
  ```json
    {
        "message": "User created satisfully",
        "user": {
            "name": "Juan Pérez",
            "email": "juan@juan.com",
            "updated_at": "xxxx-xx-xxT18:09:43.000000Z",
            "created_at": "xxxx-xx-xxT18:09:43.000000Z",
            "id": 3
        }
    }
### Loguearse
* **Método:** POST
* **URL:** api/login
* **Descripción:** Loguearse con el usuario creado para obtener el token de acceso

* **Ejemplo de body de la solicitud:**
  ```json
    {
      "email": "juan@juan.com",
      "password": "123456789"
    },
* **Respuesta: código 200**
  ```json
    {
        "user": {
            "id": 3,
            "name": "Juan Pérez",
            "email": "juan@juan.com",
            "email_verified_at": null,
            "created_at": "xxxx-xx-xxT18:09:43.000000Z",
            "updated_at": "xxxx-xx-xxT18:09:43.000000Z"
        },
        "token": "4|GnqThn8XirL15b3DpGBIEowOl4Jw8gdg0DzAsnus98cedf9c"

    }
* **Respuesta: código 401**
  ```json
    {
        "message": "Credentials incorrects"
    }

### Logout
* **Método:** GET
* **URL:** api/logout
* **Descripción:** Hacer logout e invalidar los tokens creados

### Crear tareas
* **Método:** POST
* **URL:** api/tasks
* **Descripción:** Crear una nueva tarea
* **Ejemplo de body de la solicitud: debe colocar el token de accesos como bearer token**
  ```json
    {
        "title": "Descargar pelicula de saw",
        "description": "Saw X ya salió y toca esperar a ver si sale para descargar",
        "deadline": "2023/10/29",
        "priority": "medium",
        "status": "pending"
    }
* **Respuesta: Código 201**
  ```json
    {
        "data": {
            "title": "Descargar pelicula de saw",
            "description": "Saw X ya salió y toca esperar a ver si sale para descargar",
            "deadline": "2023/10/29",
            "priority": "medium",
            "status": "pending",
            "user_id": 2,
            "updated_at": "xxxx-xx-xxT18:17:38.000000Z",
            "created_at": "xxxx-xx-xxT18:17:38.000000Z",
            "id": 5
        }
    }
* **Respuesta: Código 401**
  ```json
    {
        "message": "Unauthenticated."
    }

### Actualizar una tarea
* **Método:** POST
* **URL:** api/tasks/5
* **Descripción:** Actualizar la informacion de una tarea basado en el id que se le pase
* **Ejemplo de body de la solicitud: debe colocar el token de accesos como bearer token**
  ```json
    {
        "description": "Reestreno de la pelicula Saw por sus 20 años del lanzamiento de la primera pelicula"
    }

* **Respuesta: codigo 200**
  ```json
    {
        "message": "Task updated satisfully",
        "data": {
            "id": 5,
            "title": "Descargar pelicula de saw",
            "description": "Reestreno de la pelicula Saw por sus 20 años del lanzamiento de la primera pelicula",
            "deadline": "2023-10-29",
            "priority": "medium",
            "status": "pending",
            "user_id": 2,
            "created_at": "xxxx-xx-xxT18:17:38.000000Z",
            "updated_at": "xxxx-xx-xxT18:24:36.000000Z"
        }
    }
* **Respuesta: Código 404**
  ```json
    {
        "message": "Task Not Found"
    }
* **Respuesta: Código 401**

  ```json
    {
        "message": "Unauthenticated."
    }

### Mostrar una tarea
* **Método:** GET
* **URL:** api/tasks/5
* **Descripción:** Obtiene la información de una tarea en especifico, así como la información de la persona que la creó, que en este caso es la misma persona que hace la solicitud.
* **Ejemplo de body de la solicitud: debe colocar el token de accesos como bearer token. NO REQUIERE UN BODY**
* **Respuesta: código 200**
  ```json
  {
        "id": 5,
        "title": "Descargar pelicula de saw",
        "description": "Reestreno de la pelicula Saw por sus 20 años del lanzamiento de la primera pelicula",
        "deadline": "2023-10-29",
        "priority": "medium",
        "status": "pending",
        "user_id": 2,
        "created_at": "xxxx-xx-xxT18:17:38.000000Z",
        "updated_at": "xxxx-xx-xxT18:24:36.000000Z",
        "user": {
            "id": 2,
            "name": "Jean Carlos Trejo",
            "email": "test@test.com",
            "email_verified_at": null,
            "created_at": "xxxx-xx-xxT01:59:02.000000Z",
            "updated_at": "xxxx-xx-xxT01:59:02.000000Z"
        }
    }
* **Respuesta: Código 404**
  ```json
    {
        "message": "Task Not Found"
    }
    

### Eliminar una tarea
* **Método:** DELETE
* **URL:** api/tasks/5
* **Descripción:** Elimina la tarea que se le pase por parametro
* **Ejemplo de body de la solicitud: debe colocar el token de accesos como bearer token. NO REQUIERE UN BODY**
* **Respuesta: código de estado 200**

### Listar las tareas
* **Método:** GET
* **URL:** api/tasks
* **Descripción:** Listar todas las tareas que ha creado el usuario 
* **Ejemplo de body de la solicitud: debe colocar el token de accesos como bearer token. NO REQUIERE UN BODY**
* **Respuesta: código de estado 200**
  ```json
    {
        "data": [
            {
                "id": 3,
                "title": "Descargar pelicula de saw",
                "description": "Saw X ya salió y toca esperar a ver si sale para descargar",
                "deadline": "2023-10-29",
                "priority": "medium",
                "status": "pending",
                "user_id": 2,
                "created_at": "xxxx-xx-xxT02:30:02.000000Z",
                "updated_at": "xxxx-xx-xxT02:30:02.000000Z"
            },
            {
                "id": 6,
                "title": "Diseñar la base de datos",
                "description": "diseñar la base de datos que se utilizará en el proyecto, definiedno las entidades involucradas",
                "deadline": "xxxx-xx-xx",
                "priority": "high",
                "status": "pending",
                "user_id": 2,
                "created_at": "xxxx-xx-xxT18:36:45.000000Z",
                "updated_at": "xxxx-xx-xxT18:36:45.000000Z"
            }
        ]
    }
### Listar las tareas por campo de busqueda
* **Método:** GET
* **URL:** api/tasks?title=diseñar
* **Descripción:** Listar todas las tareas que ha creado el usuario buscando bien sea por el titulo o por la descripcion 
* **Ejemplo de body de la solicitud: debe colocar el token de accesos como bearer token. NO REQUIERE UN BODY**
* **Respuesta: código de estado 200**
  ```json
    {
        "data": [
            {
            "id": 6,
            "title": "Diseñar la base de datos",
            "description": "diseñar la base de datos que se utilizará en el proyecto, definiedno las entidades involucradas",
            "deadline": "2024-10-29",
            "priority": "high",
            "status": "pending",
            "user_id": 2,
            "created_at": "xxxx-xx-xxT18:36:45.000000Z",
            "updated_at": "xxxx-xx-xxT18:36:45.000000Z"
            }
        ]
    }
* **Respuesta: código de estado 404**
  ```json
    {
      "message": "No data"
    }