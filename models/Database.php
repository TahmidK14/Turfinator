<?php
// models/Database.php

class Database
{
    private static ?mysqli $conn = null;

    public static function conn(): mysqli
    {
        if (self::$conn !== null) {
            return self::$conn;
        }

        $cfg = require __DIR__ . '/../config/database.php';

        $conn = new mysqli($cfg['host'], $cfg['user'], $cfg['pass'], $cfg['name']);

        if ($conn->connect_error) {
            die("DB Connection failed: " . $conn->connect_error);
        }

        // Use utf8mb4 for safety with all characters
        $conn->set_charset("utf8mb4");

        self::$conn = $conn;
        return self::$conn;
    }
}
