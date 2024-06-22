#!/bin/bash

# Build Docker Image
docker build -t burda/php-fpm --build-arg USER_ID=$(id -u) --build-arg GROUP_ID=$(id -g) .

# Start Containers
docker compose up -d

# Install the project dependencies
docker exec -it php bash -c "composer install --no-interaction"

# Run the Doctrine migrations
docker exec -it php bash -c "php bin/console doctrine:migrations:migrate --no-interaction"

# Load the Doctrine fixtures
docker exec -it php bash -c "php bin/console doctrine:fixtures:load --no-interaction"
