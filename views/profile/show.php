<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>My Profile</h2>

<?php
if (!empty($_SESSION['success'])) { echo "<p>".$_SESSION['success']."</p>"; unset($_SESSION['success']); }
if (!empty($_SESSION['errors'])) {
  echo "<ul>";
  foreach ($_SESSION['errors'] as $e) echo "<li>$e</li>";
  echo "</ul>";
  unset($_SESSION['errors']);
}
?>

<form method="POST" action="index.php?page=profile-update" id="profileForm">
  <label>Name</label><br>
  <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br><br>

  <label>Email</label><br>
  <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

  <label>Phone</label><br>
  <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>"><br><br>

  <button type="submit">Update Profile</button>
</form>

<hr>

<p>
  <a href="index.php?page=password">Change Password</a> |
  <a href="index.php?page=dashboard">Back to Dashboard</a> |
  <a href="index.php?page=logout">Logout</a>
</p>

<form method="POST" action="index.php?page=account-delete" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');">
  <button type="submit">Delete Account</button>
</form>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
