# Docker run

1. Поднять контейнеры:
   ```bash
   docker compose up -d --build
   ```

2. Установить зависимости и подготовить `.env`:
   ```bash
   docker compose exec app composer install
   cp .env.example .env
   docker compose exec app php artisan key:generate
   ```

3. Накатить миграции и открыть проект:
   ```bash
   docker compose exec app php artisan migrate
   ```
   Сайт: `http://127.0.0.1:10102`  
