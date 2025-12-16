# PUSPA REST API

A comprehensive REST API for managing therapy assessments and observations for children with special needs. Built with Laravel 10 and Laravel Sanctum for authentication.

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Installation](#installation)
- [API Documentation](#api-documentation)
- [Authentication](#authentication)
- [User Roles](#user-roles)
- [Endpoints](#endpoints)
- [Rate Limiting](#rate-limiting)
- [Error Handling](#error-handling)
- [Contributing](#contributing)
- [License](#license)

## Overview

PUSPA REST API is a backend system designed to facilitate the management of therapy assessments and observations for children requiring specialized care. The system supports multiple user roles including owners, administrators, therapists, assessors, and parents/guardians.

## Features

- **Multi-Role Access Control**: Owner, Admin, Therapist, Assessor, and Parent roles
- **Authentication & Authorization**: Email verification, password reset, and role-based access
- **Assessment Management**: Schedule, track, and complete various types of assessments
- **Observation Tracking**: Manage therapy observations and schedules
- **Parent Portal**: Parents can manage children profiles and view assessment results
- **File Management**: Upload and download assessment reports
- **Dashboard Analytics**: Role-specific dashboards with relevant statistics
- **Rate Limiting**: Built-in API rate limiting for security

## Tech Stack

- **Framework**: Laravel 10.x
- **PHP Version**: ^8.1
- **Authentication**: Laravel Sanctum
- **Role Management**: Spatie Laravel Permission
- **API Documentation**: L5-Swagger (Swagger/OpenAPI)
- **HTTP Client**: Guzzle
- **Testing**: PHPUnit, Mockery

## Installation

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL/PostgreSQL
- Node.js & NPM (for frontend assets if needed)

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/Ar1veeee/puspa-rest-api.git
   cd puspa-rest-api
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   Edit `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=puspa_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Seed roles and permissions** (if seeders are configured)
   ```bash
   php artisan db:seed
   ```

7. **Create storage symlink**
   ```bash
   php artisan storage:link
   ```

8. **Start development server**
   ```bash
   php artisan serve
   ```

The API will be available at `http://localhost:8000`

## API Documentation

API documentation is available via Swagger UI. After installation, visit:

```
http://localhost:8000/api/documentation
```

To regenerate API docs:
```bash
php artisan l5-swagger:generate
```

## Authentication

### Registration
Parents can register via the `/registration` endpoint. Staff members (Admin, Therapist) must be created by administrators.

### Login
```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password123"
}
```

**Response:**
```json
{
  "token": "1|abc123...",
  "user": {
    "id": "01H2X...",
    "name": "John Doe",
    "role": "user"
  }
}
```

### Email Verification
- New users must verify their email address
- Verification link is sent upon registration
- Resend verification available at `/auth/resend-verification/{user}`

### Password Reset
1. Request reset: `POST /auth/forgot-password`
2. Receive reset link via email
3. Reset password: `POST /auth/reset-password`

### Authenticated Requests
Include the bearer token in all authenticated requests:
```http
Authorization: Bearer 1|abc123...
```

## User Roles

The API uses **Spatie Laravel Permission** package for role and permission management, providing flexible and scalable access control.

| Role | Description | Key Permissions |
|------|-------------|-----------------|
| **Owner** | System owner | Manage all staff, promote users to assessor, activate/deactivate accounts |
| **Admin** | Administrator | Manage users, schedule assessments, update observations, view all data |
| **Therapist (Terapis)** | Therapy provider | Submit observations, view schedules, update profile |
| **Assessor (Asesor)** | Assessment specialist | Conduct assessments, submit reports, manage assessment schedules |
| **Parent (User)** | Child guardian | Register children, complete parent assessments, view reports |

### Role Assignment

Roles are assigned using Spatie's permission system:

```php
// Assign role to user
$user->assignRole('admin');

// Check if user has role
if ($user->hasRole('admin')) {
    // User is an admin
}

// Check multiple roles
if ($user->hasAnyRole(['admin', 'owner'])) {
    // User is either admin or owner
}
```

### Middleware Protection

Routes are protected using Spatie's role middleware:

```php
Route::middleware(['role:admin'])->group(function () {
    // Admin only routes
});

Route::middleware(['role:admin,owner'])->group(function () {
    // Admin or Owner routes
});
```

## Endpoints

### Public Endpoints

#### Authentication
- `POST /registration` - Parent registration
- `POST /auth/register` - User registration
- `POST /auth/login` - User login
- `GET /auth/email-verify/{id}/{hash}` - Verify email
- `POST /auth/resend-verification/{user}` - Resend verification email
- `POST /auth/forgot-password` - Request password reset
- `POST /auth/reset-password` - Reset password

### Authenticated Endpoints

#### Global (All Roles)
- `POST /auth/logout` - Logout user
- `GET /auth/protected` - Test protected route
- `PUT /profile/update-password` - Update password

#### Owner Role

**Dashboard**
- `GET /owners/dashboard` - Owner dashboard statistics

**Staff Management**
- `GET /users/{type}/unverified` - List unverified staff (admin/therapist)
- `GET /users/{user}/promote-to-assessor` - Promote therapist to assessor
- `GET /users/{user}/activate` - Activate user account
- `GET /users/{user}/deactive` - Deactivate user account

#### Owner & Admin Roles

**User Management**
- `GET /admins` - List all administrators
- `GET /admins/{admin}` - Get admin details
- `GET /therapists` - List all therapists
- `GET /therapists/{therapist}` - Get therapist details
- `GET /children` - List all children
- `GET /children/{child}` - Get child details

#### Admin Role

**Dashboard**
- `GET /admins/dashboard/stats` - Dashboard statistics
- `GET /admins/dashboard/today-schedule` - Today's therapy schedule

**Profile**
- `GET /admins/profile` - Get admin profile
- `POST /admins/{admin}/profile` - Update admin profile

**Admin Management**
- `POST /admins` - Create new admin
- `PUT /admins/{admin}` - Update admin
- `DELETE /admins/{admin}` - Delete admin

**Therapist Management**
- `POST /therapists` - Create new therapist
- `PUT /therapists/{therapist}` - Update therapist
- `DELETE /therapists/{therapist}` - Delete therapist

**Child Management**
- `PUT /children/{child}` - Update child information

**Observation Management**
- `PUT /observations/{observation}` - Update observation date
- `PUT /observations/{observation}/agreement` - Assessment agreement

**Assessment Management**
- `GET /assessments/{status}/admin` - List assessments by status (scheduled/completed)
  - Query params: `date`, `search`

#### Admin, Therapist & Assessor Roles

**Observations**
- `GET /observations/{status}` - List observations by status (pending/scheduled/completed)
  - Query params: `date`, `search`
- `GET /observations/{observation}/detail` - Get observation details
  - Query params: `type` (scheduled/completed/question/answer)

#### Therapist & Assessor Roles

**Dashboard**
- `GET /asse-thera/dashboard` - Dashboard statistics
- `GET /asse-thera/upcoming-schedules` - Upcoming schedules

**Profile**
- `GET /asse-thera/profile` - Get profile
- `POST /asse-thera/{therapist}/profile` - Update profile

**Observations**
- `POST /observations/{observation}/submit` - Submit observation

#### Admin & Assessor Roles

**Assessments**
- `PATCH /assessments/{assessment}` - Update assessment date
- `GET /assessments/{assessment}/detail` - Get assessment details
- `POST /assessments/{assessment}/report-upload` - Upload assessment report
- `GET /assessments/{assessment}/answer/{type}` - Get assessment answers
  - Types: `paedagog_assessor`, `wicara_assessor`, `fisio_assessor`, `okupasi_assessor`, `umum_parent`, `wicara_parent`, `paedagog_parent`, `okupasi_parent`, `fisio_parent`

#### Assessor Role

**Assessments**
- `GET /assessments/{status}` - List assessments by status (scheduled/completed)
  - Query params: `date`, `search`
- `GET /assessments/{type}/question` - Get assessor questions by type
  - Types: `paedagog`, `wicara_oral`, `wicara_bahasa`, `fisio`, `okupasi`, `parent_general`, `parent_wicara`, `parent_paedagog`, `parent_okupasi`, `parent_fisio`
- `GET /assessments/{status}/parent` - List parent assessments (completed/pending)
  - Query params: `date`, `search`
- `POST /assessments/{assessment}/submit/{type}` - Submit assessor assessment
  - Types: `paedagog_assessor`, `wicara_assessor`, `fisio_assessor`, `okupasi_assessor`

#### Parent Role

**Dashboard**
- `GET /my/dashboard/stats` - Dashboard statistics
- `GET /my/dashboard/chart` - Chart data
- `GET /my/dashboard/upcoming-schedules` - Upcoming schedules

**Profile**
- `GET /my/profile` - Get profile
- `POST /my/profile/{guardian}` - Update profile

**Children Management**
- `GET /my/children` - List children
- `GET /my/children/{child}` - Get child details
- `POST /my/children` - Add new child
- `PUT /my/children/{child}` - Update child

**Family Data**
- `PUT /my/identity` - Update family data (father, mother, guardian)

**Assessments**
- `GET /my/assessments` - List child assessments
- `GET /my/assessments/{type}/question` - Get parent questions by type
  - Types: `parent_general`, `parent_wicara`, `parent_paedagog`, `parent_okupasi`, `parent_fisio`
- `POST /my/assessments/{assessment}/submit/{type}` - Submit parent assessment
  - Types: `umum_parent`, `wicara_parent`, `paedagog_parent`, `okupasi_parent`, `fisio_parent`
- `GET /my/assessments/{assessment}/answer/{type}` - Get assessment answers
  - Types: `umum_parent`, `wicara_parent`, `paedagog_parent`, `okupasi_parent`, `fisio_parent`
- `GET /my/assessments/{assessment}/report-download` - Download assessment report
- `GET /my/assessments/{assessment}` - Get assessment details

## Rate Limiting

The API implements rate limiting to prevent abuse:

| Endpoint Category | Limit |
|-------------------|-------|
| Public API | Default throttle |
| Login | Custom login throttle |
| Registration | API throttle |
| Verification | Verification throttle |
| Forgot Password | Custom throttle |
| Reset Password | Custom throttle |
| Authenticated Routes | Authenticated throttle |
| Logout | Logout throttle |

## Error Handling

The API returns standard HTTP status codes:

| Status Code | Description |
|-------------|-------------|
| 200 | Success |
| 201 | Created |
| 400 | Bad Request |
| 401 | Unauthorized |
| 403 | Forbidden |
| 404 | Not Found |
| 422 | Validation Error |
| 429 | Too Many Requests |
| 500 | Internal Server Error |

**Error Response Format:**
```json
{
  "message": "Error description",
  "errors": {
    "field": ["Validation error message"]
  }
}
```

## Utility Endpoints

Development and debugging endpoints:

- `GET /cors-test` - Test CORS configuration
- `GET /test-paths` - Test file system paths
- `GET /clear-cache` - Clear application cache

**Note:** These should be disabled in production.

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

[Add your license here]

---

**Project Repository:** [https://github.com/Ar1veeee/puspa-rest-api](https://github.com/Ar1veeee/puspa-rest-api)

**Maintained by:** Ar1veeee