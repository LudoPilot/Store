<?php
    session_start();
    include "functions.php";
    include "db-functions.php";

    $products = findAll();
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
        <section class="products">
            <?php  
                foreach($products as $prod)
                {
                ?>
                    <div class="products__item">
                        <h2>
                            <a href="product.php?id=<?= $prod["id"] ?>">
                                <?= $prod["name"] ?>
                            </a>
                        </h2>
                        <p><?= mb_strimwidth($prod["description"], 0, 50, "...") ?></p>
                        <p><?= number_format($prod["price"], 2, ',', ' ') ?>&nbsp;&euro;</p>
                        <p>
                            <a href="traitement.php?action=addToCart&id=<?= $prod["id"] ?>">Ajouter au panier</a>
                        </p>
                    </div>
                <?php
                }
            ?>
        </section>
    </main>
    
</body>
</html>