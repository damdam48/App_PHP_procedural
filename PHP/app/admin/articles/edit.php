<?php

session_start();

require_once '/app/utils/isAdmin.php';
require_once '/app/requests/articles.php';

$article = findOneArticleById(isset($_GET['id']) ? $_GET['id'] : 0);

if (!$article) {
    $_SESSION['messages']['danger'] = "article non trouvé";

    http_response_code(302);
    header('Location: /admin/articles');
    exit();
}

// verification de la soumission
if (
    !empty($_POST['title']) &&
    !empty($_POST['description'])

) {
    // nettayer les données
    $title = trim(strip_tags($_POST['title']));
    $description = trim(strip_tags($_POST['description']));


    // ajouter de la logique et contraintes
    if ($title) {
        $oldTitle = $article['title'];
        $enable = isset($_POST['enable']) ? 1 : 0;

        $updatedAt = (new DateTime())->format('Y-m-d H:i:s');

        if ($oldTitle !== $title && findOneArticleBytitle($title)) {
            $errorMessage = "le nom de c'est article est deja utiliser";

        } else {

            if (updateArticle($article['id'], $title, $description, $enable, $updatedAt)) {
                $_SESSION['messages']['success'] = "article modifié avec succès";

                http_response_code(302);
                header('Location: /admin/articles');
                exit();
            } else {
                $errorMessage = "Une erreur est survenue";
            }
        }
    } else {
        $errorMessage = "Renseingnez un article valide";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
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