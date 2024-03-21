<?php

// Démarre une session PHP pour stocker des variables de session entre les différentes requêtes HTTP.
session_start();

// Inclusion des fichiers nécessaires
require_once '/app/utils/isAdmin.php'; // Vérifie si l'utilisateur actuel est un administrateur.
require_once '/app/requests/articles.php'; // Contient des fonctions pour effectuer des opérations sur les articles.

// Récupère les détails de l'article en fonction de l'identifiant passé en GET, s'il existe.
$article = findOneArticleById(isset($_GET['id']) ? $_GET['id'] : 0);

// Vérifie si l'article a été trouvé. Si ce n'est pas le cas :
if (!$article) {
    // Stocke un message d'erreur dans la session.
    $_SESSION['messages']['danger'] = "Article non trouvé";

    // Redirige vers la page d'administration des articles.
    http_response_code(302);
    header('Location: /admin/articles');

    // Termine l'exécution du script.
    exit();
}

// Vérifie si des données ont été soumises via POST
if (
    !empty($_POST['title']) &&
    !empty($_POST['description'])
) {
    // Nettoie les données soumises
    $title = trim(strip_tags($_POST['title']));
    $description = trim(strip_tags($_POST['description']));

    // Vérifie si le titre est valide
    if ($title) {
        $oldTitle = $article['title'];
        $enable = isset($_POST['enable']) ? 1 : 0;

        $updatedAt = (new DateTime())->format('Y-m-d H:i:s');

        // Vérifie si le nouveau titre est déjà utilisé par un autre article
        if ($oldTitle !== $title && findOneArticleBytitle($title)) {
            $errorMessage = "Le nom de cet article est déjà utilisé";
        } else {
            // Met à jour l'article avec les nouvelles données
            if (updateArticle($article['id'], $title, $description, $enable, $updatedAt)) {
                // Si la mise à jour réussit, stocke un message de succès dans la session.
                $_SESSION['messages']['success'] = "Article modifié avec succès";

                // Redirige vers la page d'administration des articles.
                http_response_code(302);
                header('Location: /admin/articles');
                exit();
            } else {
                // Si une erreur survient lors de la mise à jour, stocke un message d'erreur.
                $errorMessage = "Une erreur est survenue";
            }
        }
    } else {
        // Si le titre n'est pas valide, stocke un message d'erreur.
        $errorMessage = "Renseignez un titre valide";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Si la requête est de type POST mais les champs obligatoires ne sont pas renseignés, stocke un message d'erreur.
    $errorMessage = "Veuillez renseigner les champs obligatoires";
}

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification d'un Article | My first app PHP</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>
    <?php require_once '/app/layout/header.php' ?>

    <main>
        <section class="container">
            <h1 class="text-center mt-2">Modifier un Article</h1>
            <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="POST" class="card">

                <?php if (isset($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <?= $errorMessage; ?>
                    </div>
                <?php endif; ?>

                <div class="group-input">
                    <label for="title">title:</label>
                    <input type="text" name="title" id="title" value="<?= $article['title']; ?>" required>
                </div>
                <div class="group-input">
                    <label for="description">description:</label>
                    <textarea name="description" id="description" placeholder="écrit une description ici" required cols="30" rows="10"><?= $article['description']; ?></textarea>
                </div>


                <div class="group-input group-check">
                    <input type="checkbox" name="enable" id="enable" <?= $article['enable'] === 1 ? 'checked' : ''; ?>>
                    <label for="enable">Actif</label>
                </div>


                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
            <a href="/admin/articles" class="btn btn-secondary mt-2">Retour à la liste des articles</a>
        </section>
    </main>

</body>

</html>