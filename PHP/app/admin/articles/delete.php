<?php

// Démarre une session PHP pour stocker des variables de session entre les différentes requêtes HTTP.
session_start();

// Inclusion des fichiers nécessaires
require_once "/app/utils/isAdmin.php"; // Vérifie si l'utilisateur actuel est un administrateur.
require_once "/app/requests/articles.php"; // Contient des fonctions pour effectuer des opérations sur les articles.
require_once "/app/utils/uploadImage.php";

// Récupère les détails de l'article en fonction de l'identifiant passé en POST, s'il existe.
$article = findOneArticleById(isset($_POST['id']) ? $_POST['id'] : 0);

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

// Vérifie si le token CSRF est valide.
if (hash_equals($_SESSION['token'], isset($_POST['token']) ? $_POST['token'] : '')) {
    // Si le token est valide, tente de supprimer l'article en utilisant la fonction deleteArticle().
    if (deleteArticle($article['id'])) {

        if ($article['imageName']) {
            deleteImage($article['imageName'], 'article');
        }

        // Si la suppression est réussie, stocke un message de succès dans la session.
        $_SESSION['messages']['success'] = "Article supprimé avec succès";
    } else {
        // Sinon, stocke un message d'erreur.
        $_SESSION['messages']['danger'] = "Une erreur est survenue";
    }
} else {
    // Si le token CSRF est invalide, stocke un message d'erreur dans la session.
    $_SESSION['messages']['danger'] = "Token CSRF invalide";
}

// Redirige toujours vers la page d'administration des articles après l'opération.
http_response_code(302);
header('Location: /admin/articles');

// Termine l'exécution du script.
exit();
