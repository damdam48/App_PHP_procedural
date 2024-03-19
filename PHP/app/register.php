<?php

session_start();

require_once '/app/requests/users.php';

// validation soumission du formulaire
if (
    !empty($_POST['firstName']) &&
    !empty($_POST['lastName']) &&
    !empty($_POST['email']) &&
    !empty($_POST['password'])
) {
    // nettoyage des données
    $firstName = strip_tags($_POST['firstName']);
    $lastName = strip_tags($_POST['lastName']);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_ARGON2I);

    // validation des contraintes et de la logique
    if ($email) {
        // verification que l'email n'exite pas deja
        if (!findOneUserByEmail($email)) {
            if (createUser($firstName, $lastName, $email, $password)) {
                $_SESSION['messages']['success'] = "Vous êtes inscrit a notre aplication";

                http_response_code(302);
                header('location: /login.php');
                exit();
            } else {
                $errorMessage = "Une erreur est survenue, veuillez réessayer";
            }
        } else {
            $errorMessage = "L'email est deja utiliser par un autre compte";
        }
    } else {
        $errorMessage = "Veuillez reseigner un email valide";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire | My first app PHP</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>
    <?php require_once '/app/layout/header.php' ?>

    <main>
        <section class="container">
            <h1 class="text-center mt-2">S'inscrire</h1>
            <form action="/register.php" method="POST" class="card">

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