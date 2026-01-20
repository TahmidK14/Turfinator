<?php
require_once __DIR__ . '/../models/Turf.php';

class HomeController
{
    public function index(): void
    {
        $turfModel = new Turf();

        // ✅ use the methods that exist in Turf.php
        $featured = $turfModel->getFeaturedActiveTurfs(6);
        $turfs    = $turfModel->getActiveTurfs();

        require_once __DIR__ . '/../views/home.php';
    }
}
