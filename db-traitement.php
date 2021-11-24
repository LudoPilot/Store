<?php
    session_start();
    include "functions.php";
    include "db-functions.php";

    $action = filter_input(INPUT_GET, "action", FILTER_VALIDATE_REGEXP, [
        "options" => [
            "regexp" => "/addProd|updateProd|deleteProd/"
        ]
    ]);

    if($action){

        switch($action){
            
            case "addProd":
                if(isset($_POST['submit'])){

                    $name= filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
                    $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $descr = filter_input(INPUT_POST, "descr", FILTER_SANITIZE_STRING);
            
                    if($name && $price && $descr){
            
                        if($newId = insertProduct($name, $price, $descr)){
                            setMessage("success", "Produit $name ajouté en base de données !"); 
                            redirect("product.php?id=$newId");
                        }
                        else setMessage("error", "Erreur de base de données !");
                    }
                    else setMessage("notice", "Vérifiez les données du formulaire !");
                }
                else setMessage("error", "Sale pirate de ta maman, tu valides le formulaire STP !");
                
                break;

            case "updateProd":
                if(isset($_POST['submit'])){
                    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

                    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
                    $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $descr = filter_input(INPUT_POST, "descr", FILTER_SANITIZE_STRING);

                    if($id && $name && $price && $descr){
                        if(updateProduct($id, $name, $price, $descr)){
                            setMessage("success", "Produit $name modifié en base de données !");
                        }
                        else setMessage("error", "Erreur de base de données !");
                    }
                    else setMessage("notice", "Vérifiez les données du formulaire !");
                }
                else setMessage("error", "Sale pirate de ta maman, tu valides le formulaire STP !");

                break;

            case "deleteProd": 
                $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

                if($id && deleteProduct($id)){
                    setMessage("success", "Produit supprimé en base de données !");
                }
                else setMessage("error", "L'action n'a pas pu être réalisée !");
            
                break;
        }
    }

    redirect("admin.php");