<header class="navbar">
    <nav class="navbar-content">
        <a href="/" class="logo"> My first App PHP</a>
        <ul class="navbar-links">
            <li class="nav-item">
                <a href="/"> Home</a>
            </li>
            <li class="navbar-item">
                <a href="#"> Articles</a>
            </li>
        </ul>
        
        <ul class="navbar-links navbar-btn">
            <?php if(!empty($_SESSION['user'])) : ?>
                <li class="navbar-item">
                    <a href="/logout.php" class="btn btn-danger">Déconnecxion</a>
                </li>
            <?php else : ?>
                <li class="navbar-item">
                    <a href="/register.php" class="btn btn-outline-light">Inscription</a>
                </li>
            <li class="navbar-item">
                <a href="/login.php" class="btn btn-secondary">Connexion</a>
            </li>
            <?php endif ;?>
        </ul>
    </nav>
</header>