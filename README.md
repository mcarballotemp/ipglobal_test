# Prueba Tecnica para IpGlobal

## Puesta en marcha

Comenzamos clonando el repositorio

    git clone git@github.com:mcarballotemp/ipglobal_test.git

Arrancamos docker

    docker-compose up -d

Al terminar tenemos disponibles las siguientes urls:

Front: [http://localhost:8088/](http://localhost:8088/)

Api Swagger/OpenApi: [http://localhost:8088/api/doc](http://localhost:8088/api/doc)

### Si queremos desarrollar, o ejecutar los test

Arrancamos docker con el fichero especifico para dev

    docker-compose -f docker-compose.dev.yml up -d --force-recreate --build

Instalamos las dependencias

    docker-compose exec phpfpm composer install

## Comandos disponibles

Dejo listo un pequeño Makefile con los siguientes comandos:

PhpStan:

    make phpstan
	docker-compose exec phpfpm composer phpstan

CsFix:

    make csfix
	docker-compose exec phpfpm composer csfix

Testing, pudiendo ejecutar por separado unitarios y funcionales

    make test
	docker-compose exec phpfpm composer test

    make testunit
	docker-compose exec phpfpm composer test-unit

    make testfunc
	docker-compose exec phpfpm composer test-func


## Descripcion de la prueba

Se ha aplicado SOLID y arquitectura hexagonal al codigo en Backend.

## Mejoras a aplicar

- Autenticacion con JWT
- CQRS

