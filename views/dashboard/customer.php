<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="page stack">

<h2>Customer Dashboard</h2>
<p>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>

<ul>
  <li><a href="index.php?page=profile">My Profile</a></li>
  <li><a href="index.php?page=turfs">Search Turfs</a></li>
  <li><a href="index.php?page=my-bookings">My Bookings</a></li>
  <li><a href="index.php?page=logout">Logout</a></li>
</ul>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
