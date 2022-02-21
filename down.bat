@echo off

 
cmd /k docker compose -f docker-compose.yaml -p project down --volumes --rmi all

exit