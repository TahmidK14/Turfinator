<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Managers</h2>

<?php
if (!empty($_SESSION['success'])) { echo "<p>".$_SESSION['success']."</p>"; unset($_SESSION['success']); }
?>

<table border="1" cellpadding="8">
  <tr>
    <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Created</th>
  </tr>
  <?php foreach ($managers as $m): ?>
    <tr>
      <td><?php echo $m['id']; ?></td>
      <td><?php echo htmlspecialchars($m['name']); ?></td>
      <td><?php echo htmlspecialchars($m['email']); ?></td>
      <td><?php echo htmlspecialchars($m['phone']); ?></td>
      <td><?php echo $m['created_at']; ?></td>
    </tr>
  <?php endforeach; ?>
</table>

<p><a href="index.php?page=manager-create">Add another manager</a></p>
<p><a href="index.php?page=dashboard">Back to Dashboard</a></p>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
