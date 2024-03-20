<?php

session_start();

require_once "/app/utils/isAdmin.php";
require_once "/app/requests/users.php";

$user = findOneUserById(isset($_POST['id']) ? $_POST['id'] : 0);

if (!$user) {
    $_SESSION['messages']['danger'] = "User non trouvé";

    http_response_code(302);
    header('Location: /admin/users');
    exit();
}

if (hash_equals($_SESSION['token'], isset($_POST['token']) ? $_POST['token'] : '')) {
    if (deleteUser($user['id'])) {
        $_SESSION['messages']['success'] = "user supprimé avec succes";
    } else {
        $_SESSION['messages']['danger'] = "Une erreur est survenue";
    }
} else {
    $_SESSION['messages']['danger'] = "Token CSRF invalide";
}


http_response_code(302);
header('Location: /admin/users');
exit();
