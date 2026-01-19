<?php
require_once __DIR__ . '/Database.php';

class Turf
{
    private mysqli $db;

    public function __construct()
    {
        $this->db = Database::conn();
    }

    public function getByManager(int $managerId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM turfs WHERE manager_id = ? ORDER BY id DESC");
        $stmt->bind_param("i", $managerId);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function create(int $managerId, string $name, string $location, float $price, string $description, string $status): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO turfs (manager_id, name, location, price_per_hour, description, status)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("issdss", $managerId, $name, $location, $price, $description, $status);
        return $stmt->execute();
    }

    public function getOwnedById(int $turfId, int $managerId): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM turfs WHERE id = ? AND manager_id = ? LIMIT 1");
        $stmt->bind_param("ii", $turfId, $managerId);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        return $row ?: null;
    }

    public function update(int $turfId, int $managerId, string $name, string $location, float $price, string $description, string $status): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE turfs
             SET name=?, location=?, price_per_hour=?, description=?, status=?
             WHERE id=? AND manager_id=?"
        );
        $stmt->bind_param("ssdssii", $name, $location, $price, $description, $status, $turfId, $managerId);
        return $stmt->execute();
    }

    public function delete(int $turfId, int $managerId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM turfs WHERE id=? AND manager_id=?");
        $stmt->bind_param("ii", $turfId, $managerId);
        return $stmt->execute();
    }
    public function getActiveTurfs(string $q = ''): array
    {
        $q = trim($q);
    
        if ($q === '') {
            $stmt = $this->db->prepare("SELECT * FROM turfs WHERE status='active' ORDER BY id DESC");
            $stmt->execute();
            $res = $stmt->get_result();
            return $res->fetch_all(MYSQLI_ASSOC);
        }
    
        $like = "%" . $q . "%";
        $stmt = $this->db->prepare(
            "SELECT * FROM turfs
             WHERE status='active' AND (name LIKE ? OR location LIKE ?)
             ORDER BY id DESC"
        );
        $stmt->bind_param("ss", $like, $like);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getActiveTurfById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM turfs WHERE id=? AND status='active' LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        return $row ?: null;
    }
    public function getFeaturedActiveTurfs(int $limit = 6): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM turfs WHERE status='active' AND featured=1 ORDER BY id DESC LIMIT ?"
        );
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }
        
}
