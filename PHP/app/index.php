<?php

require_once '/app/requests/users.php';

var_dump(findOneUserByEmail('roberto@gmail.com'));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage | My first app PHP</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>
    <?php require_once '/app/layout/header.php' ?>
    <main>
        <h1>Page d'accueil</h1>
        <!-- <?php var_dump(password_hash('test1234', PASSWORD_ARGON2I)); ?> -->



    </main>
    
</body>

</html>