<?php
require_once __DIR__ . '/../models/Turf.php';

class ApiController
{
    public function turfs(): void
    {
        if (ob_get_length()) {
            ob_clean();
        }

        header('Content-Type: application/json; charset=utf-8');

        if (!isset($_SESSION['user_id'])) {
            echo json_encode([]);
            exit;
        }

        $q = trim($_GET['q'] ?? '');

        $turfModel = new Turf();
        $turfs = $turfModel->getActiveTurfs($q);

        echo json_encode($turfs);
        exit;
    }
}
