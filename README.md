
# Proyecto PHP con PostgreSQL

Este proyecto es una aplicación web desarrollada en PHP utilizando PostgreSQL como base de datos. A continuación, se detallan las instrucciones para instalar y configurar el proyecto tanto utilizando Docker como de manera manual.


## Requisitos

- PHP: 8.1
- Base de Datos: PostgreSQL 13
- Docker (Para instalar con contenedores)


## Instalación del Proyecto

### Configuración de la Base de Datos

El archivo de script SQL `init_script.sql` se encuentra en la carpeta `sql/` en la raíz del proyecto. Este archivo contiene las instrucciones necesarias para la creación de tablas y la inserción de datos iniciales en la base de datos PostgreSQL

```text
sql/
└── init_script.sql
```

### Despliegue de la Aplicación

1.- Clonar el repositorio:
   
```bash
git clone https://github.com/Mathi03/registro-productos-php.git
cd registro-productos-php
```

2.- Configurar el archivo .env:

Crea un archivo .env en la raíz del proyecto con las siguientes variables:

```bash
POSTGRES_DB=nombre_de_tu_base_de_datos
POSTGRES_USER=tu_usuario
POSTGRES_PASSWORD=tu_contraseña

PGADMIN_DEFAULT_EMAIL=admin@admin.com
PGADMIN_DEFAULT_PASSWORD=admin
```

3.- Levantar los contenedores:

Ejecuta el siguiente comando para construir y levantar los contenedores:

```bash
docker-compose up --build
```
Esto creará y configurará automáticamente la base de datos PostgreSQL y la aplicación PHP.

4.- Acceder a la aplicación:

Una vez que los contenedores estén en funcionamiento, puedes acceder a la aplicación desde tu navegador en http://localhost:8080.

5.- Acceder a PgAdmin:

PgAdmin estará disponible en http://localhost:8081 para gestionar la base de datos PostgreSQL.

## Tecnologías Utilizadas

- PHP: Versión 8.1
- PostgreSQL: Versión 13
- Docker: Para despliegue y contenedorización de la aplicación
- PgAdmin: Para gestión de la base de datos

