<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="users.css" />
    <title>LOG IN</title>
</head>

<body>
    <header>
        <img src="img/logo.png" alt="logo" />
        <?php
        require_once('nav.php');
        ?>
        <?php
        session_start();
        session_destroy();
        ?>
    </header>
    <main>
        <main>
            <section class="logout-section">
                <p>You have been successfully logged out.</p>
                <p>Thank you for using YOMA</p>
            </section>
        </main>