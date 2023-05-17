# WordPress Plugin Management System For Plugin Developers

This is a WordPress Plugin Management System built using the Laravel framework. It provides a comprehensive solution for plugin developers to manage their WordPress plugins efficiently.

## Features

- User registration and authentication system.
- Support ticket system for user inquiries and issue tracking.
- Plugin statistics and analytics on dashboard.

## Installation

1. Clone the repository:
   ```shell
   git clone https://github.com/your-username/wordpress-plugin-management-system.git
   ```

2. Navigate to the project directory:
   ```shell
   cd wordpress-plugin-management-system
   ```

3. Install the required dependencies:
   ```shell
   composer install
   ```

4. Create a new `.env` file by duplicating `.env.example`:
   ```shell
   cp .env.example .env
   ```

5. Generate a new application key:
   ```shell
   php artisan key:generate
   ```

6. Configure the database settings in the `.env` file.

7. Run the database migrations and seed the initial data:
   ```shell
   php artisan migrate --seed
   ```

8. Start the development server:
   ```shell
   php artisan serve
   ```

9. Access the application in your browser at `http://localhost:8000`.

## Usage

- Track plugin activities on user's system.
- Collect user's WordPress setup information automatically via api.
- Handle user support tickets and respond to user inquiries.
- Monitor plugin statistics and ratings to gain insights into plugin performance.

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvement, please open an issue or submit a pull request.

## License

This project is licensed under the [MIT License](LICENSE).
