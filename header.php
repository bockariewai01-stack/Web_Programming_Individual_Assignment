<?php

declare(strict_types=1);

$page_title = $page_title ?? APP_NAME;
$flash = get_flash();
$currentUser = current_user();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= e($page_title) ?> | <?= e(APP_NAME) ?>
    </title>

    <link
        rel="stylesheet"
        href="<?= e(BASE_URL) ?>/assets/css/style.css"
    >

</head>

<body>

<header class="site-header">

    <div class="container navbar">

        <a
            class="brand"
            href="<?= e(BASE_URL) ?>/"
        >
            <img
                src="<?= e(BASE_URL) ?>/assets/images/brac_sierra_leone_logo.png"
                alt="BRAC Sierra Leone Logo"
                class="brand-logo"
            >
        </a>

        <nav class="navigation">

            <?php if ($currentUser !== null): ?>

                <a href="<?= e(BASE_URL) ?>/dashboard.php">
                    Dashboard
                </a>

                <a href="<?= e(BASE_URL) ?>/logout.php">
                    Logout
                </a>

            <?php else: ?>

                <a href="<?= e(BASE_URL) ?>/login.php">
                    Login
                </a>

                <a href="<?= e(BASE_URL) ?>/signup.php">
                    Sign Up
                </a>

            <?php endif; ?>

        </nav>

    </div>

</header>

<main class="container">

    <?php if ($flash !== null): ?>

        <div class="alert alert-<?= e($flash['type'] ?? 'info') ?>">
            <?= e($flash['message'] ?? '') ?>
        </div>

    <?php endif; ?>