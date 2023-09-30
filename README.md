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
