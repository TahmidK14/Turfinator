<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Customer Dashboard</h2>
<p>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>

<ul>
<li><a href="index.php?page=turfs">Browse Turfs</a></li>

  <li><a href="#">My Bookings</a></li>
  <li><a href="index.php?page=logout">Logout</a></li>
</ul>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
