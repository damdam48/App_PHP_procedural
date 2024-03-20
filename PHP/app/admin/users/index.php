<?php

session_start();

require_once '/app/utils/isAdmin.php';

require_once '/app/requests/users.php';

// var_dump($_SESSION);

$_SESSION['token'] = bin2hex(random_bytes(80));


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrateur | My first app PHP</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>
    <?php require_once '/app/layout/header.php' ?>
    <main>
        <?php require_once '/app/layout/flash.php' ?>

        <section class="container mt-2">
            <h1 class="text-center">Adminnistration des users</h1>
            <div class="card-list mt-2">
                <?php foreach (findAllUser() as $user) : ?>
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title"><?= "$user[firstName] $user[lastName]"; ?></h2>
                            <p><?= $user['email']; ?></p>
                            <p>
                                <?php foreach (json_decode($user['roles'] ?: '["ROLE_USER"]') as $role) : ?>
                                    <?= "$role, "; ?>
                                <?php endforeach; ?>
                            </p>

                            <div class="card-btn">
                                <a href="/admin/users/edit.php?id=<?= $user['id'] ;?>" class="btn btn-secondary">Modifier</a>
                                <form action="/admin/users/delete.php" method="POST" onsubmit="return confirm('étes-vous sur de vouloir supprimer cet utilisateur ?')">
                                    <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                    <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>





        <!-- <?php var_dump(password_hash('test1234', PASSWORD_ARGON2I)); ?> -->
    </main>

</body>

</html>