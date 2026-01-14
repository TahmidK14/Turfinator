<?php
require_once __DIR__ . '/../models/User.php';

class AdminController
{
    private function requireAdmin(): void
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header("Location: index.php?page=login");
            exit;
        }
    }

    public function showCreateManager(): void
    {
        $this->requireAdmin();
        require_once __DIR__ . '/../views/admin/create_manager.php';
    }

    public function storeManager(): void
    {
        $this->requireAdmin();

        $name  = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $pass  = $_POST['password'] ?? '';

        $errors = [];
        if ($name === '') $errors[] = "Name is required";
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
        if (strlen($pass) < 6) $errors[] = "Password must be at least 6 characters";

        $userModel = new User();

        if ($userModel->emailExists($email)) $errors[] = "Email already exists";

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: index.php?page=manager-create");
            exit;
        }

        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $ok = $userModel->create($name, $email, $phone, $hash, 'manager');

        if (!$ok) {
            $_SESSION['errors'] = ["Could not create manager."];
            header("Location: index.php?page=manager-create");
            exit;
        }

        $_SESSION['success'] = "Manager created successfully.";
        header("Location: index.php?page=manager-list");
        exit;
    }

    public function listManagers(): void
    {
        $this->requireAdmin();

        $userModel = new User();
        $managers = $userModel->getManagers();

        require_once __DIR__ . '/../views/admin/manager_list.php';
    }
}
