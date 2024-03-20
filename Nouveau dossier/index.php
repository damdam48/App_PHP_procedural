<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My first app PHP</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>
    <?php include_once '/app/Layout/header.php'; ?>
    <main>
        <form action="/contact.php" method="POST">
            <label for="nom">Nom:</label>
            <input type="text" name="nom" id="nom">
            <label for="prenom">Prenom:</label>
            <input type="text" name="prenom" id="prenom">
            <label for="message">Message:</label>
            <textarea name="message" id="message" rows="5"></textarea>
            <button>Envoyer</button>
        </form>
    </main>
</body>

</html>