<?php

class Product {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function getProductById($pID) {
        $stmt = $this->dbh->prepare("SELECT * FROM `products` WHERE `id` = :id");
        $stmt->bindParam(":id", $pID, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
