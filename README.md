<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
aravel Blog API

This project is a Laravel-based API for managing a simple blog system. It utilizes Laravel framework, MariaDB for the database, Docker for containerization, and follows a Test-Driven Development (TDD) approach to ensure code quality and reliability.
Features

    CRUD operations for managing blog posts
    Authentication and authorization for users
    Validation of input data
    Unit and integration tests for ensuring code reliability

Requirements

    Docker
    Docker Compose
    MariaDB

Installation

    Clone the repository:

    bash

git clone https://github.com/yourusername/laravel-blog-api.git

Navigate to the project directory:

bash

cd laravel-blog-api

Copy the environment file:

bash

cp .env.example .env

Modify the .env file with your database settings:

env

DB_CONNECTION=mysql
DB_HOST=0.0.0.0
DB_PORT=3306
DB_DATABASE=BlogApi
DB_USERNAME=root
DB_PASSWORD=****

Build the Docker containers:

bash

docker-compose up -d --build

Install composer dependencies:

bash

docker-compose exec app composer install

Generate application key:

bash

docker-compose exec app php artisan key:generate

Run migrations and seeders:

bash

    docker-compose exec app php artisan migrate --seed

Usage

    Start the Docker containers if not already running:

    bash

    docker-compose up -d

    Access the API via http://localhost:8000.

    Use an API client like Postman or cURL to interact with the endpoints.

Testing

To run the tests, execute:

bash

docker-compose exec app php artisan test

This will run both unit and feature tests.
API Endpoints

    GET /api/posts: Get all blog posts.
    GET /api/posts/{id}: Get a specific blog post.
    POST /api/posts: Create a new blog post.
    PUT /api/posts/{id}: Update an existing blog post.
    DELETE /api/posts/{id}: Delete a blog post.

Authentication

Authentication is required for creating, updating, and deleting blog posts. You can obtain an access token by sending a POST request to /api/login with valid credentials. Use the token received in the response for subsequent requests by including it in the Authorization header as a Bearer token.
Contributing

Contributions are welcome! Feel free to fork the repository and submit pull requests for any improvements or bug fixes.
License

This project is licensed under the MIT License.
Acknowledgements

Special thanks to the Laravel community for providing excellent documentation and resources for building robust applications.
