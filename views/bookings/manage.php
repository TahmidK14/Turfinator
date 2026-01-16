<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Manage Bookings</h2>

<?php
if (!empty($_SESSION['success'])) { echo "<p>".$_SESSION['success']."</p>"; unset($_SESSION['success']); }
if (!empty($_SESSION['errors'])) {
  echo "<ul>";
  foreach ($_SESSION['errors'] as $e) echo "<li>$e</li>";
  echo "</ul>";
  unset($_SESSION['errors']);
}
?>

<p>
  <a href="index.php?page=dashboard">Dashboard</a> |
  <a href="index.php?page=manager-turfs">Manage Turfs</a> |
  <a href="index.php?page=logout">Logout</a>
</p>

<table border="1" cellpadding="8">
  <tr>
    <th>Turf</th><th>Customer</th><th>Email</th><th>Date</th><th>Start</th><th>End</th><th>Status</th><th>Actions</th>
  </tr>

  <?php if (empty($bookings)): ?>
    <tr><td colspan="8">No bookings found.</td></tr>
  <?php endif; ?>

  <?php foreach ($bookings as $b): ?>
    <tr>
      <td><?php echo htmlspecialchars($b['turf_name']); ?></td>
      <td><?php echo htmlspecialchars($b['customer_name']); ?></td>
      <td><?php echo htmlspecialchars($b['customer_email']); ?></td>
      <td><?php echo htmlspecialchars($b['booking_date']); ?></td>
      <td><?php echo htmlspecialchars($b['start_time']); ?></td>
      <td><?php echo htmlspecialchars($b['end_time']); ?></td>
      <td><?php echo htmlspecialchars($b['status']); ?></td>
      <td>
        <?php if ($b['status'] === 'pending'): ?>
          <form method="POST" action="index.php?page=booking-approve" style="display:inline;">
            <input type="hidden" name="booking_id" value="<?php echo $b['id']; ?>">
            <button type="submit">Approve</button>
          </form>
        <?php endif; ?>

        <?php if ($b['status'] !== 'cancelled'): ?>
          <form method="POST" action="index.php?page=booking-cancel-manager" style="display:inline;">
            <input type="hidden" name="booking_id" value="<?php echo $b['id']; ?>">
            <button type="submit" onclick="return confirm('Cancel this booking?');">Cancel</button>
          </form>
        <?php else: ?>
          -
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
