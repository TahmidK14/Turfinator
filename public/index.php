<?php
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
        
    default:
        echo "404 - Page not found";
}
