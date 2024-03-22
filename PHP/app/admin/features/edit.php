<?php

// Démarre une session PHP pour stocker des variables de session entre les différentes requêtes HTTP.
session_start();

// Inclusion des fichiers nécessaires
require_once '/app/utils/isAdmin.php'; // Vérifie si l'utilisateur actuel est un administrateur.
require_once '/app/requests/features.php'; // Contient des fonctions pour effectuer des opérations sur les features.
require_once '/app/utils/uploadImage.php';
require_once '/app/requests/users.php';



// Récupère les détails de l'feature en fonction de l'identifiant passé en GET, s'il existe.
$feature = findOneFeatureById(isset($_GET['id']) ? $_GET['id'] : 0);

// Vérifie si l'feature a été trouvé. Si ce n'est pas le cas :
if (!$feature) {
    // Stocke un message d'erreur dans la session.
    $_SESSION['messages']['danger'] = "Feature non trouvé";

    // Redirige vers la page d'administration des features.
    http_response_code(302);
    header('Location: /admin/features');

    // Termine l'exécution du script.
    exit();
}

// Vérifie si des données ont été soumises via POST
if (
    !empty($_POST['feature']) &&
    !empty($_POST['description'])
) {
    // Nettoie les données soumises
    $title = trim(strip_tags($_POST['title']));
    $description = trim(strip_tags($_POST['description']));

        if ($title) {
            $oldTitle = $feature['title'];
            $enable = isset($_POST['enable']) ? 1 : 0;


            if (!empty($_FILES['image'])) {
                $imageName = uploadImage($_FILES['image'], 'feature', $feature['imageName'] ?: null);
            }

            // Vérifie si le nouveau titre est déjà utilisé par un autre feature
            if ($oldTitle !== $title && findOneFeatureByName($title)) {
                $errorMessage = "Le nom de cet feature est déjà utilisé";
            } else {
                // Met à jour l'feature avec les nouvelles données
                if (updateFeature($feature['id'], $name, $description, $enable, isset($imageName) ? $imageName : null)) {
                    // Si la mise à jour réussit, stocke un message de succès dans la session.
                    $_SESSION['messages']['success'] = "feature modifié avec succès";

                    // Redirige vers la page d'administration des features.
                    http_response_code(302);
                    header('Location: /admin/features');
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


    // Vérifie si le titre est valide


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
    <title>Modification d'un Feature | My first app PHP</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>
    <?php require_once '/app/layout/header.php' ?>

    <main>
        <section class="container">
            <h1 class="text-center mt-2">Modifier un feature</h1>
            <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="POST" class="card" enctype="multipart/form-data">

                <?php if (isset($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <?= $errorMessage; ?>
                    </div>
                <?php endif; ?>

                <div class="group-input">
                    <label for="name">title:</label>
                    <input type="text" name="name" id="name" value="<?= $feature['name']; ?>" required>
                </div>
                <div class="group-input">
                    <label for="description">description:</label>
                    <textarea name="description" id="description" placeholder="écrit une description ici" required cols="30" rows="10"><?= $feature['description']; ?></textarea>
                </div>


                <div class="group-input group-check">
                    <input type="checkbox" name="enable" id="enable" <?= $feature['enable'] === 1 ? 'checked' : ''; ?>>
                    <label for="enable">Actif</label>
                </div>

                <div class="group-input">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" accept="image/*">

                    <?php if ($feature['imageName']) : ?>
                        <img src="/assets/uploads/feature/<?= $feature['imageName']; ?>" alt="<?= $feature['name']; ?>" class="card-img mt-2" loading="lazy">
                    <?php endif; ?>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>


            </form>
            <a href="/admin/features" class="btn btn-secondary mt-2">Retour à la liste des features</a>
        </section>
    </main>

</body>

</html>