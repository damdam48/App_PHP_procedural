<?php

session_start();

require_once '/app/requests/users.php';

// Vérification de la soumission des données
if (
    !empty($_POST['firstName']) &&
    !empty($_POST['lastName']) &&
    !empty($_POST['email']) &&
    !empty($_POST['password'])
) {
    // Nettoyage des données
    $firstName = strip_tags($_POST['firstName']);
    $lastName = strip_tags($_POST['lastName']);
    $email = strip_tags($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_ARGON2I);

    // Vérification des contraintes
    if (!findOneUserByEmail($email)) {
        // On envoie en BDD
        if (createUser($firstName, $lastName, $email, $password)) {
            // On redirige vers une autre page
            http_response_code(302);
            header('Location: /login.php');
            exit();
        } else {
            $errorMessage =  "Une erreur est survenue";
        }
    } else {
        $errorMessage = "Cet email est déjà utilisé par un autre compte";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire | My first app PHP</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>
    <?php include_once '/app/Layout/header.php'; ?>
    <main>
        <section class="container">
            <h1 class="text-center">S'inscrire</h1>
            <form action="/register.php" method="POST">
                <?php if (isset($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <?= $errorMessage; ?>
                    </div>
                <?php endif; ?>
                <div class="group-input">
                    <label for="firstName">Prénom:</label>
                    <input type="text" name="firstName" id="firstName" required placeholder="John">
                </div>
                <div class="group-input">
                    <label for="lastName">Nom:</label>
                    <input type="text" name="lastName" id="lastName" required placeholder="Doe">
                </div>
                <div class="group-input">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required placeholder="john@exemple.com">
                </div>
                <div class="group-input">
                    <label for="password">Mot de passe:</label>
                    <input type="password" name="password" id="password" required placeholder="S3CR3T">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">S'inscrire</button>
                </div>
            </form>
        </section>
    </main>
</body>

</html>