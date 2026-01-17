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

    case 'manager-turfs':
        require_once __DIR__ . '/../controllers/TurfController.php';
        (new TurfController())->index();
        break;

    case 'turf-create':
        require_once __DIR__ . '/../controllers/TurfController.php';
        (new TurfController())->create();
        break;

    case 'turf-store':
        require_once __DIR__ . '/../controllers/TurfController.php';
        (new TurfController())->store();
        break;

    case 'turf-edit':
        require_once __DIR__ . '/../controllers/TurfController.php';
        (new TurfController())->edit();
        break;

    case 'turf-update':
        require_once __DIR__ . '/../controllers/TurfController.php';
        (new TurfController())->update();
        break;

    case 'turf-delete':
        require_once __DIR__ . '/../controllers/TurfController.php';
        (new TurfController())->delete();
        break;

    case 'turfs':
        require_once __DIR__ . '/../controllers/CustomerTurfController.php';
        (new CustomerTurfController())->index();
        break;

    case 'turf-details':
        require_once __DIR__ . '/../controllers/CustomerTurfController.php';
        (new CustomerTurfController())->show();
        break;

    case 'booking-create':
        require_once __DIR__ . '/../controllers/BookingController.php';
        (new BookingController())->create();
        break;

    case 'my-bookings':
        require_once __DIR__ . '/../controllers/BookingController.php';
        (new BookingController())->myBookings();
        break;

    case 'booking-cancel':
        require_once __DIR__ . '/../controllers/BookingController.php';
        (new BookingController())->cancelByCustomer();
        break;

    case 'manage-bookings':
        require_once __DIR__ . '/../controllers/BookingController.php';
        (new BookingController())->manage();
        break;

    case 'booking-approve':
        require_once __DIR__ . '/../controllers/BookingController.php';
        (new BookingController())->approve();
        break;

    case 'booking-cancel-manager':
        require_once __DIR__ . '/../controllers/BookingController.php';
        (new BookingController())->cancelByManager();
        break;

    case 'dashboard':
        require_once __DIR__ . '/../controllers/DashboardController.php';
        (new DashboardController())->index();
        break;
        case 'api-turfs':
            require_once __DIR__ . '/../controllers/ApiController.php';
            (new ApiController())->turfs();
            break;
            case 'profile':
                require_once __DIR__ . '/../controllers/ProfileController.php';
                (new ProfileController())->show();
                break;
            
            case 'profile-update':
                require_once __DIR__ . '/../controllers/ProfileController.php';
                (new ProfileController())->update();
                break;
            
            case 'password':
                require_once __DIR__ . '/../controllers/ProfileController.php';
                (new ProfileController())->showPassword();
                break;
            
            case 'password-update':
                require_once __DIR__ . '/../controllers/ProfileController.php';
                (new ProfileController())->updatePassword();
                break;
            
            case 'account-delete':
                require_once __DIR__ . '/../controllers/ProfileController.php';
                (new ProfileController())->delete();
                break;
                
    
    default:
        echo "404 - Page not found";
}
