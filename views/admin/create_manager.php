<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Create Manager</h2>

<?php
if (!empty($_SESSION['success'])) { echo "<p>".$_SESSION['success']."</p>"; unset($_SESSION['success']); }
if (!empty($_SESSION['errors'])) {
  echo "<ul>";
  foreach ($_SESSION['errors'] as $e) echo "<li>$e</li>";
  echo "</ul>";
  unset($_SESSION['errors']);
}
?>

<form method="POST" action="index.php?page=manager-store">
  <input type="text" name="name" placeholder="Manager Name" required><br><br>
  <input type="email" name="email" placeholder="Manager Email" required><br><br>
  <input type="text" name="phone" placeholder="Phone"><br><br>
  <input type="password" name="password" placeholder="Temp Password" required><br><br>
  <button type="submit">Create Manager</button>
</form>

<p><a href="index.php?page=dashboard">Back to Dashboard</a></p>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
