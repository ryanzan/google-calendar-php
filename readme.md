
# Calendar App

A simple application to manage Google Calendar events. This app allows you to list, create, and delete events using Google's OAuth2 authentication.

## Installation

1. **Configure Credentials:**  
   Update `config/credentials.json` with your Google API credentials.

2. **Set Configuration:**  
   Define `basePath` and `redirectUrl` in `config/app.php`.

3. **Install Dependencies:**  
   Run the following command to install required packages:
   ```bash
   composer install
   ```

## Running Locally with XAMPP

1. Place the project in the `htdocs` directory.
2. Access the app via your browser at:  
   `http://localhost/google-calendar-php/index.php`

## Running with Docker

1. **Update Configuration:**  
   Uncomment and update the `basePath` and `redirectUrl` in `config/app.php` as needed.

2. **Build Docker Image:**
   ```bash
   docker build -t calendar-app .
   ```

3. **Run Docker Container:**
   ```bash
   docker run -p 8000:80 calendar-app
   ```
