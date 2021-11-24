<header>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="recap.php">Panier (<?= getFullQtt() ?>)</a>
        <a href="admin.php">Administration</a>
        <?php
            if(isset($_SESSION['user'])) {
                ?>
                <span><?= $_SESSION['user']['username'] ?></span>
                <a href="security.php?action=logout">Déconnexion</a>
                <?php
            }
            else {
                ?>
                <a href="register.php">Inscription</a>
                <a href="login.php">Connexion</a>
                <?php
            }
        ?>
    </nav>

    <?= getMessage() ?>
    
</header>
