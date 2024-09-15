# PageCraft Backend

Приложение можно запустить с помощью Docker:

```bash
docker compose up -d
```

или с помоцью Makefile:

```bash
make start
```

**Адрес приложения по умолчанию: [localhost:8080](http://localhost:8080)**

Порт можно отредактировать в файле `.env` (в `.env.example` - пример конфигурации)

## Управление

Доступные `make` команды и их аналоги:

-   `make start` - запустить бэкенд (`docker compose up -d`)
-   `make stop` - остановить бэкенд (`docker compose down`)
-   `make restart` - перезапустить бэкенд (`docker compose restart`)
-   `make logs` - просмотреть логи бэкенд (`docker compose logs -f backend`)
-   `make shell` - открыть терминал внутри контейнера бэкенд (`docker compose exec -it backend bash`)
-   `make test` - запустить тесты бэкенда (`docker exec -it backend php artisan test`)
-   `make migrate` - применить миграции бэкенда (`docker exec -it backend php artisan migrate --force`)
-   `make seed` - применить сиды бэкенда (`docker exec -it backend php artisan db:seed`)
-   `make pint` - запустить Laravel Pint (`docker exec -it backend ./vendor/bin/pint`)
-   `make larastan` - запустить Laravel Stan (`docker exec -it backend ./vendor/bin/phpstan analyse`)
-   `make helper` - запустить Laravel Helper

```bash
docker exec -it backend php artisan ide-helper:generate && \
docker exec -it backend php artisan ide-helper:meta && \
docker exec -it backend php artisan ide-helper:models -W && \
./vendor/bin/pint
```
