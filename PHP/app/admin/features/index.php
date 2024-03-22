<?php

session_start();

require_once '/app/utils/isAdmin.php';
require_once '/app/requests/features.php';

$_SESSION['token'] = bin2hex(random_bytes(80));

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration des features | My first app PHP</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>
    <?php require_once '/app/layout/header.php'; ?>
    <main>
        <?php require_once '/app/layout/flash.php'; ?>

        <section class="container mt-2">
            <h1 class="text-center">Administration des features</h1>
            <a href="/admin/features/create.php" class="btn btn-primary mb-2">Créer une feature</a>
        </section>

        <div class="card-list mt-2">
            <?php foreach (findAllFeatures() as $feature) : ?>
                <div class="card border-<?= $feature['enable'] === 1 ? 'success' : 'danger'; ?>">

                    <?php if ($feature['imageName']) : ?>
                        <img src="/assets/uploads/feature/<?= $feature['imageName']; ?>" alt="<?= $feature['name']; ?>" class="card-img">
                    <?php endif; ?>

                    <div class="card-body">
                        <h2 class="card-title"><?= $feature['name']; ?></h2>
                        <p><?= $feature['description']; ?></p>
                        <p><?= $feature['enable'] === 1 ? 'Actif' : 'Inactif'; ?></p>
                        <div class="card-btn">
                            <a href="/admin/features/edit.php?id=<?= $feature['id']; ?>" class="btn btn-secondary">Modifier</a>
                            <form action="/admin/features/delete.php" method="POST" onsubmit="return confirm('étes-vous sur de vouloir supprimer cet feature ?')">
                                <input type="hidden" name="id" value="<?= $feature['id']; ?>">
                                <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>

</html>