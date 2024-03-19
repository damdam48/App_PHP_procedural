<?php

session_start();

if (!empty($_SESSION['user'])) {
    unset($_SESSION['user']);
}

http_response_code(302);
header('location: /');
exit();

