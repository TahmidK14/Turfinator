<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Manager Dashboard</h2>
<p>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>

<ul>
  <li><a href="#">Add Turf</a></li>
  <li><a href="#">Manage Turfs</a></li>
  <li><a href="#">Manage Bookings</a></li>
  <li><a href="#">Customer List</a></li>
  <li><a href="index.php?page=logout">Logout</a></li>
</ul>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
