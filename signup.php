<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/includes/init.php';
require_guest();

$page_title = 'Create Account';

$errors = [];

$firstName = '';
$lastName = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    verify_csrf();

    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($firstName === '') {
        $errors[] = 'First name is required.';
    }

    if ($lastName === '') {
        $errors[] = 'Last name is required.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if (strlen($password) < 8) {
        $errors[] = 'Password must contain at least 8 characters.';
    }

    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {

        try {

            $pdo = get_database_connection();

            $check = $pdo->prepare(
                'SELECT id FROM users WHERE email = :email LIMIT 1'
            );

            $check->execute([
                'email' => $email
            ]);

            if ($check->fetch()) {

                $errors[] =
                    'An account with this email address already exists.';

            } else {

                $passwordHash = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                $statement = $pdo->prepare(
                    'INSERT INTO users
                    (first_name, last_name, email, password_hash)
                    VALUES
                    (:first_name, :last_name, :email, :password_hash)'
                );

                $statement->execute([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'password_hash' => $passwordHash,
                ]);

                set_flash(
                    'success',
                    'Your account has been created successfully. Please log in.'
                );

                redirect(BASE_URL . '/login.php');
            }

        } catch (PDOException $e) {

            $errors[] =
                'Unable to create the account at this time.';
        }
    }
}

require_once __DIR__ . '/includes/header.php';

?>

<div class="form-container">

    <div class="form-card">

        <h1>Create Account</h1>

        <p class="form-introduction">
            Register for the BRAC Sierra Leone authentication portal.
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

                <label for="first_name">
                    First Name
                </label>

                <input
                    type="text"
                    id="first_name"
                    name="first_name"
                    value="<?= e($firstName) ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label for="last_name">
                    Last Name
                </label>

                <input
                    type="text"
                    id="last_name"
                    name="last_name"
                    value="<?= e($lastName) ?>"
                    required
                >

            </div>

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
                    minlength="8"
                >

            </div>

            <div class="form-group">

                <label for="confirm_password">
                    Confirm Password
                </label>

                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    required
                    minlength="8"
                >

            </div>

            <button
                type="submit"
                class="btn btn-primary btn-full"
            >
                Create Account
            </button>

        </form>

        <p class="form-footer">

            Already have an account?

            <a href="<?= e(BASE_URL) ?>/login.php">
                Login here
            </a>

        </p>

    </div>

</div>

<?php

require_once __DIR__ . '/includes/footer.php';

?>
