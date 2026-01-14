<?php
require_once __DIR__ . '/../models/Turf.php';

class TurfController
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

        $turfModel = new Turf();
        $turfs = $turfModel->getByManager((int)$_SESSION['user_id']);

        require_once __DIR__ . '/../views/turfs/manage.php';
    }

    public function create(): void
    {
        $this->requireManager();
        require_once __DIR__ . '/../views/turfs/create.php';
    }

    public function store(): void
    {
        $this->requireManager();

        $name = trim($_POST['name'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $price = trim($_POST['price_per_hour'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status = trim($_POST['status'] ?? 'active');

        $errors = [];

        if ($name === '') $errors[] = "Turf name is required.";
        if ($location === '') $errors[] = "Location is required.";
        if ($price === '' || !is_numeric($price) || (float)$price <= 0) $errors[] = "Price must be a positive number.";
        if (!in_array($status, ['active', 'inactive'])) $errors[] = "Invalid status.";

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: index.php?page=turf-create");
            exit;
        }

        $turfModel = new Turf();
        $ok = $turfModel->create(
            (int)$_SESSION['user_id'],
            $name,
            $location,
            (float)$price,
            $description,
            $status
        );

        $_SESSION['success'] = $ok ? "Turf added successfully." : "Failed to add turf.";
        header("Location: index.php?page=manager-turfs");
        exit;
    }

    public function edit(): void
    {
        $this->requireManager();

        $id = (int)($_GET['id'] ?? 0);
        $turfModel = new Turf();
        $turf = $turfModel->getOwnedById($id, (int)$_SESSION['user_id']);

        if (!$turf) {
            $_SESSION['errors'] = ["Turf not found or you don't have access."];
            header("Location: index.php?page=manager-turfs");
            exit;
        }

        require_once __DIR__ . '/../views/turfs/edit.php';
    }

    public function update(): void
    {
        $this->requireManager();

        $id = (int)($_POST['id'] ?? 0);

        $name = trim($_POST['name'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $price = trim($_POST['price_per_hour'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status = trim($_POST['status'] ?? 'active');

        $errors = [];

        if ($id <= 0) $errors[] = "Invalid turf ID.";
        if ($name === '') $errors[] = "Turf name is required.";
        if ($location === '') $errors[] = "Location is required.";
        if ($price === '' || !is_numeric($price) || (float)$price <= 0) $errors[] = "Price must be a positive number.";
        if (!in_array($status, ['active', 'inactive'])) $errors[] = "Invalid status.";

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: index.php?page=turf-edit&id=" . $id);
            exit;
        }

        $turfModel = new Turf();
        $ok = $turfModel->update(
            $id,
            (int)$_SESSION['user_id'],
            $name,
            $location,
            (float)$price,
            $description,
            $status
        );

        $_SESSION['success'] = $ok ? "Turf updated successfully." : "Failed to update turf.";
        header("Location: index.php?page=manager-turfs");
        exit;
    }

    public function delete(): void
    {
        $this->requireManager();

        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['errors'] = ["Invalid turf ID."];
            header("Location: index.php?page=manager-turfs");
            exit;
        }

        $turfModel = new Turf();
        $ok = $turfModel->delete($id, (int)$_SESSION['user_id']);

        $_SESSION['success'] = $ok ? "Turf deleted." : "Failed to delete turf.";
        header("Location: index.php?page=manager-turfs");
        exit;
    }
}
