<?php
    session_start();
    include "functions.php";
    include "db-functions.php";

    //on récupère quoi qu'il arrive TOUS les produits pour les lister en bas de page
    $products = findAll();
    //on filtre un éventuel param de requète id (en cas de modification d'un produit)
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    //cette variable est un indicateur pour le reste du code (si elle reste null, pas de modification)
    $prodToUpdate = null;
    //l'action du formulaire en mode 'ajout de produit'
    $formAction = "db-traitement.php?action=addProd";
    //vérifications nécessaires pour savoir si nous devons basculer en mode "modif de produit"
    //si $id passe le filtre ET qu'un produit correspondant à l'id est récupéré en BDD
    if($id && $prod = findOneById($id)){
        //prodToUpdate prend alors comme valeur le produit à modifier
        $prodToUpdate = $prod;
        //et l'action du formulaire change
        $formAction = "db-traitement.php?action=updateProd&id=$id";
    }
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title><?= $prodToUpdate ? "Modifier" : "Ajouter" ?> produit</title>
    </head>
    <body>
        <?php include "menu.php"; ?>

        <h1><?= $prodToUpdate ? "Modifier" : "Ajouter" ?> un produit</h1>
        <form action="<?= $formAction ?>" method="post">
            <p>
                <label>
                    Nom du produit :
                    <input type="text" name="name" value="<?= $prodToUpdate ? $prodToUpdate["name"] : "" ?>">
                </label>
            </p>
            <p>
                <label>
                    Prix du produit :
                    <input type="number" step="any" name="price" value="<?= $prodToUpdate ? $prodToUpdate["price"] : "" ?>">
                </label>
            </p>
            <p>
                <label>
                    Description du produit :
                    <textarea name="descr" rows=3><?= $prodToUpdate ? $prodToUpdate["description"] : "" ?></textarea>
                </label>
            </p>
            <p>
                <input type="submit" name="submit" value="Valider">
            </p>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>PRICE</th>
                    <th>DESCRIPTION</th>
                    <th>OPTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($products as $prod){
                ?>
                <tr>
                    <td><?= $prod["id"] ?></td>
                    <td><?= $prod["name"] ?></td>
                    <td><?= $prod["price"] ?></td>
                    <td><?= $prod["description"] ?></td>
                    <td>
                        <a href="admin.php?id=<?= $prod["id"] ?>">MODIFIER</a> - 
                        <a href="db-traitement.php?action=deleteProd&id=<?= $prod['id'] ?>"
                            onclick="confirmDelete('<?= $prod['name'] ?>')">
                            SUPPRIMER
                        </a>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
            <div id="modal">
                <h1>ALERTE</h1>
                <p>Vous allez supprimer le produit <span class="modal__name"></span>, confirmer ?</p>
                <p id="modal-actions">
                    <a class="modal-actions__confirm" href="">Confirmer</a>
                    <a class="modal-actions__cancel" href="#">Annuler</a>
                </p>
            </div>
        </table>
        <script src="script.js"></script>
    </body>
</html>