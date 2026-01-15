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

<h3>Booking (Next Step)</h3>
<p>We will add the booking form here next.</p>

<p>
  <a href="index.php?page=turfs">← Back to Turfs</a>
</p>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
