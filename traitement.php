<?php
    session_start();
    include "functions.php";
    include "db-functions.php";

    $action = filter_input(INPUT_GET, "action", FILTER_VALIDATE_REGEXP, [
        "options" => [
            "regexp" => "/addToCart|updateQtt|deleteProd|deleteAll/"
        ]
    ]);

    if($action){

        switch($action){
            //traitement.php?action=addToCart&id=X
            case "addToCart":
                $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
                
                if($id){
                    
                    $prodInSession = array_filter($_SESSION["products"], function($prod) use($id){
                        return $id == $prod["id"];
                    });

                    if(empty($prodInSession)){
                        if($product = findOneById($id)){
                            $product["qtt"] = 1;
                            $_SESSION["products"][] = $product;
                            setMessage("success", "Produit ".$product["name"]." ajouté avec succès ! <a href='recap.php'>Voir le panier</a>");
                        }
                        else{
                            setMessage("error", "Un problème est survenu avec la BDD, veuillez réessayer !");
                        }
                    }
                    else{
                        $key = key($prodInSession);
                        $_SESSION["products"][$key]["qtt"]++;
                        setMessage("success", "Produit ".$prodInSession[$key]["name"]." a vu sa quantité augmenter ! <a href='recap.php'>Voir le panier</a>");
                    }
                }
                else{
                    setMessage("error", "Un problème est survenu avec la requète, veuillez réessayer !");
                }
                redirect("index.php");
                break;

            case "updateQtt":
                $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
                $mode = filter_input(INPUT_GET, "mode", FILTER_VALIDATE_REGEXP, [
                    "options" => [
                        "regexp" => "/incr|decr/"
                    ]
                ]);

                //$id == 0 est équivalent à id == false ou id == null
                if($id >= 0 && $mode){
                    switch($mode){
                        case "incr":
                            $_SESSION["products"][$id]["qtt"]++;
                            break;
                        case "decr":
                            $_SESSION["products"][$id]["qtt"]--;
                            
                            if($_SESSION["products"][$id]["qtt"] == 0){
                                redirect("traitement.php?action=deleteProd&id=$id");
                            }
                            break;
                    }
                }
                else setMessage("error", "Problème de requête, réessayez !");
                break;

            case "deleteProd": 
                $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

                if(isset($_SESSION['products'][$id])){
                    $name = $_SESSION['products'][$id]["name"];//récupère le nom du produit qui va être supprimé
                    unset($_SESSION['products'][$id]);//on le supprime
                    /*------ACHTUNG------*/
                    $_SESSION["products"] = array_values($_SESSION["products"]);//réattribue les index des produits restants
                    /*----fin ACHTUNG----*/
                    setMessage("success", "Le produit $name a été supprimé !");
                }
                else setMessage("error", "Le produit n'existe pas !");
                break;
            
            case "deleteAll": 
                if(isset($_SESSION['products'])){
                    unset($_SESSION['products']);
                    setMessage("success", "Votre panier a été vidé avec succès !");
                }
                else setMessage("error", "Pas de panier... pas de panier !");
                break;
        }
    }

    redirect("recap.php");