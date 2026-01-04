<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();


// Simple page routing using query string
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        require_once '../views/home.php';
        break;

    case 'login':
        require_once '../views/auth/login.php';
        break;
        
    case 'register':
        require_once '../views/auth/register.php';
        break;
    case 'db-test':
        require_once '../models/Database.php';
        $conn = Database::conn();
        echo "DB Connected  (Server: " . $conn->host_info . ")";
        break;
        
    case 'logout':
        require_once '../views/auth/logout.php';
        break;
    default:
        echo "404 - Page not found";
}
