<?php

session_start();
require_once '/app/utils/isAdmin.php';
require_once '/app/requests/users.php';

$user = findOneUserById(isset($_GET['id']) ? $_GET['id'] : 0);

if (!$user) {
    $_SESSION['messages']['danger'] = "User non trouvé";

    http_response_code(302);
    header('Location: /admin/users');
    exit();
}

var_dump($user);

// var_dump($_SERVER);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification d'un User | My first app PHP</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>
    <?php require_once '/app/layout/header.php' ?>

    <main>
        <section class="container">
            <h1 class="text-center mt-2">Modifier un User</h1>
            <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="POST" class="card">

                <?php if (isset($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <?= $errorMessage; ?>
                    </div>
                <?php endif; ?>

                <div class="group-input">
                    <label for="firstName">Prénom:</label>
                    <input type="text" name="firstName" id="firstName" placeholder="John" required>
                </div>
                <div class="group-input">
                    <label for="lastName">Nom:</label>
                    <input type="text" name="lastName" id="lastName" placeholder="Doe" required>
                </div>

                <div class="group-input mt-2">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" placeholder="roberto@gmail.com" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        </section>



    </main>

</body>

</html>