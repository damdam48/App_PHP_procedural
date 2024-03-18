<?php

session_start();

require_once '/app/requests/users.php';

if (!isset($_SESSION['user']) || !in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
    http_response_code(302);
    header('Location: /login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin des users | My first app PHP</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>
    <?php include_once '/app/Layout/header.php'; ?>
    <main>
        <section class="container">
            <h1 class="text-center">Administration des users</h1>
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (findAllUsers() as $user) : ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['firstName']; ?></td>
                            <td><?= $user['lastName']; ?></td>
                            <td><?= $user['email']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>