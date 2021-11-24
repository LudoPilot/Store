<?php
    /**
     * Retourne une instance de PDO, représentant la connexion à la base de données
     * @return \PDO un objet instance de PDO, connecté à la base de données
     */
    function connexion()
    {
        return new \PDO(
            "mysql:dbname=store;host=localhost:3306",
            "root",
            "",
            [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
            ]
        );
    }

    /**
     * Retourne tous les produits de la base de données
     * 
     * @return array|false 
     * Renvoie un tableau contenant les produits sous forme de tableau, 
     * un tableau vide si aucun produit n'est présent en base
     * ou FALSE si la requète a échoué
     */
    function findAll()
    {
        $db = connexion();
        $sql = "SELECT * FROM product";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Retourne le produit en base de données correspondant à l'id en paramètre
     * 
     * @param int $id l'identifiant du produit en BDD
     * @return array|false un tableau contenant les champs du produit ou FALSE si aucun produit n'a été récupéré
     */
    function findOneById($id)
    {
        $db = connexion();
        $sql = "SELECT * FROM product WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Insère un produit en base de données et renvoie son ID 
     * 
     * @param string    $name  le nom du produit
     * @param float|int $price le prix du produit
     * @param string    $descr la description du produit
     * 
     * @return int|null l'ID du produit nouvellement inséré en BDD, null si l'ajout a échoué
     */
    function insertProduct($name, $price, $descr)
    {
        $db = connexion();
        $sql = "INSERT INTO product (name, price, description) VALUES (:n, :p, :d)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":n", $name);
        $stmt->bindParam(":p", $price);
        $stmt->bindParam(":d", $descr);
        $stmt->execute();
        return intval($db->lastInsertId());
    }

    /**
     * Met à jour le produit répondant à $id avec les $name, $price et $descr fournis
     * 
     * @param string $id l'id du produit à modifier
     * @param string $name le nouveau nom du produit
     * @param string $price le nouveau prix du produit
     * @param string $descr la nouvelle description du produit
     * 
     * @return bool TRUE si succès de la requète de mise à jour, FALSE sinon
     */
    function updateProduct($id, $name, $price, $descr, $image = null)
    {
        $db = connexion();
        $sql = "UPDATE product 
                SET name = :n, price = :p, description = :d
                WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ":id" => $id,
            ":n"  => $name,
            ":p"  => $price,
            ":d"  => $descr,
        ]);
    }

    /**
     * Supprime le produit répondant à l'id donné en paramètre
     * 
     * @param string $id l'identifiant du produit à supprimer
     * 
     * @return bool TRUE si succès de la requète de suppression, FALSE sinon
     */
    function deleteProduct($id){
        $db = connexion();

        $sql = "DELETE FROM product WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Récupère tous les produits dont le prix est compris entre min et max
     * 
     * @param float $min le prix minimum à vérifier
     * @param float $max le prix maximum à vérifier
     * 
     * @return array|false un tableau des produits récupérés ou non, FALSE si la requète échoue
     */
    function findByPrice($min, $max)
    {
        $db = connexion();
        $sql = "SELECT * FROM product WHERE price BETWEEN :min AND :max";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":min", $min);
        $stmt->bindParam(":max", $max);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
