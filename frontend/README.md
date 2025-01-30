# PageCraft Frontend

The application can be started with docker by running:

```bash
docker compose up -d
```

Or with npm:

```bash
npm install && npm run dev
```

**Default application start page: [welcome](http://localhost/welcome)**

The frontend port can be edited in the `.env` file (see `.env.example` for a configuration example)

## Management

Available `make` commands and their analogues:

-   `make start` - start the frontend (`docker compose up -d`)
-   `make stop` - stop the frontend (`docker compose down`)
-   `make restart` - restart the frontend (`docker compose restart`)
-   `make logs` - view frontend logs (`docker compose logs -f frontend`)
-   `make shell` - open a terminal inside the frontend container (`docker exec -it frontend sh`)
