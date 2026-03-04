<?php
    include($_SERVER['DOCUMENT_ROOT']."/header.php");
    
    
    if($user->isAuthenticated()) {
        header("Location: ../index.php");
        exit();
    }


    $loginError = "";
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, "password");
        
        if ($username && $password) {
            $result = $user->login($username, $password);
            
            if ($result === true) {
                header("Location: http://localhost:3000");
                exit();
            } else {
                $loginError = $result;
            }
        } else {
            $loginError = "Please provide both username and password.";
        }
    }
?> 
<html>
<head>
    <title>SHOP-SITE | Login</title>
</head>
<body>
    <div class="row">
        <div class="md:col-12">
        <div class="card p-4 max-w-50p mx-auto">
            <h2>Login</h2>
            <?php if ($loginError): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($loginError); ?></div>
            <?php endif; ?>
            <form method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
        </div>
    </div>
</body>
</html>