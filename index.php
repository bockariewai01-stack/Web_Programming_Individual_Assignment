<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/init.php';

require_guest();

$page_title = 'Home';

require_once __DIR__ . '/includes/header.php';

?>

<section class="hero">

    <div class="hero-content">

        <div class="logo-container">

            <img
                src="<?= e(BASE_URL) ?>/assets/images/brab-sierra-leone-logo.png"
                alt="BRAC Sierra Leone logo"
                class="logo"
            >

        </div>

        <p class="eyebrow">
            PHP & MySQL Authentication System
        </p>

        <h1>
            Welcome to the BRAC Sierra Leone Portal
        </h1>

        <p class="hero-description">
            A professional PHP and MySQL authentication system
            demonstrating secure registration, login, sessions,
            protected dashboard access and logout functionality.
        </p>

        <div class="button-group">

            <a
                href="<?= e(BASE_URL) ?>/signup.php"
                class="btn btn-primary"
            >
                Create Account
            </a>

            <a
                href="<?= e(BASE_URL) ?>/login.php"
                class="btn btn-secondary"
            >
                Login
            </a>

        </div>

    </div>

</section>

<section class="info-grid">

    <article class="info-card">

        <h2>Secure Registration</h2>

        <p>
            New users can create accounts using their
            first name, last name, email address and password.
        </p>

    </article>

    <article class="info-card">

        <h2>Secure Authentication</h2>

        <p>
            Passwords are securely hashed before being stored
            in the MySQL database.
        </p>

    </article>

    <article class="info-card">

        <h2>Protected Dashboard</h2>

        <p>
            Only authenticated users can access their personal
            dashboard.
        </p>

    </article>

</section>

<?php

require_once __DIR__ . '/includes/footer.php';

?>