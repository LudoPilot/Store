<?php
    session_start();
    include "functions.php";
    include "db-functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Connexion</title>
</head>
<body>
    <?php include "menu.php"; ?>
    <main>
        <form action="security.php?action=login" method="post">
            <p>
                <label>
                    Nom d'utilisateur ou adresse e-mail:
                    <input type="text" name="credentials" required>
                </label>
            </p>
            <p>
                <label>
                    Mot de passe :
                    <input type="password" name="password" required>
                </label>
            </p>
            <p>
                <input type="submit" name="submit" value="Connexion">
            </p>
        </form>
    </main>
</body>
</html>