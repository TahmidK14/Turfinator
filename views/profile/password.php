<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="page stack">

<h2>Change Password</h2>

<?php
if (!empty($_SESSION['success'])) { echo "<p>".$_SESSION['success']."</p>"; unset($_SESSION['success']); }
if (!empty($_SESSION['errors'])) {
  echo "<ul>";
  foreach ($_SESSION['errors'] as $e) echo "<li>$e</li>";
  echo "</ul>";
  unset($_SESSION['errors']);
}
?>

<form method="POST" action="index.php?page=password-update" id="passwordForm">
  <label>Current Password</label><br>
  <input type="password" name="current_password" required><br><br>

  <label>New Password</label><br>
  <input type="password" name="new_password" required><br><br>

  <label>Confirm New Password</label><br>
  <input type="password" name="confirm_password" required><br><br>

  <button type="submit">Update Password</button>
</form>

<p>
  <a href="index.php?page=profile">Back to Profile</a> |
  <a href="index.php?page=dashboard">Back to Dashboard</a>
</p>

<script src="assets/app.js" defer></script>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
