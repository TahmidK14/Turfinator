<?php
require_once __DIR__ . '/../models/Turf.php';

class CustomerTurfController
{
    private function requireLogin(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }
    }

    public function index(): void
    {
        $this->requireLogin();

        $q = trim($_GET['q'] ?? '');

        $turfModel = new Turf();
        $turfs = $turfModel->getActiveTurfs($q);

        require_once __DIR__ . '/../views/customer/turfs.php';
    }

    public function show(): void
    {
        $this->requireLogin();

        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['errors'] = ["Invalid turf id"];
            header("Location: index.php?page=turfs");
            exit;
        }

        $turfModel = new Turf();
        $turf = $turfModel->getActiveTurfById($id);

        if (!$turf) {
            $_SESSION['errors'] = ["Turf not found"];
            header("Location: index.php?page=turfs");
            exit;
        }

        require_once __DIR__ . '/../views/customer/turf_details.php';
    }
}
