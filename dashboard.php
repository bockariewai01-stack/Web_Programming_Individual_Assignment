<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/includes/init.php';

require_login();

$page_title = 'Dashboard';

$user = current_user();

require_once __DIR__ . '/includes/header.php';

?>

<section class="dashboard">

    <div class="dashboard-header">

        <h1>
            Welcome, <?= e($user['first_name'] ?? '') ?>!
        </h1>

        <p>
            You have successfully logged into the
            BRAC Sierra Leone Authentication System.
        </p>

    </div>

    <div class="dashboard-card">

        <h2>Account Information</h2>

        <div class="account-information">

            <div class="account-item">

                <strong>First Name</strong>

                <span>
                    <?= e($user['first_name'] ?? '') ?>
                </span>

            </div>

            <div class="account-item">

                <strong>Last Name</strong>

                <span>
                    <?= e($user['last_name'] ?? '') ?>
                </span>

            </div>

            <div class="account-item">

                <strong>Email Address</strong>

                <span>
                    <?= e($user['email'] ?? '') ?>
                </span>

            </div>

            <div class="account-item">

                <strong>Account Created</strong>

                <span>
                    <?= e($user['created_at'] ?? '') ?>
                </span>

            </div>

        </div>

    </div>

    <div class="dashboard-actions">

        <a
            href="<?= e(BASE_URL) ?>/logout.php"
            class="btn btn-primary"
        >
            Logout
        </a>

    </div>

</section>

<?php

require_once __DIR__ . '/includes/footer.php';

?>