# INSTALACION #

Esta es una breve guia de pasos para correr la aplicacion como entorno de desarrollo.

1. Descarga e instalar Docker Desktop para la version de tu sistema operativo (https://www.docker.com/products/docker-desktop)

2. Abrir Docker Desktop.

2. Clonar este repositorio en algun directorio.

3. Entrar a este directorio con un terminal o interprete de comandos y ejecutar el comando

    `docker-compose up -d`

    Una vez que docker haya terminado de construir el build podras acceder a la aplicacion a traves de la URL http://localhost/

5. Cuando termines de desarrollar recuerda parar el servicio con 

    `docker-compose stop`

## Importante! ##

Recorda que si tenes instalado algun servicio sobre los puertos 80 (apache, nginx u otro servidor web) y 3306 (mysql) en tu computadora necesistaras frenar estos servicos previamente para que Docker pueda correr correctamente esta aplicacion.

# Comando para levantar un nuevo dump de la base #

`docker-compose stop; docker system prune --volumes; docker-compose up -d --build`

