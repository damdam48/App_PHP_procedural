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

$roles = [
    [
        'label' => 'Utilisateur',
        'value' => 'ROLE_USER',
        'id' => 'role-user',
    ],

    [
        'label' => 'Administrateur',
        'value' => 'ROLE_ADMIN',
        'id' => 'role-admin',
    ]
];


// verification de la soumission du formulaire
if (
    !empty($_POST['email']) &&
    !empty($_POST['firstName']) &&
    !empty($_POST['lastName'])

) {

    // nettoyer les données
    $firstName = trim(strip_tags($_POST['firstName']));
    $lastName = trim(strip_tags($_POST['lastName']));
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $rolesData = isset($_POST['roles']) ? $_POST['roles'] : null;

    // ajout de la logique et verification des contraintes
    if ($email) {
        $oldEmail = $user['email'];

        if($oldEmail !== $email && findOneUserByEmail($email)) {
            $errorMessage = "C'est email est utilisé pas un autre compte";

        } else {
            if (updateUser($user['id'], $firstName, $lastName, $email, $rolesData)) {
                $_SESSION['messages']['success'] = "User modifié avec succès";

                http_response_code(302);
                header('Location: /admin/users');
                exit();
            } else {
                $errorMessage = "Une erreur est survenue";
            }
        }

    } else {
        $errorMessage = "Renseingnez un email valide";
    }


} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errorMessage = "Veuillez renseigner les champs obligatoires";
}

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
                    <input type="text" name="firstName" id="firstName" value="<?= $user['firstName']; ?>" placeholder="John" required>
                </div>
                <div class="group-input">
                    <label for="lastName">Nom:</label>
                    <input type="text" name="lastName" id="lastName" value="<?= $user['lastName']; ?>" placeholder="Doe" required>
                </div>

                <div class="group-input mt-2">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="<?= $user['email']; ?>" placeholder="roberto@gmail.com" required>
                </div>


                <?php foreach ($roles as $role) : ?>
                    <div class="group-input group-check">
                        <input type="checkbox" name="roles[]" id="<?= $role["id"]; ?>" value="<?= $role["value"]; ?>" <?= in_array($role['value'], json_decode($user['roles'] ?: '["ROLE_USER"]')) ? 'checked' : null ?>>
                        <label for="<?= $role["id"]; ?>"><?= $role["label"]; ?></label>
                    </div>
                <?php endforeach; ?>


                <!-- <div class="group-input group-check">
                    <input type="checkbox" name="roles[]" id="role-user" value="ROLE_USER">
                    <label for="role-user">Utilisateur</label>
                </div>
                <div class="group-input group-check">
                    <input type="checkbox" name="roles[]" id="role-admin" value="ROLE_ADMIN">
                    <label for="role-admin">Administrateur</label>
                </div> -->


                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
            <a href="/admin/users" class="btn btn-secondary mt-2">Retour à la liste</a>
        </section>
    </main>

</body>

</html>