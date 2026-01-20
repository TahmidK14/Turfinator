<?php
require_once __DIR__ . '/Database.php';

class User
{
    private mysqli $db;

    public function __construct()
    {
        $this->db = Database::conn();
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows > 0;
    }

    public function create(string $name, string $email, string $phone, string $hash, string $role): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO users (name, email, phone, password_hash, role) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssss", $name, $email, $phone, $hash, $role);
        return $stmt->execute();
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = $res->fetch_assoc();
        return $user ?: null;
    }
    public function getManagers(): array
    {
        $stmt = $this->db->prepare("SELECT id, name, email, phone, created_at FROM users WHERE role='manager' ORDER BY id DESC");
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT id, name, email, phone, role, password_hash, created_at FROM users WHERE id=? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        return $row ?: null;
    }
    
    public function updateProfile(int $id, string $name, string $email, string $phone): bool
    {
        $stmt = $this->db->prepare("UPDATE users SET name=?, email=?, phone=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $email, $phone, $id);
        $stmt->execute();
        return $stmt->affected_rows >= 0;
    }
    
    public function updatePasswordHash(int $id, string $newHash): bool
    {
        $stmt = $this->db->prepare("UPDATE users SET password_hash=? WHERE id=?");
        $stmt->bind_param("si", $newHash, $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    
    public function deleteById(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    public function getCustomersByManager(int $managerId): array
    {
        $stmt = $this->db->prepare(
            "SELECT 
                u.id,
                u.name,
                u.email,
                u.phone,
                COUNT(b.id) AS bookings_count
             FROM users u
             INNER JOIN bookings b ON b.customer_id = u.id
             INNER JOIN turfs t ON t.id = b.turf_id
             WHERE t.manager_id = ?
             GROUP BY u.id, u.name, u.email, u.phone
             ORDER BY bookings_count DESC, u.name ASC"
        );
    
        $stmt->bind_param("i", $managerId);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }
        
        
}
