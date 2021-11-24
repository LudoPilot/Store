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

    function findByUsernameOrEmail($username, $email)
    {
        $db = connexion();
        $sql = "SELECT * FROM user WHERE email = :email OR username = :username";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ":username" => $username,
            ":email"    => $email
        ]);
        return $stmt->fetch();
    }

    function insertUser($username, $email, $hash)
    {
        $db = connexion();
        $sql = "INSERT INTO user (username, email, password) VALUES (:u, :e, :p)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ":u" => $username,
            ":e" => $email,
            ":p" => $hash
        ]);
    }