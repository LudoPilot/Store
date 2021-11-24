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
    <title>Document</title>
</head>
<body>
    <?php include "menu.php"; ?>
    <main>
        <form action="security.php?action=register" method="post">
            <p>
                <label>
                    Nom d'utilisateur :
                    <input type="text" name="username" required>
                </label>
            </p>
            <p>
                <label>
                    Adresse e-mail :
                    <input type="email" name="email" required>
                </label>
            </p>
            <p>
                <label>
                    Mot de passe :
                    <input type="password" name="pass1" required>
                </label>
            </p>
            <p>
                <label>
                    Répétez le mot de passe :
                    <input type="password" name="pass2" required>
                </label>
            </p>
            <p>
                <input type="submit" name="submit" value="Inscription">
            </p>
        </form>
    </main>
</body>
</html>