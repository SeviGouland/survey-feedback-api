# Survey Feedback API

## Project Overview

This is a backend API built with **Laravel 12** and **PHP 8.3.14**. It allows users to view surveys, get questions, submit answers (with JWT authentication), and retrieve responder details.

It is intended for web or mobile applications to collect customer feedback post-transaction.

---

## Tech Stack

PHP 8.3.14

Laravel 12

MySQL

JWT Authentication via tymon/jwt-auth

Eloquent ORM

Rate limiting per IP

Logging survey submissions to JSON file

Postman collection included

---

## Setup Instructions

After cloning the repository, run the following commands to set up the project:

1. **Install dependencies**  
   composer install

2. **Run migrations**
   php artisan migrate

3 **Seed the database with dummy surveys and questions**
php artisan db:seed

---

## Authentication

-   ### 1. Register a new responder

-   **Endpoint:** `POST /api/register`
-   **Description:** Creates a new responder account.
-   **Example request body json:**
    {
    "email": "user@example.com",
    "password": "secret123",
    "password_confirmation": "secret123"
    }

-   **2. Login to get JWT token**
-   **Endpoint:** `POST /api/login` → Returns JWT token.

-   **3. Use the token for protected routes**
    Authorization: Bearer <your-jwt-token>

Protected endpoints require the token in the `Authorization` header:

Protected endpoints:

-   `POST /api/surveys/{id}/submit`
-   `GET /api/me`

---

## API Endpoints

| Endpoint                   | Method | Auth | Description                             |
| -------------------------- | ------ | ---- | --------------------------------------- |
| `/api/surveys`             | GET    | No   | List all active surveys                 |
| `/api/surveys/{id}`        | GET    | No   | Get survey details with questions       |
| `/api/surveys/{id}/submit` | POST   | Yes  | Submit answers to a survey              |
| `/api/me`                  | GET    | Yes  | Get current logged-in responder details |

---

## Logging Submissions

All submissions (success or failure) are logged to:

survey-feedback-api/
├─ storage/
│ ├─ app/
│ ├─ private/
│ └─ survey_submissions.json

---

## Postman Collection

You can find the Collection:

survey-feedback-api/
├─ postman/
│ ├─ survey_feedback_endpoints.postman_collection.json
│

---

## .env

The following changes were made in the `.env` file for the application:

-   **JWT_SECRET** – Set the secret key for JWT authentication.
-   **Rate Limiting**:
    -   `SUBMIT_SURVEY_LIMIT=5` – Limit for survey submissions per minute per IP.
    -   `ME_LIMIT=10` – Limit for `/me` endpoint requests per minute per IP.
-   **SESSION_DRIVER** – Changed to `file` because JWT is used for stateless authentication, so the database sessions table is not required.
