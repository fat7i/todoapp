# Todo API

## Project Setup Guide

### 1. Clone the Project
Clone the project repository to your local machine.

### 2. Project Setup
By running the following command, you will:
- Build Docker Image.
- Start Containers.
- Install the project dependencies.
- Set up the database.
- Add some test data.
````
   ./setup.sh
````

### 3. Navigate to the Application:
Open your web browser and navigate to:

http://localhost:8080/api/todos?page=1&limit=10

---
### API Documentation:
1. The API documentation can be found [here](workspace/config/api/todo_api.yaml)
2. Postman collection can be found [here](Todo%20API.postman_collection.json)

---
### Running Tests
To run tests, follow these steps:

1. Access your PHP Docker container:
   ````
   docker exec -it php bash
   ````

2. Run PHPUnit tests:
   ````
   php vendor/bin/phpunit
    ````

Have a Query? Feel free to reach me out on [iam.mohamed.f.ali@gmail.com](mailto:iam.mohamed.f.ali@gmail.com)
