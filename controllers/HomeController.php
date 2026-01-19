<?php
require_once __DIR__ . '/../models/Turf.php';

class HomeController
{
    public function index(): void
    {
        $turfModel = new Turf();
        $turfs = $turfModel->getActiveTurfs(); // reuse existing method

        require_once __DIR__ . '/../views/home.php';
    }
}
