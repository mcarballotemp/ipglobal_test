# Prueba Técnica para IpGlobal

## Puesta en Marcha

Comenzamos clonando el repositorio:

    git clone git@github.com:mcarballotemp/ipglobal_test.git

Arrancamos Docker:

    docker-compose up -d

Al terminar, tenemos disponibles las siguientes URLs:

Front: [http://localhost:8088/](http://localhost:8088/)

API Swagger/OpenAPI: [http://localhost:8088/api/doc](http://localhost:8088/api/doc)

#### Si Queremos Desarrollar o Ejecutar los Tests:

Arrancamos Docker con el fichero específico para desarrollo:

    docker-compose -f docker-compose.dev.yml up -d --force-recreate --build

Instalamos las dependencias:

    docker-compose exec phpfpm composer install
    docker-compose exec phpfpm npm install
    docker-compose exec phpfpm npm run build

## Comandos Disponibles

Dejo listo un pequeño Makefile con los siguientes comandos:

PhpStan:

    make phpstan
    docker-compose exec phpfpm composer phpstan

CsFix:

    make csfix
    docker-compose exec phpfpm composer csfix

Testing, pudiendo ejecutar por separado unitarios y funcionales:

    make test
    docker-compose exec phpfpm composer test

    make testunit
    docker-compose exec phpfpm composer test-unit

    make testfunc
    docker-compose exec phpfpm composer test-func

## Descripción de la Prueba

Se ha aplicado SOLID y Arquitectura Hexagonal al código en Backend. 

He utilizado como sustituto de la base de datos la opción de JsonPlaceholder.

Los endpoints disponibles en el API son los siguientes:

    GET  /api/blog/authors/{id}

    GET  /api/blog/posts
    POST /api/blog/posts
    GET  /api/blog/posts/{id}
    GET  /api/blog/posts/{id}/with/author

En cuanto al frontal, instalé Webpack Encore y Vue. 
Realicé de manera simple el frontal haciendo llamadas con axios a los endpoints anteriores.


## CI/CD

Añadido workflow simple para ejecutar phpstan y tests antes de realizar el merge de una PR.

## Mejoras a Aplicar

- Autenticación con JWT
- CQRS
- Cache
- Paginado y filtros con patron Criteria
