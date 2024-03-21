<?php

session_start();

require_once "/app/utils/isAdmin.php";
require_once "/app/requests/articles.php";

// Récupère les détails de l'article en fonction de l'identifiant passé en POST, s'il existe.
$article = findOneArticleById(isset($_POST['id']) ? $_POST['id'] : 0);

// Vérifie si l'article a été trouvé. Si ce n'est pas le cas :
if (!$article) {
    $_SESSION['messages']['danger'] = "Article non trouvé";

    http_response_code(302);
    header('Location: /admin/articles');
    exit();
}

// Vérifie si le token CSRF est valide.
if (hash_equals($_SESSION['token'], isset($_POST['token']) ? $_POST['token'] : '')) {
    if (deleteArticle($article['id'])) {
        $_SESSION['messages']['success'] = "Article supprimé avec succes";
    } else {
        $_SESSION['messages']['danger'] = "Une erreur est survenue";
    }
} else {
    $_SESSION['messages']['danger'] = "Token CSRF invalide";
}

// Redirige toujours vers la page d'administration des articles après l'opération.
http_response_code(302);
header('Location: /admin/articles');
exit();