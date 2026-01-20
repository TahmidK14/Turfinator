<?php
require_once __DIR__ . '/../models/User.php';

class CustomerListController
{
    private function requireManager(): void
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'manager') {
            header("Location: index.php?page=login");
            exit;
        }
    }

    public function index(): void
    {
        $this->requireManager();

        $userModel = new User();
        $customers = $userModel->getCustomersByManager((int)$_SESSION['user_id']);

        require_once __DIR__ . '/../views/manager/customers.php';
    }
}
