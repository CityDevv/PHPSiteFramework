<?php
session_start(); 

// Regenerate session ID for security
if (!isset($_SESSION['last_regeneration'])) {
    $_SESSION['last_regeneration'] = time();
} elseif (time() - $_SESSION['last_regeneration'] > 300) { 
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

// Check if session has expired (e.g., inactivity timeout)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) { 
    session_unset(); 
    session_destroy(); 
    header("Location: login.php"); 
    exit();
}
$_SESSION['last_activity'] = time(); 

// Database connection
$user = "root";
$pass = "";
try {
    $dbh = new PDO('mysql:host=localhost;dbname=test_db', $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ 
    ]);
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

// Check if user is logged in
$id = $_SESSION["id"] ?? null; 

if ($id) {
    $userstmt = $dbh->prepare("SELECT * FROM `admins` WHERE `id` = :id");
    $id = (int) $id;
    $userstmt->bindParam(":id", $id, PDO::PARAM_INT);
    $userstmt->execute();
    $user = $userstmt->fetch();
}


?>
