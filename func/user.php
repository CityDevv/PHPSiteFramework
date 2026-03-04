<?php
require_once "Database.php";

class User {
    private $db;
    private $userData;

    public function __construct(Database $database) {
        $this->db = $database->getConnection();
    }

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $this->userData = $stmt->fetch();
        return $this->userData;
    }

    public function isAuthenticated() {
        return isset($_SESSION["id"]);
    }

    public function getUserData() {
        return $this->userData;
    }

    public function register($username, $email, $password) {
        $stmt = $this->db->prepare("SELECT `id` from `users` WHERE `username` = :username or `email` = :email");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            return "Username or Email already exists.";
        }

        $hashedPassword = password_hash($password, PASSWORD_ARGON2I);
        $stmt = $this->db->prepare("INSERT INTO `users` (`username`, `email`, `password`) VALUES (:username, :email, :password)");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return "Registration failed.";
        }
    }

    public function login($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM `users` WHERE `username` = :username");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            return "Username not found.";
        }

        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if (password_verify($password, $user->password)) {
            $_SESSION["id"] = $user->id;
            $this->userData = $user;
            return true;
        } else {
            return "Incorrect password.";
        }
    }

}



?>
