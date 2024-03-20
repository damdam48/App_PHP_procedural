<?php

session_start();

require_once '/app/requests/users.php';

// Vérification de l'envoie des données
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    // Nettoyer les données
    $email = strip_tags($_POST['email']);

    $user = findOneUserByEmail($email);

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'firstName' => $user['firstName'],
            'lastName' => $user['lastName'],
            'roles' => json_decode($user['roles'] ? $user['roles'] : '["ROLE_USER"]'),
        ];
    } else {
        $errorMessage = 'Indentifiants invalides';
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter | My first app PHP</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>
    <?php include_once '/app/Layout/header.php'; ?>
    <main>
        <section class="container">
            <form action="/login.php" method="POST">
                <h1 class="text-center">Se connecter</h1>
                <?php if (isset($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <?= $errorMessage; ?>
                    </div>
                <?php endif; ?>
                <div class="group-input">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="group-input">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary">Se connecter</button>
                </div>
            </form>
        </section>
    </main>
</body>

</html>