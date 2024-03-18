<header class="navbar">
    <nav class="navbar-content">
        <a href="/" class="logo">My first App Php</a>
        <ul class="navbar-list">
            <li class="navbar-link">
                <a href="/">home</a>
            </li>
            <li class="navbar-link">
                <a href="#">Articles</a>
            </li>
            <?php if (!empty($_SESSION['user'])) : ?>
                <li class="navbar-link navbar-btn">
                    <a href="/logout.php" class="btn btn-danger">Déconnexion</a>
                </li>
            <?php else : ?>
                <li class="navbar-link navbar-btn">
                    <a href="/logout.php" class="btn btn-secondary">Connexion</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>