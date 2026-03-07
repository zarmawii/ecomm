@echo off

echo Starting Python AI Server...
start cmd /k "cd python-api && py predict_api.py"

timeout /t 5

echo Starting Laravel Server...
start cmd /k "php artisan serve"

echo Project Started!
pause