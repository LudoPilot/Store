<?php
    session_start();
    include "functions.php";
    include "db-functions.php";

    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

    if(!$id || !$product = findOneById($id)){
        setMessage("error", "Le produit demandé n'existe pas...");
        redirect("index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Store</title>
</head>
<body>
    <?php include "menu.php"; ?>
    <main>
        <p>
            <a href="index.php">&ltrif;&nbsp;Retour</a>
        </p>
        <section class="single-product">
            <figure class="single-product__image">
                <img src="https://via.placeholder.com/300.png?text=<?= $product["name"] ?>" alt="">
            </figure>
            <div class="single-product__infos">
                <h1><?= $product["name"] ?></h1>
                <p><?= $product["description"] ?></p>
                <p><?= number_format($product["price"], 2, ',', ' ') ?>&nbsp;&euro;</p>
                <p>
                    <a href="traitement.php?action=addToCart&id=<?= $product["id"] ?>">Ajouter au panier</a>
                </p>
            </div>
            
        </section>
        
    </main>
</body>
</html>