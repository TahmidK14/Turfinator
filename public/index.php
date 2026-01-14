<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();


// Simple page routing using query string
$page = $_GET['page'] ?? 'home';

switch ($page) 
{
    case 'home':
        require_once '../views/home.php';
        break;

    case 'register':
        require_once __DIR__ . '/../controllers/AuthController.php';
        (new AuthController())->showRegister();
        break;
    
    case 'register-submit':
        require_once __DIR__ . '/../controllers/AuthController.php';
        (new AuthController())->register();
        break;
    
    case 'login':
        require_once __DIR__ . '/../controllers/AuthController.php';
        (new AuthController())->showLogin();
        break;
    
    case 'login-submit':
        require_once __DIR__ . '/../controllers/AuthController.php';
        (new AuthController())->login();
        break;
    
    case 'logout':
        require_once __DIR__ . '/../controllers/AuthController.php';
        (new AuthController())->logout();
        break;

        case 'manager-create':
            require_once __DIR__ . '/../controllers/AdminController.php';
            (new AdminController())->showCreateManager();
            break;
        
        case 'manager-store':
            require_once __DIR__ . '/../controllers/AdminController.php';
            (new AdminController())->storeManager();
            break;
        
        case 'manager-list':
            require_once __DIR__ . '/../controllers/AdminController.php';
            (new AdminController())->listManagers();
            break;   
             
    case 'dashboard':
        require_once __DIR__ . '/../controllers/DashboardController.php';
        (new DashboardController())->index();
        break;
        default:
        echo "404 - Page not found";



    
}
