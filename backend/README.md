# PageCraft Backend

The application can be started with Docker by executing the following command:

```bash
docker compose up -d
```

Or using Makefile:

```bash
make start
```

**Default application address: [localhost:8080](http://localhost:8080)**

The port can be edited in the `.env` file (`.env.example` is an example configuration)

## Management

Available `make` commands and their analogues:

-   `make start` - start the backend (`docker compose up -d`)
-   `make stop` - stop the backend (`docker compose down`)
-   `make restart` - restart the backend (`docker compose restart`)
-   `make logs` - view the backend logs (`docker compose logs -f backend`)
-   `make shell` - open a terminal in the backend container (`docker compose exec -it backend bash`)
-   `make test` - run the backend tests (`docker exec -it backend php artisan test`)
-   `make migrate` - apply the backend migrations (`docker exec -it backend php artisan migrate --force`)
-   `make seed` - apply the backend seeds (`docker exec -it backend php artisan db:seed`)
-   `make pint` - run Laravel Pint (`docker exec -it backend ./vendor/bin/pint`)
-   `make larastan` - run Laravel Stan (`docker exec -it backend ./vendor/bin/phpstan analyse`)
-   `make helper` - run Laravel Helper

```bash
docker exec -it backend php artisan ide-helper:generate && \
docker exec -it backend php artisan ide-helper:meta && \
docker exec -it backend php artisan ide-helper:models -W && \
./vendor/bin/pint
```
