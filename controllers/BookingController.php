<?php
require_once __DIR__ . '/../models/Booking.php';
require_once __DIR__ . '/../models/Turf.php';

class BookingController
{
    private function requireLogin(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }
    }

    private function requireCustomer(): void
    {
        $this->requireLogin();
        if (($_SESSION['role'] ?? '') !== 'customer') {
            header("Location: index.php?page=dashboard");
            exit;
        }
    }

    private function requireManager(): void
    {
        $this->requireLogin();
        if (($_SESSION['role'] ?? '') !== 'manager') {
            header("Location: index.php?page=dashboard");
            exit;
        }
    }

    public function create(): void
    {
        $this->requireCustomer();

        $turfId = (int)($_POST['turf_id'] ?? 0);
        $date   = trim($_POST['booking_date'] ?? '');
        $start  = trim($_POST['start_time'] ?? '');
        $end    = trim($_POST['end_time'] ?? '');

        $errors = [];

        if ($turfId <= 0) $errors[] = "Invalid turf.";
        if ($date === '') $errors[] = "Date is required.";
        if ($start === '' || $end === '') $errors[] = "Start and end time are required.";

        // Basic time rule: end must be after start
        if ($start !== '' && $end !== '' && strtotime($end) <= strtotime($start)) {
            $errors[] = "End time must be after start time.";
        }

        // Turf must exist and be active
        $turfModel = new Turf();
        $turf = $turfModel->getActiveTurfById($turfId);
        if (!$turf) $errors[] = "Turf not found.";

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: index.php?page=turf-details&id=" . $turfId);
            exit;
        }

        $bookingModel = new Booking();

        if (!$bookingModel->isSlotAvailable($turfId, $date, $start, $end)) {
            $_SESSION['errors'] = ["This time slot is already booked. Try another time."];
            header("Location: index.php?page=turf-details&id=" . $turfId);
            exit;
        }

        $ok = $bookingModel->create($turfId, (int)$_SESSION['user_id'], $date, $start, $end);

        $_SESSION['success'] = $ok ? "Booking placed (pending approval)." : "Booking failed.";
        header("Location: index.php?page=my-bookings");
        exit;
    }

    public function myBookings(): void
    {
        $this->requireCustomer();

        $bookingModel = new Booking();
        $bookings = $bookingModel->getByCustomer((int)$_SESSION['user_id']);

        require_once __DIR__ . '/../views/bookings/my_bookings.php';
    }

    public function cancelByCustomer(): void
    {
        $this->requireCustomer();

        $id = (int)($_POST['booking_id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['errors'] = ["Invalid booking id."];
            header("Location: index.php?page=my-bookings");
            exit;
        }

        $bookingModel = new Booking();
        $ok = $bookingModel->cancelCustomerBooking($id, (int)$_SESSION['user_id']);

        $_SESSION['success'] = $ok ? "Booking cancelled." : "Could not cancel booking.";
        header("Location: index.php?page=my-bookings");
        exit;
    }

    public function manage(): void
    {
        $this->requireManager();

        $bookingModel = new Booking();
        $bookings = $bookingModel->getForManager((int)$_SESSION['user_id']);

        require_once __DIR__ . '/../views/bookings/manage.php';
    }

    public function approve(): void
    {
        $this->requireManager();

        $id = (int)($_POST['booking_id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['errors'] = ["Invalid booking id."];
            header("Location: index.php?page=manage-bookings");
            exit;
        }

        $bookingModel = new Booking();
        $ok = $bookingModel->approve($id, (int)$_SESSION['user_id']);

        $_SESSION['success'] = $ok ? "Booking approved." : "Could not approve booking.";
        header("Location: index.php?page=manage-bookings");
        exit;
    }

    public function cancelByManager(): void
    {
        $this->requireManager();

        $id = (int)($_POST['booking_id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['errors'] = ["Invalid booking id."];
            header("Location: index.php?page=manage-bookings");
            exit;
        }

        $bookingModel = new Booking();
        $ok = $bookingModel->cancelByManager($id, (int)$_SESSION['user_id']);

        $_SESSION['success'] = $ok ? "Booking cancelled." : "Could not cancel booking.";
        header("Location: index.php?page=manage-bookings");
        exit;
    }
}
