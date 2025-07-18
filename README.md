# CMS API

This is a CMS API built with Laravel and MySQL.

## Features

- User authentication with roles: Admin and Author (seeded).
- Login and logout APIs using Laravel Sanctum.
- CRUD APIs for articles with fields:
  - title
  - slug (AI-generated asynchronously using LLM)
  - content
  - summary (AI-generated asynchronously using LLM)
  - categories (multiple)
  - status (Draft, Published, Archived)
  - published date
  - author
- Only Admins can manage categories.
- Article listing with filters: category, status, and date range.
- Role-based access: Admins manage all content, Authors manage only their own content.
- Asynchronous slug and summary generation using an LLM service (e.g., OpenAI or Gemini API).

## Setup

1. Clone the repository.
2. Run `composer install` to install dependencies.
3. Copy `.env.example` to `.env` and configure your database and LLM API keys.
4. Run migrations and seeders:
   ```
   php artisan migrate --seed
   ```
5. Run the queue worker for async jobs:
   ```
   php artisan queue:work
   ```
6. Start the Laravel development server:
   ```
   php artisan serve
   ```

## Authentication

- Use the `/login` API to obtain an API token.
- Include the token in the `Authorization` header as `Bearer {token}` for authenticated requests.
- Use the `/logout` API to revoke tokens.

## LLM Integration

- The app uses an LLM service to generate article slugs and summaries asynchronously.
- Configure your LLM API keys in the `.env` file.
- The job `GenerateSlugAndSummaryJob` dispatches requests to the LLM service.

## API Documentation

- A Postman collection is included at `cms-api-app/cms-api/postman/cms-api.postman_collection.json`.
- Import it into Postman to test all APIs.

## Roles and Permissions

- Admin: Can manage all articles and categories.
- Author: Can manage only their own articles.

## Filters

- Articles can be filtered by category, status, and published date range.

## Notes

- Ensure the queue worker is running to process slug and summary generation jobs.
- Categories are managed only by Admin users.
