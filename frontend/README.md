# PageCraft Frontend

Приложение можно запустить как с помощью Docker:

```bash
docker compose up -d
```

так и без него:

```bash
npm install && npm run dev
```

**Стартовая страница приложения по умолчанию: [welcome](http://localhost:3000/welcome)**

Порт фронтенда можно отредактировать в файле `.env` (в `.env.example` - пример конфигурации)

## Управление

Доступные `make` команды и их аналоги:

-   `make start` - запустить фронтенд (`docker compose up -d`)
-   `make stop` - остановить фронтенд (`docker compose down`)
-   `make restart` - перезапустить фронтенд (`docker compose restart`)
-   `make logs` - просмотреть логи фронтенда (`docker compose logs -f frontend`)
-   `make shell` - открыть терминал внутри контейнера фронтенда (`docker exec -it frontend sh`)
