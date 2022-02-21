@echo off

cmd /k docker compose -f ./docker-compose.yaml -p project up -d --renew-anon-volumes


exit