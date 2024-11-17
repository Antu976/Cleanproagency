@echo off
chcp 437 >nul
Setlocal EnableDelayedExpansion

rem Set the compose file and profile
set COMPOSE_FILE="./docker-compose.yml"
set PROFILE=--profile default

rem Set environment variables
set DAMP_DB_PORT=3306
set DAMP_WEB_PORT=8080
set DAMP_PMA_PORT=9090
set DAMP_HOME_DIRECTORY=./

rem Stop containers
docker compose -f %COMPOSE_FILE% %PROFILE% down

rem Start containers
docker compose -f %COMPOSE_FILE% %PROFILE% up -d

cls

echo --------------------------------
echo  DAMP - Docker Apache MySQL PHP 
echo --------------------------------
echo.
echo.
echo - MySQL : localhost:%DAMP_DB_PORT%
echo - HTTP / PHP : http://localhost:%DAMP_WEB_PORT%
echo - PhpMyAdmin : http://localhost:%DAMP_PMA_PORT%

echo.
echo.
echo ----------------------------------------
echo  Appuyez sur une touche pour quitter...
echo ----------------------------------------
pause >nul

docker compose -f %COMPOSE_FILE% %PROFILE% down
