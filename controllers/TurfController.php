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

    // Upload helper (returns filename or null)
    private function uploadImage(string $field): ?string
    {
        if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $tmp  = $_FILES[$field]['tmp_name'];
        $size = (int)($_FILES[$field]['size'] ?? 0);

        // 2MB max
        if ($size <= 0 || $size > 2 * 1024 * 1024) {
            return null;
        }

        $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($ext, $allowed, true)) {
            return null;
        }

        $newName = 'turf_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;

        $destDir = __DIR__ . '/../public/assets/turfs/uploads/';
        if (!is_dir($destDir)) {
            mkdir($destDir, 0777, true);
        }

        if (!move_uploaded_file($tmp, $destDir . $newName)) {
            return null;
        }

        return $newName;
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
        if (!in_array($status, ['active', 'inactive'], true)) $errors[] = "Invalid status.";

        // ✅ REQUIRED image on create
        if (!isset($_FILES['image']) || ($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            $errors[] = "Turf image is required.";
        }

        $image = null;
        if (empty($errors)) {
            $image = $this->uploadImage('image');
            if ($image === null) {
                $errors[] = "Invalid image. Upload JPG/PNG/WEBP (max 2MB).";
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: index.php?page=turf-create");
            exit;
        }

        $turfModel = new Turf();

        // ⚠️ IMPORTANT: Turf::create() must accept $image and insert into DB.
        $ok = $turfModel->create(
            (int)$_SESSION['user_id'],
            $name,
            $location,
            (float)$price,
            $description,
            $status,
            $image
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
        if (!in_array($status, ['active', 'inactive'], true)) $errors[] = "Invalid status.";

        // Image OPTIONAL on update: only upload if provided
        $newImage = null;
        if (isset($_FILES['image']) && ($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
            $newImage = $this->uploadImage('image');
            if ($newImage === null) {
                $errors[] = "Invalid image. Upload JPG/PNG/WEBP (max 2MB).";
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: index.php?page=turf-edit&id=" . $id);
            exit;
        }

        $turfModel = new Turf();

        // ⚠️ If you want image update support, your Turf::update() must accept $newImage (nullable)
        // For now, keep your old update() call:
        $ok = $turfModel->update(
            $id,
            (int)$_SESSION['user_id'],
            $name,
            $location,
            (float)$price,
            $description,
            $status
        );

        // If you want to actually save $newImage in DB on edit, tell me and I’ll patch Turf::update() too.

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
