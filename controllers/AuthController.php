<?php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    public function showRegister(): void
    {
        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function showLogin(): void
    {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function register(): void
    {
        // Basic backend validation
        $name  = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $role  = trim($_POST['role'] ?? 'customer');
        $pass  = $_POST['password'] ?? '';
        $cpass = $_POST['confirm_password'] ?? '';

        $errors = [];

        if ($name === '') $errors[] = "Name is required";
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
        if (!in_array($role, ['manager','customer'])) $errors[] = "Invalid role";
        if (strlen($pass) < 6) $errors[] = "Password must be at least 6 characters";
        if ($pass !== $cpass) $errors[] = "Passwords do not match";

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: index.php?page=register");
            exit;
        }

        $userModel = new User();

        if ($userModel->emailExists($email)) {
            $_SESSION['errors'] = ["Email already exists"];
            header("Location: index.php?page=register");
            exit;
        }

        $hash = password_hash($pass, PASSWORD_DEFAULT);

        $created = $userModel->create($name, $email, $phone, $hash, $role);

        if (!$created) {
            $_SESSION['errors'] = ["Registration failed. Try again."];
            header("Location: index.php?page=register");
            exit;
        }

        $_SESSION['success'] = "Account created. Please login.";
        header("Location: index.php?page=login");
        exit;
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $pass  = $_POST['password'] ?? '';

        $errors = [];
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
        if ($pass === '') $errors[] = "Password is required";

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: index.php?page=login");
            exit;
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($pass, $user['password_hash'])) {
            $_SESSION['errors'] = ["Invalid email or password"];
            header("Location: index.php?page=login");
            exit;
        }

        // Session Auth
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role']    = $user['role'];
        $_SESSION['name']    = $user['name'];

        header("Location: index.php?page=dashboard");
        exit;
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }
}
