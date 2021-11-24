<?php
    session_start();
    include "functions.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Récapitulatif des produits</title>
    </head>
    <body>
        <?php include "menu.php"; ?>

        <?php
        if(!isset($_SESSION['products']) || empty($_SESSION['products'])){
            ?>
            <p>Aucun produit en session...</p>
            <?php
        }
        else{
            ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalGeneral = 0;
                    
                    foreach($_SESSION['products'] as $index => $product){
                        //on calcule le total de la ligne ici
                        $totalLigne = $product['price']*$product['qtt'];
                        ?>
                        <tr>
                            <td><a href='traitement.php?action=deleteProd&id=<?=$index?>'>Supprimer</a></td>
                            <td><?= $product['name'] ?></td>
                            <td><?= number_format($product['price'], 2, ",", "&nbsp;") ?>&nbsp;€</td>
                            <td>
                                <a href='traitement.php?action=updateQtt&id=<?= $index ?>&mode=decr'>&minus;</a>
                                <?= $product['qtt'] ?>
                                <a href='traitement.php?action=updateQtt&id=<?= $index ?>&mode=incr'>&plus;</a>
                            </td>
                            <td><?= number_format($totalLigne, 2, ",", "&nbsp;")?>&nbsp;€</td>
                        </tr>
                        <?php
                        $totalGeneral += $totalLigne;
                    }
                    ?>
                    <tr>
                        <td colspan=3></td>
                        <td><?= getFullQtt() ?></td>
                        <td><strong><?= number_format($totalGeneral, 2, ",", "&nbsp;") ?>&nbsp;€</strong></td>
                    </tr>
                </tbody>
            </table>
            <p>
                <a href='traitement.php?action=deleteAll'>Vider le panier</a>
            </p>
            <?php
            }
        ?>
        
    </body>
</html>