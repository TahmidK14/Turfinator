<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Edit Turf</h2>

<?php
if (!empty($_SESSION['errors'])) {
  echo "<ul>";
  foreach ($_SESSION['errors'] as $e) echo "<li>$e</li>";
  echo "</ul>";
  unset($_SESSION['errors']);
}
?>

<form method="POST" action="index.php?page=turf-update" id="turfForm">
  <input type="hidden" name="id" value="<?php echo $turf['id']; ?>">

  <input type="text" name="name" value="<?php echo htmlspecialchars($turf['name']); ?>" required><br><br>
  <input type="text" name="location" value="<?php echo htmlspecialchars($turf['location']); ?>" required><br><br>
  <input type="text" name="price_per_hour" value="<?php echo htmlspecialchars($turf['price_per_hour']); ?>" required><br><br>

  <textarea name="description" rows="4" cols="40"><?php echo htmlspecialchars($turf['description']); ?></textarea><br><br>

  <select name="status">
    <option value="active" <?php echo $turf['status']==='active'?'selected':''; ?>>Active</option>
    <option value="inactive" <?php echo $turf['status']==='inactive'?'selected':''; ?>>Inactive</option>
  </select><br><br>

  <button type="submit">Update</button>
</form>

<p><a href="index.php?page=manager-turfs">Back</a></p>

<script src="/assets/app.js"></script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
