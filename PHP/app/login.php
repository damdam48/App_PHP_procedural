<?php

session_start();

require_once '/app/requests/users.php';

// Verification de la soumission du formulaire
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    // Nettoyage des données
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    // validation des contraintes ou ajout logique algo
    if ($email) {
        $user = findOneUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // On connecte l'utilisateur (tableau assossiatif)

            $_SESSION['user'] = [
                'id' => $user['id'],
                'firstName' => $user['firstName'],
                'lastName' => $user['lastName'],
                'email' => $user['email'],
                'roles' => json_decode($user['roles'] ?: '["ROLE_USER"]')
            ];

            http_response_code(302);
            header('Location: /');
            exit();
        } else {
            $errorMessage = "idendifiants invalides";
        }
    } else {
        $errorMessage = "Veuillez renseigner un email valide";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter | My first app PHP</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>
    <?php require_once '/app/layout/header.php' ?>

    <main>

        <?php require_once '/app/layout/flash.php' ?>

        <section class="container">
            <h1 class="text-center mt-2">Se connecter</h1>
            <form action="/login.php" method="POST" class="card">

                <?php if (isset($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <?= $errorMessage; ?>
                    </div>
                <?php endif; ?>

                <div class="group-input mt-2">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" placeholder="roberto@gmail.com" required>
                </div>
                <div class="group-input">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" placeholder="test1234" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </div>
            </form>
        </section>



    </main>

</body>

</html>