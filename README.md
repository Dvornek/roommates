# Start Apache and MySQL Server

## Description
This project involves starting the Apache and MySQL servers and accessing the homepage of a restaurant website.

## Installation

1. Clone the repository to your local machine:

    ```bash
    git clone git@github.com:Dvornek/bizcode.git
    ```
2. Navigate to htdocs
    
3. Navigate to the project directory:

    ```bash
    cd bizcode/api/
    ```

4. Install Composer dependencies:

    ```bash
    composer install
    ```

    This command will download and install all the required dependencies listed in the `composer.json` file, including `symfony/dotenv` and `respect/validation`.

4. You're ready to start using the project!

## Testing API with Postman
- **URL:** `http://localhost/api/users`
- **Method:** `POST`
- **Body (RAW JSON) example:**
  {
    "email": "test@gmail.com",
    "password": "password123",
    "confirmPassword": "password123",
    "fname": "Gary",
    "lname": "Goe",
    "telephone": "0623525264"
  }