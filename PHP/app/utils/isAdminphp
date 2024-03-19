<?php

if (empty($_SESSION['user']) || !in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
    $_SESSION['messages']['danger'] = "Vous n'avez pas les droits";

    http_response_code(302);
    header('Location: /login.php');
    exit();
}

?>