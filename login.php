<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/includes/init.php';

require_guest();

$page_title = 'Login';

$errors = [];

$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    verify_csrf();

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ($password === '') {
        $errors[] = 'Password is required.';
    }

    if (empty($errors)) {

        try {

            $pdo = get_database_connection();

            $statement = $pdo->prepare(
                'SELECT
                    id,
                    first_name,
                    last_name,
                    email,
                    password_hash,
                    created_at
                 FROM users
                 WHERE email = :email
                 LIMIT 1'
            );

            $statement->execute([
                'email' => $email
            ]);

            $user = $statement->fetch();

            if (
                $user &&
                password_verify(
                    $password,
                    $user['password_hash']
                )
            ) {

                login_user($user);

                set_flash(
                    'success',
                    'Login successful. Welcome back, ' .
                    $user['first_name'] . '!'
                );

                redirect(BASE_URL . '/dashboard.php');

            } else {

                $errors[] =
                    'The email address or password is incorrect.';
            }

        } catch (PDOException $e) {

            $errors[] =
                'Unable to process your login at this time.';
        }
    }
}

require_once __DIR__ . '/includes/header.php';

?>

<div class="form-container">

    <div class="form-card">

        <h1>Login</h1>

        <p class="form-introduction">
            Enter your account details to continue.
        </p>

        <?php if (!empty($errors)): ?>

            <div class="alert alert-error">

                <ul>

                    <?php foreach ($errors as $error): ?>

                        <li><?= e($error) ?></li>

                    <?php endforeach; ?>

                </ul>

            </div>

        <?php endif; ?>

        <form method="POST" action="">

            <?= csrf_field() ?>

            <div class="form-group">

                <label for="email">
                    Email Address
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?= e($email) ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >

            </div>

            <button
                type="submit"
                class="btn btn-primary btn-full"
            >
                Login
            </button>

        </form>

        <p class="form-footer">

            Don't have an account?

            <a href="<?= e(BASE_URL) ?>/signup.php">
                Create an account
            </a>

        </p>

    </div>

</div>

<?php

require_once __DIR__ . '/includes/footer.php';

?>