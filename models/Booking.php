<?php
require_once __DIR__ . '/Database.php';

class Booking
{
    private mysqli $db;

    public function __construct()
    {
        $this->db = Database::conn();
    }

    // Overlap rule: if requested [start,end] overlaps an existing booking that is pending/approved, block it
    public function isSlotAvailable(int $turfId, string $date, string $start, string $end): bool
    {
        $sql = "
            SELECT id
            FROM bookings
            WHERE turf_id = ?
              AND booking_date = ?
              AND status IN ('pending','approved')
              AND (start_time < ? AND end_time > ?)
            LIMIT 1
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("isss", $turfId, $date, $end, $start);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows === 0;
    }

    public function create(int $turfId, int $customerId, string $date, string $start, string $end): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO bookings (turf_id, customer_id, booking_date, start_time, end_time, status)
             VALUES (?, ?, ?, ?, ?, 'pending')"
        );
        $stmt->bind_param("iisss", $turfId, $customerId, $date, $start, $end);
        return $stmt->execute();
    }

    public function getByCustomer(int $customerId): array
    {
        $sql = "
            SELECT b.*, t.name AS turf_name, t.location, t.price_per_hour
            FROM bookings b
            JOIN turfs t ON t.id = b.turf_id
            WHERE b.customer_id = ?
            ORDER BY b.id DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function cancelCustomerBooking(int $bookingId, int $customerId): bool
    {
        // Customer can cancel only their own booking if not already cancelled
        $stmt = $this->db->prepare(
            "UPDATE bookings
             SET status='cancelled'
             WHERE id=? AND customer_id=? AND status IN ('pending','approved')"
        );
        $stmt->bind_param("ii", $bookingId, $customerId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function getForManager(int $managerId): array
    {
        // Manager sees bookings only for their turfs
        $sql = "
            SELECT b.*, t.name AS turf_name, t.location, u.name AS customer_name, u.email AS customer_email
            FROM bookings b
            JOIN turfs t ON t.id = b.turf_id
            JOIN users u ON u.id = b.customer_id
            WHERE t.manager_id = ?
            ORDER BY b.id DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $managerId);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function approve(int $bookingId, int $managerId): bool
    {
        // Only approve if booking belongs to manager's turf AND currently pending
        $sql = "
            UPDATE bookings b
            JOIN turfs t ON t.id = b.turf_id
            SET b.status='approved'
            WHERE b.id=? AND t.manager_id=? AND b.status='pending'
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $bookingId, $managerId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function cancelByManager(int $bookingId, int $managerId): bool
    {
        $sql = "
            UPDATE bookings b
            JOIN turfs t ON t.id = b.turf_id
            SET b.status='cancelled'
            WHERE b.id=? AND t.manager_id=? AND b.status IN ('pending','approved')
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $bookingId, $managerId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
