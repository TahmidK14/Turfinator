<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Turf Details</h2>

<p><b>Name:</b> <?php echo htmlspecialchars($turf['name']); ?></p>
<p><b>Location:</b> <?php echo htmlspecialchars($turf['location']); ?></p>
<p><b>Price per hour:</b> <?php echo number_format((float)$turf['price_per_hour'], 2); ?></p>
<p><b>Status:</b> <?php echo htmlspecialchars($turf['status']); ?></p>

<?php if (!empty($turf['description'])): ?>
  <p><b>Description:</b> <?php echo nl2br(htmlspecialchars($turf['description'])); ?></p>
<?php endif; ?>

<hr>

<hr>
<h3>Book This Turf</h3>

<?php
if (!empty($_SESSION['success'])) { echo "<p>".$_SESSION['success']."</p>"; unset($_SESSION['success']); }
if (!empty($_SESSION['errors'])) {
  echo "<ul>";
  foreach ($_SESSION['errors'] as $e) echo "<li>$e</li>";
  echo "</ul>";
  unset($_SESSION['errors']);
}
?>
<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'customer'): ?>
<form method="POST" action="index.php?page=booking-create" id="bookingForm">
  <input type="hidden" name="turf_id" value="<?php echo $turf['id']; ?>">

  <label>Date:</label><br>
  <input type="date" name="booking_date" required><br><br>

  <label>Start Time:</label><br>
  <input type="time" name="start_time" required><br><br>

  <label>End Time:</label><br>
  <input type="time" name="end_time" required><br><br>

  <button type="submit">Place Booking</button>
</form>
<?php else: ?>
  <div class="card" style="margin-top:12px;">
    Booking is available for customers only.
  </div>
<?php endif; ?>

<p>
  <a href="index.php?page=turfs">← Back to Turfs</a>
</p>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
