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
        <?php if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['message'])) : ?>
            <h1><?= htmlspecialchars($_POST['nom']); ?></h1>
            <h1><?= strip_tags($_POST['nom']); ?></h1>
            <p><?= $_POST['prenom']; ?></p>
            <p><?= $_POST['message']; ?></p>
        <?php else : ?>
            <h1>Veuillez renseigner les informations dans le formulaire</h1>
        <?php endif; ?>
    </main>
</body>

</html>