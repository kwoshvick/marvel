
## Marvel App

### Setup Instruction
- [Install docker](https://docs.docker.com/engine/install/)
- [Install docker compose](https://docs.docker.com/compose/install/)
- Clone the project
- Insider the project folder run:
- Run the containers
  - `docker-compose up -d `
- run migration
  - `docker exec marvel_app php artisan migrate`
- add queue
  - `docker exec marvel_app php artisan marvel-crawler --queued`
- run queue worker
  - `docker exec marvel_app php artisan queue:work --timeout=1800`

- Access the application via `{ip}:8010`
