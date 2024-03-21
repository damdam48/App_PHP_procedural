<?php

session_start();

require_once '/app/utils/isAdmin.php';

require_once '/app/requests/articles.php';

$_SESSION['token'] = bin2hex(random_bytes(80));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration des articles | My first app PHP</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>
    <?php require_once '/app/layout/header.php'; ?>
    <main>
        <?php require_once '/app/layout/flash.php'; ?>
        
        <section class="container mt-2">
            <h1 class="text-center">Administration des articles</h1>
            <a href="/admin/articles/create.php" class="btn btn-primary mb-2">Créer un article</a>
        </section>

        <div class="card-list mt-2">
            <?php foreach(findAllArticles() as $article): ?>
                <div class="card border-<?= $article['enable'] === 1 ? 'success' : 'danger'; ?>">
                    <div class="card-body">
                        <h2 class="card-title"><?= $article['title']; ?></h2>
                        <p><?= $article['description']; ?></p>
                        <p><?= (new DateTime($article['createdAt']))->format('d/m/Y'); ?></p>
                        <p><?= $article['enable'] === 1 ? 'Actif': 'Inactif' ;?></p>
                        <em><?= "$article[firstName] $article[lastName]"; ?></em>
                        <div class="btn">
                            <a href="/admin/articles/edit.php?id=<?= $article['id']; ?>" class="btn btn-secondary">Modifier</a>
                            <form action="/admin/articles/delete.php" method="POST" onsubmit="return confirm('étes-vous sur de vouloir supprimer cet article ?')">
                                    <input type="hidden" name="id" value="<?= $article['id']; ?>">
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
