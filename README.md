Startup instructions:

Make mysql directory inside root project.

Navigate to src directory do composer install, copy .env.example into .env file, php artisan key:generate and php artisan jwt:secret commands.

Change host, database, username, password inside .env file to credentials matched inside docker-compose.yml and set DB_HOST=mysql

Run docker-compose build && docker-compose run

In case there is restricted file premission run docker exec -it apache chmod -R 777 /var/www command.

Run docker exec -it apache php artisan migrate

API Documentation along with postman collection are located inide root project
