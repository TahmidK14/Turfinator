<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="page stack">

<h2>Manage Turfs</h2>

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
  <a href="index.php?page=turf-create">+ Add New Turf</a> |
  <a href="index.php?page=dashboard">Back to Dashboard</a> |
  <a href="index.php?page=logout">Logout</a>
</p>

<table border="1" cellpadding="8">
  <tr>
    <th>ID</th><th>Name</th><th>Location</th><th>Price/hr</th><th>Status</th><th>Actions</th>
  </tr>
  <?php foreach ($turfs as $t): ?>
    <tr>
      <td><?php echo $t['id']; ?></td>
      <td><?php echo htmlspecialchars($t['name']); ?></td>
      <td><?php echo htmlspecialchars($t['location']); ?></td>
      <td><?php echo number_format((float)$t['price_per_hour'], 2); ?></td>
      <td><?php echo htmlspecialchars($t['status']); ?></td>
      <td>
        <a href="index.php?page=turf-edit&id=<?php echo $t['id']; ?>">Edit</a> |
        <a href="index.php?page=turf-delete&id=<?php echo $t['id']; ?>" onclick="return confirm('Delete this turf?');">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
