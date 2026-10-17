<?php

declare(strict_types=1);

function is_logged_in(): bool
{
    return isset($_SESSION['user'])
        && is_array($_SESSION['user']);
}

function current_user(): ?array
{
    if (!is_logged_in()) {
        return null;
    }

    return $_SESSION['user'];
}

function require_login(): void
{
    if (!is_logged_in()) {

        set_flash(
            'error',
            'Please log in before accessing your dashboard.'
        );

        redirect(
            BASE_URL . '/login.php'
        );
    }
}

function require_guest(): void
{
    if (is_logged_in()) {

        redirect(
            BASE_URL . '/dashboard.php'
        );
    }
}

function login_user(array $user): void
{
    session_regenerate_id(true);

    $_SESSION['user'] = [
        'id' => (int) $user['id'],
        'first_name' => (string) $user['first_name'],
        'last_name' => (string) $user['last_name'],
        'email' => (string) $user['email'],
        'created_at' => (string) (
            $user['created_at'] ?? ''
        ),
    ];
}

function logout_user(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {

        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
}