<?php
class SessionManager {
    public static function startSession() {
        session_start();
        
        // Regenerate session ID every 5 minutes
        if (!isset($_SESSION['last_regeneration'])) {
            $_SESSION['last_regeneration'] = time();
        } elseif (time() - $_SESSION['last_regeneration'] > 300) { 
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = time();
        }

        // Check for inactivity timeout (30 minutes)
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) { 
            self::destroySession();
            header("Location: login.php");
            exit();
        }

        $_SESSION['last_activity'] = time();
    }

    public static function destroySession() {
        session_unset();
        session_destroy();
    }
}
?>
