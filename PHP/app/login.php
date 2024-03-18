<?php

require_once '/app/requests/users.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter | My first app PHP</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>
    <?php require_once '/app/layout/header.php' ?>
    <main>
        <section class="container mt-2">
            <h1 class="text-center">Se connecter</h1>
            <form action="/login.php" action="POST" class="card">
                <div class="group-input">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" placeholder="johon@exemple.com" required>
                </div>
                <div class="group-input">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" placeholder="S3CR3T" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </div>
            </form>
        </section>



    </main>
    
</body>

</html>