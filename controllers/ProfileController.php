<?php
require_once __DIR__ . '/../models/User.php';

class ProfileController
{
    private function requireLogin(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }
    }

    public function show(): void
    {
        $this->requireLogin();

        $userModel = new User();
        $user = $userModel->findById((int)$_SESSION['user_id']);

        if (!$user) {
            $_SESSION['errors'] = ["User not found."];
            header("Location: index.php?page=dashboard");
            exit;
        }

        require_once __DIR__ . '/../views/profile/show.php';
    }

    public function update(): void
    {
        $this->requireLogin();

        $name  = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        $errors = [];
        if ($name === '') $errors[] = "Name is required.";
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";

        $userModel = new User();

        // If email changed, prevent duplicates
        $current = $userModel->findById((int)$_SESSION['user_id']);
        if (!$current) $errors[] = "User not found.";

        if ($current && $email !== $current['email'] && $userModel->emailExists($email)) {
            $errors[] = "Email already exists.";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: index.php?page=profile");
            exit;
        }

        $ok = $userModel->updateProfile((int)$_SESSION['user_id'], $name, $email, $phone);

        // keep session name in sync
        $_SESSION['name'] = $name;

        $_SESSION['success'] = $ok ? "Profile updated." : "Profile update failed.";
        header("Location: index.php?page=profile");
        exit;
    }

    public function showPassword(): void
    {
        $this->requireLogin();
        require_once __DIR__ . '/../views/profile/password.php';
    }

    public function updatePassword(): void
    {
        $this->requireLogin();

        $currentPass = $_POST['current_password'] ?? '';
        $newPass     = $_POST['new_password'] ?? '';
        $confirm     = $_POST['confirm_password'] ?? '';

        $errors = [];
        if ($currentPass === '') $errors[] = "Current password is required.";
        if (strlen($newPass) < 6) $errors[] = "New password must be at least 6 characters.";
        if ($newPass !== $confirm) $errors[] = "New passwords do not match.";

        $userModel = new User();
        $user = $userModel->findById((int)$_SESSION['user_id']);

        if (!$user) $errors[] = "User not found.";
        if ($user && !password_verify($currentPass, $user['password_hash'])) {
            $errors[] = "Current password is incorrect.";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: index.php?page=password");
            exit;
        }

        $hash = password_hash($newPass, PASSWORD_DEFAULT);
        $ok = $userModel->updatePasswordHash((int)$_SESSION['user_id'], $hash);

        $_SESSION['success'] = $ok ? "Password updated successfully." : "Password update failed.";
        header("Location: index.php?page=password");
        exit;
    }

    public function delete(): void
    {
        $this->requireLogin();

        $userModel = new User();
        $ok = $userModel->deleteById((int)$_SESSION['user_id']);

        // logout no matter what
        session_unset();
        session_destroy();

        header("Location: index.php?page=login");
        exit;
    }
}
