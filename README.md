# Simpsons API Backend Docker Setup

This repository contains a Dockerized setup for running the Simpsons API backend developed in Laravel.

## Prerequisites

Before you begin, ensure you have the following installed:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Getting Started

1. Clone this repository:
2. Build and run the Docker containers:
   ```shell
   docker-compose up -d
   ```
3. Install Laravel dependencies:
    ```shell
    docker-compose exec app composer install
   ```
4. Set up the database:
- Make sure the `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in the `.env` file match the values in the `docker-compose.yml` file.
5. Run migrations:
   ```shell
   docker-compose exec app php artisan migrate
   ```

## Usage

- To access the Simpsons API backend, navigate to [/api/quotes](http://localhost:8000) in your web browser.

- To fetch new quotes from the Simpsons API and store them in the database, run:
   ```shell
   docker-compose exec app php artisan quotes:fetch
   ```
- To retrieve quotes, access the following endpoint: [/api/quotes](http://localhost:8000/api/quotes)

## Shutting Down

To stop and remove the Docker containers, run:
   ```shell
   docker-compose down
   ```
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
