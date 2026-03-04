<?php
require_once $_SERVER['DOCUMENT_ROOT']."/func/SessionManager.php";
require_once $_SERVER['DOCUMENT_ROOT']."/func/Database.php";
require_once $_SERVER['DOCUMENT_ROOT']."/func/User.php";

SessionManager::startSession();
$db = new Database();  
$user = new User($db);

$currentUser = null;
if ($user->isAuthenticated()) {
    $currentUser = $user->getUserById($_SESSION["id"]);
}

$GLOBALS['db'] = $db;
?>

<html>
<head>
    <link rel="stylesheet" href="https://unpkg.com/cirrus-ui"> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/fontawesome.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
</head>
<body>
    <div class="header u-unselectable header-animated header-dark">
        <div class="nav-item no-hover"><div class="header-brand"><a><h6 class="title">BJJ TCGSHOP</h6></a></div></div>

        <div class="header-nav" id="header-menu" role="button">
            <div class="nav-left">
                <div class="nav-item"><a href="../">Home</a></div>
                <div class="nav-item"><a href="#">Explore</a></div>
            </div>

            <div class="nav-right">
                <div class="nav-item"><a href="#"><span class="icon"><i class="fa-regular fa-heart"></i></span></a></div>
                <div class="nav-item">
                    <?php if ($currentUser): ?>
                        <a href="#">Welcome, <?= htmlspecialchars($currentUser->username); ?></a>
                    <?php else: ?>
                        <a href="../login.php">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
