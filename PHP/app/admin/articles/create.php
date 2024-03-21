<?php

session_start();

require_once '/app/utils/isAdmin.php';
require_once '/app/requests/articles.php';
require_once '/app/utils/uploadImage.php';

// Vérifie si les champs 'title' et 'description' sont présents et non vides dans la requête POST.
if (!empty($_POST['title']) && !empty($_POST['description'])) {

    // Nettoie et récupère les valeurs des champs 'title' et 'description'
    $title = trim(strip_tags($_POST['title']));
    $description = trim(strip_tags($_POST['description']));

    // Vérifie si la case à cocher 'enable' est cochée.
    $ennable = isset($_POST['enable']) ? 1 : 0;

    // Récupère l'ID de l'utilisateur à partir de la session.
    $userId = $_SESSION['user']['id'];

    $imageName = uploadImage($_FILES['image'], 'article');


    // Crée un nouvel article en utilisant la fonction createArticle().
    if (createArticle($title, $description, $ennable, $userId, $imageName)) {
        $_SESSION['messages']['success'] = "Article crée avec succèes";

        http_response_code(302);
        header('Location: /admin/articles');
        exit();
    } else {
        $errorMessage = "Une erreur est survenue";
    }

    // Si la requête est de type POST mais les champs obligatoires ne sont pas renseignés, envoi un message d'erreur.
} elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
    $errorMessage = "Veuillez renseigner les champs obligatoires";
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creation d'un article | My first app PHP</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>
    <?php require_once '/app/layout/header.php' ?>
    <main>
        <section class="container mt-2">
            <h1 class="text-center mt-2">Creation d'un articles</h1>

            <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" class="card" enctype="multipart/form-data">

                <?php if (isset($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <?= $errorMessage; ?>
                    </div>
                <?php endif; ?>

                <div class="group-input">
                    <label for="title">Name article:</label>
                    <input type="text" name="title" id="title" placeholder="Name de l'article" required>
                </div>
                <div class="group-input">
                    <label for="description">description:</label>
                    <textarea name="description" id="description" cols="30" rows="10" placeholder="Contenu de votre article"></textarea>
                </div>
                <div class="group-input group-check">
                    <label for="enable">Actif</label>
                    <input type="checkbox" name="enable" id="enable">
                </div>

                <div class="group-input">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" accept="image/*">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </form>
        </section>









        <!-- <?php var_dump(password_hash('test1234', PASSWORD_ARGON2I)); ?> -->
    </main>

</body>

</html>