<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Admin Dashboard</h2>
<p>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>

<ul>
  <li><a href="index.php?page=manager-create">Add Manager</a></li>
  <li><a href="index.php?page=manager-list">View Managers</a></li>
  <li><a href="index.php?page=logout">Logout</a></li>
</ul>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
