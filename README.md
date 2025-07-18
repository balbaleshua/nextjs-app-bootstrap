# CMS Application API with AI-Powered Features

This project is a Laravel-based CMS API application enhanced with AI-powered features.

## Features
- Article and Category management
- User authentication and authorization
- AI-powered content generation and slug creation
- Database migrations and seeders included
- RESTful API endpoints for integration

## Setup Instructions
1. Clone the repository
2. Run `composer install` to install dependencies
3. Configure your `.env` file with database and API keys
4. Run database migrations and seeders:
   ```
   php artisan migrate
   php artisan db:seed
   ```
5. Start the development server:
   ```
   php artisan serve
   ```

## API Endpoints
- `/api/articles` - Manage articles
- `/api/categories` - Manage categories
- `/api/auth` - Authentication endpoints

## Testing
Run feature and unit tests with:
```
php artisan test
```

## License
This project is open source and available under the MIT License.
