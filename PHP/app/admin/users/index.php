<?php

session_start();

require_once '/app/utils/isAdminphp';

require_once '/app/requests/users.php';

// var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrateur | My first app PHP</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>
    <?php require_once '/app/layout/header.php' ?>
    <main>
        <?php require_once '/app/layout/flash.php' ?>

        <section class="container mt-2">
            <h1 class="text-center">Adminnistration des users</h1>
        </section>





        <!-- <?php var_dump(password_hash('test1234', PASSWORD_ARGON2I)); ?> -->
    </main>

</body>

</html>