<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="page stack">

<h2>Manager Dashboard</h2>
<p>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>

<ul>
  <li><a href="index.php?page=manager-turfs">Manage Turfs</a></li>
  <li><a href="index.php?page=turf-create">Add Turf</a></li>
  <li><a href="index.php?page=manage-bookings">Manage Bookings</a></li>
  <li><a href="index.php?page=profile">My Profile</a></li>
  <li><a href="index.php?page=manager-customers">View Customer List</a></li>
  <li><a href="index.php?page=logout">Logout</a></li>
</ul>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
