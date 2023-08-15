# Simpsons API Backend Docker Setup

- This repository contains a Dockerized setup for running the Simpsons API backend developed in Laravel.
- Solution architecture and Postman collections are included in [documents](/documents)
## Prerequisites

Before you begin, ensure you have the following installed:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Getting Started

1. Clone this repository:
2. Build and run the Docker containers:
   ```shell
   docker-compose build
   docker-compose up -d
   ```
3. Install Laravel dependencies:
    ```shell
    docker-compose exec app composer install
   ```

## Usage

- To access the Simpsons API backend, navigate to [/api/quotes](http://localhost:8000) in your web browser.
- Register new user with your name and password by accessing [/api/register](http://localhost:8000/api/register) using a POST request. Provide the credentials in the request body as JSON:
```json
  {
  "name": "user1",
  "email": "user@mail.de",
  "password": "p1"
  }
```
- Authenticate with your name and password by accessing [/api/login](http://localhost:8000/api/login) using a POST request.

- To fetch new quotes from the Simpsons API and store them in the database, run:
   ```shell
   docker-compose exec app php artisan quotes:fetch
   ```
- To retrieve quotes, access the following endpoint: [/api/quotes](http://localhost:8000/api/quotes)

## Shutting Down
To stop the Docker container, run:
   ```shell
   docker-compose stop container_id
   ```
To stop and remove the Docker containers, run:
   ```shell
   docker-compose down
   ```
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
