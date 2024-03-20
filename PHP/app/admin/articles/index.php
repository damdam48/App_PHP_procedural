<?php

session_start();

require_once '/app/utils/isAdmin.php';

require_once '/app/requests/articles.php';


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
        </section>

        <div class="card-list mt-2">
            <?php foreach(findAllArticles() as $article): ?>
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title"><?= $article['title']; ?></h2>
                        <p><?= $article['description']; ?></p>
                        <p><?= (new DateTime($article['createdAt']))->format('d/m/Y'); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>

</html>
