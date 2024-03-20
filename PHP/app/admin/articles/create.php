<?php

session_start();

require_once '/app/utils/isAdmin.php';
require_once '/app/requests/articles.php';

$article = findOneArticleById(isset($_GET['id']) ? $_GET['id'] : 0);

var_dump($_POST);

if (!empty($_POST['title']) && !empty($_POST['description'])) {
    $title = trim(strip_tags($_POST['title']));
    $description = trim(strip_tags($_POST['description']));

    $ennable = isset($_POST['enable']) ? 1 : 0;
    
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

            <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" class="card">

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
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </form>
        </section>









        <!-- <?php var_dump(password_hash('test1234', PASSWORD_ARGON2I)); ?> -->
    </main>

</body>

</html>