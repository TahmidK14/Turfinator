<?php

class DashboardController
{
    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $role = $_SESSION['role'] ?? 'customer';

        if ($role === 'admin') {
            require_once __DIR__ . '/../views/dashboard/admin.php';
        } elseif ($role === 'manager') {
            require_once __DIR__ . '/../views/dashboard/manager.php';
        } else {
            require_once __DIR__ . '/../views/dashboard/customer.php';
        }
        
    }
}
