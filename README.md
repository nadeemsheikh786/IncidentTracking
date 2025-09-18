# Incident Tracking System


## Quick Set Up

1) Create a fresh Laravel project (v11.x):
```bash
composer create-project laravel/laravel incidents
cd incidents
```

2) Copy **all folders** from this pack into your Laravel root, merging directories:
- `app/`, `routes/`, `database/`, `resources/`, `public/`, `.env.example` (optional override),

`bootstrap/app.php` (append note below)
add this dependency  
use App\Http\Middleware\EnsureUserHasRole;

inside withMiddleware function add below line

 
		$middleware->alias([
            'role' => EnsureUserHasRole::class,
        ]);
     

3) Configure `.env` (DB info). Then run:
```bash
php artisan migrate --seed
php artisan key:generate
php artisan serve
```

4) Login with seeded accounts:
- **Admin**: `admin@example.com` / password: `AdminPass@123`
- **Responder(s)**: `responder1@example.com` ... `responder4@example.com` / password: `ResponderPass@123`
- **User**: `user@example.com` / password: `UserPass@123`

## Features

- **Auth (manual):** Register/Login/Logout without Breeze/Jetstream
- **Roles:** `admin`, `responder`, `user`
- **Incidents:** CRUD (Create for users; Admin manages statuses/assignment; Responders can comment)
- **Statuses:** `open`, `in_progress`, `resolved`
- **Severity:** `low`, `medium`, `high`, `critical`
- **Search:** by title/description
- **Filters:** by severity/status; **sortable** columns
- **Comments:** AJAX post (with CSRF token), sanitized on input, escaped on render
- **Security:** FormRequest validation + sanitization, Blade escaping, CSRF

